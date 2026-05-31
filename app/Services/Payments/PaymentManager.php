<?php

namespace App\Services\Payments;

// use App\Services\Payments\Drivers\FawryDriver;
use App\Contracts\PaymentGateway;
use App\Services\Payments\Drivers\MyFatoorahDriver;
use InvalidArgumentException;

/**
 * Central registry of all payment gateways.
 *
 * To add a new gateway:
 *  1. Create a driver in app/Services/Payments/Drivers/
 *  2. Implement App\Contracts\PaymentGateway
 *  3. Register it in the $drivers map below
 *  4. Change PAYMENT_GATEWAY in .env
 */
class PaymentManager
{
    /** @var array<string, class-string<PaymentGateway>> */
    protected array $drivers = [
        'myfatoorah' => MyFatoorahDriver::class,
        // 'fawry'      => FawryDriver::class,
        // 'paymob'  => PaymobDriver::class,
        // 'stripe'  => StripeDriver::class,
    ];

    public function driver(string $name): PaymentGateway
    {
        if (! isset($this->drivers[$name])) {
            throw new InvalidArgumentException(
                "Payment gateway [{$name}] is not registered. Available: "
                . implode(', ', array_keys($this->drivers))
            );
        }

        return app($this->drivers[$name]);
    }

    public function availableDrivers(): array
    {
        return array_keys($this->drivers);
    }

    /** Resolve the default driver from config */
    public function defaultDriver(): PaymentGateway
    {
        return $this->driver(config('payment.default', 'myfatoorah'));
    }
}
