<?php

namespace App\Providers;

use App\Models\PaymentSetting;
use App\Models\SocialLink;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $storeSettings = StoreSetting::pluck('value', 'key')->all();

            $paymentMethods = PaymentSetting::all()->keyBy('method');

            $socialLinks = SocialLink::active()->orderBy('sort_order')->get();

            $view->with('storeSettings', $storeSettings);
            $view->with('paymentMethods', $paymentMethods);
            $view->with('socialLinks', $socialLinks);
        });
    }
}
