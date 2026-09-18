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
        Schema::create('demo_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business_name')->nullable();
            $table->string('city')->nullable();
            $table->string('mobile');
            $table->string('business_type')->nullable(); // e.g., Men's Tailor, Ladies Boutique, Designer
            $table->string('workers_count')->nullable(); // e.g., 1-3, 4-10, 10+
            $table->string('status')->default('pending'); // pending, contacted, completed
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('demo_requests');
    }
};
