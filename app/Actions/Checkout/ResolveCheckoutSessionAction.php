<?php

namespace App\Actions\Checkout;

use App\Models\CheckoutSession;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * Resolves or creates a CheckoutSession for the current user.
 *
 * This is the core of idempotency.
 *
 * How the idempotency key works:
 * ─────────────────────────────
 * 1. When the user opens the checkout PAGE (GET /checkout), we generate
 *    a unique key and store it in their Laravel browser session.
 *
 * 2. When the user SUBMITS the form (POST /checkout/process), we send
 *    this key along with the request.
 *
 * 3. This action checks: does a CheckoutSession already exist in the DB
 *    for this key?
 *
 *    YES + has order + still valid
 *        → return the existing session (same order, no duplicate)
 *
 *    YES + no order yet (gateway timed out before order was created)
 *        → proceed to create order as normal
 *
 *    NO  → create a new CheckoutSession and proceed normally
 *
 * This means:
 *   - Retry after timeout      → same session, same order ✓
 *   - Retry after browser back → same session, same order ✓
 *   - Double form submit       → same session, same order ✓
 *   - New checkout (new visit) → new key, new session ✓
 */
class ResolveCheckoutSessionAction
{
    public function execute(User $user, string $idempotencyKey): CheckoutSession
    {
        // Look for an existing valid session with this exact key
        $existing = CheckoutSession::where('idempotency_key', $idempotencyKey)
            ->where('user_id', $user->id)
            ->pending()
            ->where('expires_at', '>', now())
            ->first();

        if ($existing) {
            return $existing; // ← same attempt, return existing session
        }

        // No valid session found — create a fresh one
        return CheckoutSession::create([
            'user_id'          => $user->id,
            'idempotency_key'  => $idempotencyKey,
            'status'           => 'pending',
            'expires_at'       => now()->addMinutes(30),
        ]);
    }

    /**
     * Generate a new unique idempotency key.
     * Called when the checkout page is first loaded (GET).
     */
    public static function generateKey(): string
    {
        return Str::uuid()->toString();
    }
}
