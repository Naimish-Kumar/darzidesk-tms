<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            if (!Schema::hasColumn('branches', 'opening_time')) {
                $table->string('opening_time')->nullable()->default('09:00 AM');
            }
            if (!Schema::hasColumn('branches', 'closing_time')) {
                $table->string('closing_time')->nullable()->default('07:00 PM');
            }
            if (!Schema::hasColumn('branches', 'weekly_holiday')) {
                $table->string('weekly_holiday')->nullable()->default('Sunday');
            }
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            if (Schema::hasColumn('branches', 'opening_time')) {
                $table->dropColumn('opening_time');
            }
            if (Schema::hasColumn('branches', 'closing_time')) {
                $table->dropColumn('closing_time');
            }
            if (Schema::hasColumn('branches', 'weekly_holiday')) {
                $table->dropColumn('weekly_holiday');
            }
        });
    }
};
