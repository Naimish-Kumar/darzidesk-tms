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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('body_shape')->nullable()->after('notes');
            $table->text('posture_notes')->nullable()->after('body_shape');
            $table->string('fitting_photo')->nullable()->after('posture_notes');
        });

        Schema::table('measurements', function (Blueprint $table) {
            $table->text('posture_adjustments')->nullable()->after('measurement_detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['body_shape', 'posture_notes', 'fitting_photo']);
        });

        Schema::table('measurements', function (Blueprint $table) {
            $table->dropColumn('posture_adjustments');
        });
    }
};
