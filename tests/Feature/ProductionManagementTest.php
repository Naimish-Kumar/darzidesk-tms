<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Order;
use App\Models\ProductionAssignment;
use App\Models\ProductionStage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductionManagementTest extends TestCase
{
    public function test_default_production_stages_can_be_retrieved_or_seeded()
    {
        $stages = ProductionStage::getDefaultStages();
        $this->assertCount(6, $stages);
        $this->assertEquals('Pending', $stages[0]['name']);
        $this->assertEquals('Cutting', $stages[1]['name']);
    }

    public function test_material_inventory_creation_and_low_stock_check()
    {
        $material = new Material([
            'name' => 'Italian Linen',
            'code' => 'FAB-LINEN-01',
            'category' => 'Fabric',
            'unit' => 'meters',
            'quantity' => 10.00,
            'reorder_level' => 5.00,
            'unit_cost' => 15.50,
        ]);

        $this->assertFalse($material->isLowStock());

        $material->quantity = 4.00;
        $this->assertTrue($material->isLowStock());
    }

    public function test_production_assignment_creation()
    {
        $assignment = new ProductionAssignment([
            'order_id' => 1,
            'worker_id' => 1,
            'piece_rate_pay' => 25.00,
            'status' => 'pending',
        ]);

        $this->assertEquals(25.00, $assignment->piece_rate_pay);
        $this->assertEquals('pending', $assignment->status);
    }
}
