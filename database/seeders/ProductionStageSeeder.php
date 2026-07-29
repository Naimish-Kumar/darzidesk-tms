<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductionStage;
use App\Models\User;

class ProductionStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stages = ProductionStage::getDefaultStages();

        // Seed default stages for super admin / parent users
        $owners = User::where('type', 'owner')->orWhere('id', 1)->get();

        if ($owners->isEmpty()) {
            foreach ($stages as $stageData) {
                ProductionStage::firstOrCreate(
                    ['slug' => $stageData['slug'], 'parent_id' => 1],
                    [
                        'name' => $stageData['name'],
                        'order_index' => $stageData['order_index'],
                        'color_code' => $stageData['color_code'],
                        'is_default' => true,
                    ]
                );
            }
        } else {
            foreach ($owners as $owner) {
                foreach ($stages as $stageData) {
                    ProductionStage::firstOrCreate(
                        ['slug' => $stageData['slug'], 'parent_id' => $owner->id],
                        [
                            'name' => $stageData['name'],
                            'order_index' => $stageData['order_index'],
                            'color_code' => $stageData['color_code'],
                            'is_default' => true,
                        ]
                    );
                }
            }
        }
    }
}
