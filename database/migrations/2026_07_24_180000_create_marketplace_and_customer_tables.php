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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('phone_number');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('city');
            }
            if (!Schema::hasColumn('users', 'shop_name')) {
                $table->string('shop_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'shop_banner')) {
                $table->string('shop_banner')->nullable()->after('profile');
            }
            if (!Schema::hasColumn('users', 'shop_logo')) {
                $table->string('shop_logo')->nullable()->after('shop_banner');
            }
            if (!Schema::hasColumn('users', 'rating')) {
                $table->decimal('rating', 3, 2)->default(5.00)->after('shop_logo');
            }
            if (!Schema::hasColumn('users', 'review_count')) {
                $table->integer('review_count')->default(0)->after('rating');
            }
            if (!Schema::hasColumn('users', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('review_count');
            }
            if (!Schema::hasColumn('users', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable()->after('phone_number');
            }
        });

        if (!Schema::hasTable('tailor_services')) {
            Schema::create('tailor_services', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id'); // Shop owner ID
                $table->string('title');
                $table->text('description')->nullable();
                $table->decimal('price_starts_at', 10, 2)->default(0.00);
                $table->integer('estimated_days')->default(7);
                $table->string('category')->default('General'); // Suits, Shirts, Alterations, Traditional
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('shop_reviews')) {
            Schema::create('shop_reviews', function (Blueprint $table) {
                $table->id();
                $table->integer('shop_id');
                $table->integer('customer_id');
                $table->integer('order_id')->nullable();
                $table->integer('rating')->default(5);
                $table->text('comment')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['city', 'address', 'shop_name', 'shop_banner', 'shop_logo', 'rating', 'review_count', 'is_featured', 'whatsapp_number'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::dropIfExists('tailor_services');
        Schema::dropIfExists('shop_reviews');
    }
};
