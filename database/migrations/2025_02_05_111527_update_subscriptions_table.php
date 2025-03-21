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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('stripe_subscription_id')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->enum('plan', ['free', 'premium'])->default('free')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('stripe_subscription_id');
            $table->dropColumn('expires_at');
            $table->enum('plan', ['free', 'paid'])->default('free')->change();
        });
    }
};
