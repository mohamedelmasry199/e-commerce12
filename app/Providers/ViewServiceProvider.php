<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // share dashboad variables
        view()->composer('dashboard.*', function ($view) {
            if (!Cache::has('categories_count')) {
                Cache::remember('categories_count', 60, function () {
                    return Category::count();
                });
            }
            if (!Cache::has('brands_count')) {
                Cache::remember('brands_count', 60, function () {
                    return Brand::count();
                });
            }
            if (!Cache::has('admins_count')) {
                Cache::remember('admins_count', 60, function () {
                    return Admin::count();
                });
            }
            if (!Cache::has('coupons_count')) {
                Cache::remember('coupons_count', 60, function () {
                    return Coupon::count();
                });
            }
            if (!Cache::has('faqs_count')) {
                Cache::remember('faqs_count', 60, function () {
                    return Faq::count();
                });
            }







            view()->share([
                'categories_count' => Cache::get('categories_count'),
                'brands_count' => Cache::get('brands_count'),
                'admins_count' => Cache::get('admins_count'),
                'coupons_count' => Cache::get('coupons_count'),
                'faqs_count' => Cache::get('faqs_count'),

            ]);
        });
        $setting = $this->firstOrCreateSetting();
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
