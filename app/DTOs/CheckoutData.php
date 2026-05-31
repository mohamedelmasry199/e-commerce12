<?php

namespace App\DTOs;

/**
 * Immutable data transfer object for checkout submission.
 * Built from validated request data — never from raw user input.
 */
class CheckoutData
{
    public function __construct(
        public readonly string  $name,
        public readonly string  $email,
        public readonly string  $phone,
        public readonly string  $country,
        public readonly string  $governorate,
        public readonly string  $city,
        public readonly string  $street,
        public readonly ?string $note,
        public readonly ?string $couponCode,
        public readonly ?int $governorate_id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name:        $data['name'],
            email:       $data['email'],
            phone:       $data['phone'],
            country:     $data['country'],
            governorate: $data['governorate'],
            city:        $data['city'],
            street:      $data['street'],
            note:        $data['note'] ?? null,
            couponCode:  $data['couponCode'] ?? null,
            governorate_id: $data['governorate_id'] ?? null,
        );
    }
}
