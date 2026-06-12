<?php

namespace App\Jobs;

use App\Models\CheckoutSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

/**
 * Cleans up expired checkout sessions from the database.
 *
 * Runs daily via the scheduler.
 * Only deletes FAILED or expired PENDING sessions.
 * Never deletes PAID sessions — those are audit records.
 */
class CleanExpiredCheckoutSessionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function handle(): void
    {
        // Delete pending sessions that expired over 24 hours ago
        $deleted = CheckoutSession::where('status', 'pending')
            ->where('expires_at', '<', now()->subDay())
            ->delete();

        // Delete failed sessions older than 7 days
        $deletedFailed = CheckoutSession::where('status', 'failed')
            ->where('updated_at', '<', now()->subDays(7))
            ->delete();

        Log::info('CleanExpiredCheckoutSessionsJob: cleaned up sessions', [
            'expired_pending_deleted' => $deleted,
            'old_failed_deleted'      => $deletedFailed,
        ]);
    }
}
