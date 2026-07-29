<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tailor_ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tailor_id');
            $table->enum('type', ['earning', 'advance', 'settlement']);
            $table->decimal('amount', 12, 2);
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable(); // Assignment ID or Invoice ID
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('tailor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tailor_ledgers');
    }
};
