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
        Schema::create('register_reconciliations', function (Blueprint $table) {
            $table->id();
            $table->date('reconciliation_date');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->decimal('expected_cash', 12, 2)->default(0.00);
            $table->decimal('actual_cash', 12, 2)->default(0.00);
            $table->decimal('net_sales', 12, 2)->default(0.00);
            $table->decimal('discrepancy', 12, 2)->default(0.00);
            $table->json('payment_method_split')->nullable();
            $table->json('adjustments')->nullable();
            $table->text('closing_notes')->nullable();
            $table->string('status')->default('balanced');
            $table->unsignedBigInteger('finalized_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_reconciliations');
    }
};
