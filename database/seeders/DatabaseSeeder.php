<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultDataUsersTableSeeder::class);
        $this->call(ProductionStageSeeder::class);
        $this->call(MarketplaceSeeder::class);
        $this->call(DemoDataSeeder::class);
    }
}
