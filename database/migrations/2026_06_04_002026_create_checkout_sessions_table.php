<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checkout_sessions', function (Blueprint $table) {
             $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // The idempotency key — generated once per checkout attempt
            // Stored in the user's browser session (Laravel session)
            // Same key = same checkout attempt
            $table->string('idempotency_key')->unique();

            // Once an order is created, we link it here
            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            // Status of this checkout session
            // pending   → session created, waiting for payment
            // paid      → payment confirmed
            // failed    → payment failed or expired
            $table->enum('status', ['pending', 'paid', 'failed'])
                ->default('pending');

            // Snapshot of the cart at checkout time (for debugging / audit)
            $table->json('cart_snapshot')->nullable();

            // Expires after 30 minutes — prevents stale sessions
            $table->timestamp('expires_at');

            $table->timestamps();

            // Fast lookup: find pending session for this user
            $table->index(['user_id', 'status', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_sessions');
    }
};
