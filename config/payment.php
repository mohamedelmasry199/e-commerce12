<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    | Change PAYMENT_GATEWAY in .env to switch gateways for the whole app.
    | Options: myfatoorah | fawry | paymob | stripe
    */
    'default' => env('PAYMENT_GATEWAY', 'myfatoorah'),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */
    'currency' => env('PAYMENT_CURRENCY', 'EGP'),

    /*
    |--------------------------------------------------------------------------
    | Shipping Price
    |--------------------------------------------------------------------------
    */
    // 'shipping_price' => env('SHIPPING_PRICE', 50.00),

    /*
    |--------------------------------------------------------------------------
    | Inventory Reservation Expiry (minutes)
    |--------------------------------------------------------------------------
    | Stock is reserved for this many minutes while the user completes payment.
    | After expiry, ReleaseExpiredReservationsJob restores the stock.
    */
    'reservation_minutes' => env('RESERVATION_MINUTES', 15),

    /*
    |--------------------------------------------------------------------------
    | MyFatoorah
    |--------------------------------------------------------------------------
    */
    'myfatoorah' => [
        'api_key' => env('MYFATOORAH_API_KEY'),
        'sandbox' => env('MYFATOORAH_SANDBOX', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Fawry (ready for future implementation)
    |--------------------------------------------------------------------------
    */
    // 'fawry' => [
    //     'merchant_code' => env('FAWRY_MERCHANT_CODE'),
    //     'security_key'  => env('FAWRY_SECURITY_KEY'),
    //     'sandbox'       => env('FAWRY_SANDBOX', true),
    // ],

];
