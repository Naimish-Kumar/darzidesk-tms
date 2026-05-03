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
        $section1 = DB::table('home_pages')->where('section', 'Section 1')->first();
        if ($section1) {
            $content = json_decode($section1->content_value, true);
            $content['sub_title'] = 'DarziDesk: Tailoring business ko digital banaye! DarziDesk is a comprehensive solution designed specifically for the tailoring and bespoke garment industry in India.';
            
            DB::table('home_pages')->where('section', 'Section 1')->update([
                'content_value' => json_encode($content)
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
