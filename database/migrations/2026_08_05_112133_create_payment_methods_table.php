<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['card', 'upi', 'wallet']);
            $table->string('label')->nullable(); // e.g. "Personal Card", "Primary VPA"
            $table->boolean('is_default')->default(false);

            // Card-specific fields
            $table->string('card_type')->nullable(); // VISA, MC, RUPAY, AMEX
            $table->string('card_number_masked')->nullable(); // last 4 digits: ••••4291
            $table->string('card_expiry')->nullable(); // MM/YY
            $table->string('card_holder')->nullable();

            // UPI-specific fields
            $table->string('vpa_id')->nullable(); // e.g. user@upi

            // Wallet-specific fields
            $table->string('wallet_provider')->nullable(); // Apple Pay, Google Pay
            $table->string('wallet_status')->nullable(); // linked, not_linked

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};
