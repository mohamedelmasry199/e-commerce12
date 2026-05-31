<?php

namespace App\Http\Controllers\Webhooks;

use App\Actions\Payments\VerifyPaymentAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Receives server-to-server payment notifications from gateways.
 *
 * IMPORTANT:
 *  - Excluded from CSRF middleware (see routes/web.php)
 *  - No auth middleware — this is called by the payment gateway, not the user
 *  - Always responds 200 OK even on failure so the gateway stops retrying
 *    (log the failure internally instead)
 */
class PaymentWebhookController extends Controller
{
    public function __construct(
        protected VerifyPaymentAction $verifyPaymentAction,
    ) {}

    /**
     * MyFatoorah webhook endpoint.
     * MyFatoorah posts to this URL after payment status changes.
     */
    public function myfatoorah(Request $request)
    {
        Log::info('MyFatoorah webhook received', $request->all());

        try {
            $result = $this->verifyPaymentAction->execute(
                $request->all(),
                'myfatoorah'
            );

            Log::info('MyFatoorah webhook processed', [
                'success'        => $result->success,
                'order_id'       => $result->orderId,
                'transaction_id' => $result->transactionId,
            ]);

        } catch (\Throwable $e) {
            Log::error('MyFatoorah webhook failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Always 200 — gateway will stop retrying
        return response()->json(['status' => 'received']);
    }

    /**
     * Fawry webhook endpoint (ready for future implementation).
     */
    public function fawry(Request $request)
    {
        Log::info('Fawry webhook received', $request->all());

        try {
            $result = $this->verifyPaymentAction->execute(
                $request->all(),
                'fawry'
            );
        } catch (\Throwable $e) {
            Log::error('Fawry webhook failed', ['error' => $e->getMessage()]);
        }

        return response()->json(['status' => 'received']);
    }
}
