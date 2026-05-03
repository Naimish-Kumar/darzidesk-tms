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
        Schema::create('blogs', function (Blueprint $row) {
            $row->id();
            $row->string('title');
            $row->string('slug')->unique();
            $row->text('short_description')->nullable();
            $row->longText('content')->nullable();
            $row->string('image')->nullable();
            $row->integer('is_active')->default(1);
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
