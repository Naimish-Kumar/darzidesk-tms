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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'website')) {
                $table->string('website')->nullable()->after('city');
            }
            if (!Schema::hasColumn('users', 'shop_logo')) {
                $table->string('shop_logo')->nullable()->after('website');
            }
            if (!Schema::hasColumn('users', 'shop_banner')) {
                $table->string('shop_banner')->nullable()->after('shop_logo');
            }
            if (!Schema::hasColumn('users', 'business_hours')) {
                $table->text('business_hours')->nullable()->after('shop_banner');
            }
            if (!Schema::hasColumn('users', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable()->after('business_hours');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'website')) {
                $table->dropColumn('website');
            }
            if (Schema::hasColumn('users', 'shop_logo')) {
                $table->dropColumn('shop_logo');
            }
            if (Schema::hasColumn('users', 'shop_banner')) {
                $table->dropColumn('shop_banner');
            }
            if (Schema::hasColumn('users', 'business_hours')) {
                $table->dropColumn('business_hours');
            }
            if (Schema::hasColumn('users', 'whatsapp_number')) {
                $table->dropColumn('whatsapp_number');
            }
        });
    }
};
