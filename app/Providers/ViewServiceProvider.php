<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
use App\Services\Website\PageService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $pageService;
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */public function boot(PageService $pageService): void
{
    view()->composer('dashboard.*', function ($view) {

        $view->with([
            'categories_count' => Cache::remember('categories_count', 60, fn() => Category::count()),
            'brands_count'     => Cache::remember('brands_count', 60, fn() => Brand::count()),
            'admins_count'     => Cache::remember('admins_count', 60, fn() => Admin::count()),
            'users_count'      => Cache::remember('users_count', 60, fn() => User::count()),
            'coupons_count'    => Cache::remember('coupons_count', 60, fn() => Coupon::count()),
            'faqs_count'       => Cache::remember('faqs_count', 60, fn() => Faq::count()),
            'contacts_count'   => Cache::remember('contacts_count', 60, fn() => Contact::count()),
        ]);
    });

    view()->composer('website.*', function ($view) use ($pageService) {

        $view->with([
            'pages' => $pageService->getPages(),
        ]);
    });
$setting = Cache::rememberForever('setting', function () {
    return $this->firstOrCreateSetting();
});
    view()->share('setting', $setting);
}




    private function firstOrCreateSetting()
    {
        $settings = Setting::firstOrCreate([], [
            'site_name' => ['en' => 'My E-Commerce Site', 'ar' => 'موقعي للتجارة الإلكترونية'],
            'site_desc' => ['en' => 'Welcome to my e-commerce site.', 'ar' => 'مرحبًا بكم في موقعي للتجارة الإلكترونية.'],
            'site_phone' => '123-456-7890',
            'site_address' => ['en' => '123 Main St, City, Country', 'ar' => '١٢٣ الشارع الرئيسي، المدينة، البلد'],
            'site_email' => '<EMAIL>',
            'email_support' => '<EMAIL>',
            'facebook_url' => 'https://www.facebook.com',
            'twitter_url' => 'https://www.twitter.com',
            'youtube_url' => 'https://www.youtube.com',
            'promotion_video_url' => '',
            'site_copyright' => '© 2024 My E-Commerce Site. All rights reserved.',
            'logo' => 'logo.png',
            'favicon' => 'logo.png',
            'meta_description' => [
                'en' => '23 of PARAGE is equality of condition, blood, or dignity; specifically',
                'ar' => '23 of PARAGE is equality of condition, blood, or dignity; specifically ',
            ],
        ]);
        return $settings;

    }
}

