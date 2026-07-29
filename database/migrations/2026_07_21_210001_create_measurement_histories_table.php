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
        Schema::create('measurement_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('measurement_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('cloth_type_id')->nullable();
            $table->text('snapshot_data')->nullable(); // JSON stored snapshot
            $table->text('change_notes')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->integer('parent_id')->default(0);
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
        Schema::dropIfExists('measurement_histories');
    }
};
