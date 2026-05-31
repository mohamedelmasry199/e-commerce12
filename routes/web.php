<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Webhooks\PaymentWebhookController;
use App\Http\Controllers\Website\BrandController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\Website\CheckoutController;
use App\Http\Controllers\Website\FaqController;
use App\Http\Controllers\Website\OrderController;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\ProfileController;
use App\Http\Controllers\Website\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
], function () {
    Auth::routes();

    Route::group([
        'as' => 'website.'
    ], function () {
        Route::get('/home', [HomeController::class, 'index'])
            ->name('home');
        Route::get('/', [HomeController::class, 'index'])
            ->name('home');

        ##pages
        Route::get('/page/{slug}', [PageController::class, 'show'])
            ->name('page.show');
        ##end pages
        Route::get('faqs',[FaqController::class, 'showFaqPage'])->name('faqs.index');

        ################################# Brands Routes ######################################
        Route::prefix('brands')->name('brands.')->controller(BrandController::class)->group(function () {
            Route::get('/',                  'getBrands')->name('index');
            Route::get('/{slug}/products',   'getProductsByBrand')->name('products');
        });
        ################################# Categories Routes ######################################
        Route::prefix('categories')->name('categories.')->controller(CategoryController::class)->group(function () {
            Route::get('/',   'getCategories')->name('index');
            Route::get('/{slug}/products', 'getProductsByCategory')->name('products');
        });

        ################################# Products Routes ######################################
        Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
            Route::get('/{type}',                  'getProductsByType')->name('by.type');
            Route::get('/show/{slug}',             'showProductPage')->name('show');
            Route::get('/{slug}/related-products', 'relatedProducts')->name('related');
        });


        Route::get('shop',           [HomeController::class, 'showShopPage'])->name('shop');

        ################################## Profile ####################################
        Route::group(['middleware' => 'auth:web'], function () {

            Route::get('/profile/{id}', [ProfileController::class, 'show'])
                ->name('profile.show');

                ##wishlist
            Route::get('wishlist',  WishlistController::class)->name('wishlist');
            ###end wishlist
            #### cart
                Route::get('cart', CartController::class)->name('cart');
            ### end cart
            #####orders
            Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');
            Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');
        ##end orders
            ##checkout
            Route::prefix('checkout')->name('checkout.')->controller(CheckoutController::class)->group(function () {
            Route::get('','showCheckoutPage')->name('get');
            Route::post('', 'checkout')->name('post');
    Route::post('/process', 'process')->name('process');
    Route::get('/callback',  'callback')->name('callback');

    // Step 3b: Payment failed or user cancelled at gateway
    Route::get('/failed',  'failed')->name('failed');

    // Step 4: Thank you / order confirmed page
    Route::get('/success/{order}',  'success')->name('success');


        });
        });
    });
});
include('dashboard.php');
//  --header 'accept: application/json' \
//      --header 'authorization: Bearer SK_KWT_vVZlnnAqu8jRByOWaRPNId4ShzEDNt256dvnjebuyzo52dXjAfRx2ixW5umjWSUx' \
//      --header 'content-type: application/json' \

Route::get('/test', function () {

    $response = Http::withHeaders([
        'Authorization' => 'Bearer SK_KWT_vVZlnnAqu8jRByOWaRPNId4ShzEDNt256dvnjebuyzo52dXjAfRx2ixW5umjWSUx',
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ])->timeout(100)->
    post('https://apitest.myfatoorah.com/v3/payments', [
        "Order" => [
            "Amount" => 20,
            "Currency"=> "EGP"

        ],

        "Customer" => [
            "Mobile" => [
                "CountryCode" => "+20",
                "Number" => "1020304050"
            ],
            "Email" => "example@gmail.com"
        ],

        "IntegrationUrls" => [
            "Redirection" => "https://your-website.com/payment-callback"
        ],

        "NotificationOption" => "ALL"

    ]);
dd($response->status(), $response->json());
    // return $response->json();
});
Route::prefix('webhooks/payment')->name('webhooks.payment.')->group(function () {

    Route::post('/myfatoorah', [PaymentWebhookController::class, 'myfatoorah'])
        ->name('myfatoorah')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    Route::post('/fawry', [PaymentWebhookController::class, 'fawry'])
        ->name('fawry')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
});
