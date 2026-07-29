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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('category')->default('Fabric'); // Fabric, Trim, Thread, Zipper, Button, Accessory
            $table->string('unit')->default('meters'); // meters, yards, pcs, spools, rolls
            $table->decimal('quantity', 10, 2)->default(0.00);
            $table->decimal('reorder_level', 10, 2)->default(5.00);
            $table->decimal('unit_cost', 10, 2)->default(0.00);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('materials');
    }
};
