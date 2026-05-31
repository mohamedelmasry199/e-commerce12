<?php

namespace App\Services\Payments\Drivers;

use App\Contracts\PaymentGateway;
use App\DTOs\PaymentResult;
use App\DTOs\PaymentVerificationResult;
use App\Exceptions\Checkout\PaymentException;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * MyFatoorah v2 API driver.
 *
 * Docs: https://docs.myfatoorah.com/
 */
class MyFatoorahDriver implements PaymentGateway
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey  = config('payment.myfatoorah.api_key');
        $this->baseUrl = config('payment.myfatoorah.sandbox')
            ? 'https://apitest.myfatoorah.com'
            : 'https://api.myfatoorah.com';
    }

    public function name(): string
    {
        return 'myfatoorah';
    }

    // ──────────────────────────────────────────────────────────────────
    // PAY
    // ──────────────────────────────────────────────────────────────────

    public function pay(Order $order): PaymentResult
    {
$phone = ltrim(
    preg_replace('/^(\+20|20)/', '', $order->user_phone),
    '0'
);        $payload = [
            'NotificationOption'  => 'ALL',
            'InvoiceValue'        => (float) $order->total_price,
            'DisplayCurrencyIso'  => config('payment.currency', 'EGP'),
            'CustomerName'        => $order->user_name,
            'CustomerEmail'       => $order->user_email,
            'MobileCountryCode'   => '+20',
            'CustomerMobile'      => $phone,
            'Language'            => app()->getLocale() === 'ar' ? 'AR' : 'EN',
            'CustomerReference'   => (string) $order->id,
            'CallBackUrl'         => route('website.checkout.callback'),
            'ErrorUrl'            => route('website.checkout.failed', ['order' => $order->id]),

            /*
             * UserDefinedField — we store the ORDER ID here.
             * MyFatoorah will echo it back in the callback/webhook payload,
             * so we can find the order without relying on session or hidden fields.
             */
            'UserDefinedField'    => (string) $order->id,
            'InvoiceItems'        => $this->buildLineItems($order),
            'ShippingConsignee' => [
    'PersonName'   => $order->user_name,
    'Mobile'       =>$phone,
    'EmailAddress' => $order->user_email,
    'LineAddress'  => $order->street ?? 'Cairo',
    'CityName'     => $order->city ?? 'Cairo',
    'PostalCode'   => '12345',
    'CountryCode'  => 'EG',
],
        ];

        $response = Http::withToken($this->apiKey)
            ->timeout(100)
            ->post("{$this->baseUrl}/v2/SendPayment", $payload);

        Log::info('MyFatoorah SendPayment', [
            'order_id' => $order->id,
            'status'   => $response->status(),
            'body'     => $response->json(),
        ]);

        if (! $response->successful() || ! $response->json('IsSuccess')) {
            $error = $response->json('ValidationErrors.0.Error')
                ?? $response->json('Message')
                ?? 'MyFatoorah payment initiation failed.';

            throw new PaymentException($error);
        }

        return new PaymentResult(
            redirectUrl:      $response->json('Data.InvoiceURL'),
            gatewayReference: (string) $response->json('Data.InvoiceId'),
        );
    }

    // ──────────────────────────────────────────────────────────────────
    // VERIFY (callback + webhook both use paymentId query param)
    // ──────────────────────────────────────────────────────────────────

    public function verify(array $payload): PaymentVerificationResult
    {
        // MyFatoorah sends ?paymentId=xxx in the redirect URL
        $paymentId = $payload['paymentId'] ?? null;

        if (! $paymentId) {
            return new PaymentVerificationResult(
                success:       false,
                transactionId: '',
                orderId:       0,
                message:       'Missing paymentId in callback payload',
            );
        }

        $response = Http::withToken($this->apiKey)
            ->timeout(30)
            ->post("{$this->baseUrl}/v2/GetPaymentStatus", [
                'Key'     => $paymentId,
                'KeyType' => 'paymentId',
            ]);

        Log::info('MyFatoorah GetPaymentStatus', [
            'paymentId' => $paymentId,
            'status'    => $response->status(),
            'body'      => $response->json(),
        ]);

        if (! $response->successful() || ! $response->json('IsSuccess')) {
            return new PaymentVerificationResult(
                success:       false,
                transactionId: '',
                orderId:       0,
                message:       $response->json('Message') ?? 'Verification request failed',
            );
        }

        $data          = $response->json('Data');
        $invoiceStatus = $data['InvoiceStatus'] ?? '';   // 'Paid' | 'Failed' | 'Pending'
        $invoiceId     = (string) ($data['InvoiceId'] ?? $paymentId);
        $orderId       = (int) ($data['UserDefinedField'] ?? 0);

        return new PaymentVerificationResult(
            success:       $invoiceStatus === 'Paid',
            transactionId: $invoiceId,
            orderId:       $orderId,
            message:       $invoiceStatus,
        );
    }

    // ──────────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ──────────────────────────────────────────────────────────────────

   private function buildLineItems(Order $order): array
{
    $items = $order->items->map(fn ($item) => [
        'ItemName'  => $item->product_name,
        'Quantity'  => (int) $item->product_quantity,
        'UnitPrice' => (float) $item->product_price,
    ])->toArray();

    if ($order->shipping_price > 0) {
        $items[] = [
            'ItemName'  => 'Shipping Fees',
            'Quantity'  => 1,
            'UnitPrice' => (float) $order->shipping_price,
        ];
    }

    if ($order->coupon_discount > 0) {
        $items[] = [
            'ItemName'  => 'Coupon Discount',
            'Quantity'  => 1,
            'UnitPrice' => -(float) $order->coupon_discount,
        ];
    }

    return $items;
}
}
