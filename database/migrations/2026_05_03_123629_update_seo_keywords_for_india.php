<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $keywords = 'tailor software India, darzi software India, boutique software India, tailoring business ko digital banaye, tailor management system, TMS software, darzi software, boutique management system';
        
        DB::table('settings')->where('name', 'meta_seo_keyword')->where('parent_id', 1)->update([
            'value' => $keywords
        ]);

        DB::table('settings')->where('name', 'meta_seo_description')->where('parent_id', 1)->update([
            'value' => 'DarziDesk: Tailoring business ko digital banaye! The best tailor management software in India for boutiques and tailors. Manage orders, measurements, and billing easily.'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
