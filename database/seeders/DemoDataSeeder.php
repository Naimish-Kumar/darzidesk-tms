<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\ClothType;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\Material;
use App\Models\Measurement;
use App\Models\MeasurementHistory;
use App\Models\Notification;
use App\Models\Order;
use App\Models\ProductionAssignment;
use App\Models\ProductionStage;
use App\Models\RegisterReconciliation;
use App\Models\TailorLedger;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $owner = User::where('type', 'owner')->first() ?? User::first();
        $parentIds = [1, $owner->id];

        foreach ($parentIds as $parentId) {
            // 1. Create Staff Members (Cutters, Master Tailors, Stitchers)
            $staffMembers = [
                [
                    'name' => 'Master Vikram Singhania',
                    'email' => "vikram.master.p{$parentId}@darzidesk.test",
                    'password' => Hash::make('123456'),
                    'type' => 'employee',
                    'phone_number' => '+91 98765 11111',
                    'parent_id' => $parentId,
                    'lang' => 'en',
                ],
                [
                    'name' => 'Rajesh Cutter',
                    'email' => "rajesh.cutter.p{$parentId}@darzidesk.test",
                    'password' => Hash::make('123456'),
                    'type' => 'employee',
                    'phone_number' => '+91 98765 22222',
                    'parent_id' => $parentId,
                    'lang' => 'en',
                ],
                [
                    'name' => 'Sunil Stitcher',
                    'email' => "sunil.stitcher.p{$parentId}@darzidesk.test",
                    'password' => Hash::make('123456'),
                    'type' => 'employee',
                    'phone_number' => '+91 98765 33333',
                    'parent_id' => $parentId,
                    'lang' => 'en',
                ],
            ];

            $createdStaff = [];
            foreach ($staffMembers as $s) {
                $createdStaff[] = User::firstOrCreate(['email' => $s['email']], $s);
            }

            // 2. Create Realistic Customers
            $customers = [
                [
                    'name' => 'Alexander Hamilton',
                    'email' => "alexander.h.p{$parentId}@example.com",
                    'phone_number' => '+91 98200 44551',
                    'city' => 'Mumbai',
                    'address' => '42 Altamount Road, Cumballa Hill, Mumbai',
                    'notes' => 'Prefers slim lapel, 2-button jacket, Italian Merino Wool.',
                    'body_shape' => 'Athletic (V-Shape)',
                    'posture_notes' => 'Slight forward right shoulder slope (+0.5 inches sleeve difference).',
                ],
                [
                    'name' => 'Karan Kapoor',
                    'email' => "karan.k.p{$parentId}@example.com",
                    'phone_number' => '+91 98199 88772',
                    'city' => 'Delhi',
                    'address' => '18 Vasant Vihar, Block C, New Delhi',
                    'notes' => 'Sherwani for wedding event. Royal velvet fabric required.',
                    'body_shape' => 'Standard Regular',
                    'posture_notes' => 'Erect back posture, standard neck drop.',
                ],
                [
                    'name' => 'Priya Sharma',
                    'email' => "priya.s.p{$parentId}@example.com",
                    'phone_number' => '+91 98333 11223',
                    'city' => 'Bengaluru',
                    'address' => '102 Indiranagar 100ft Road, Bengaluru',
                    'notes' => 'Custom Silk Anarkali Gown with hand-embroidered Zardozi border.',
                    'body_shape' => 'Hourglass',
                    'posture_notes' => 'High waist tuck adjustment required.',
                ],
                [
                    'name' => 'Marcus Aurelius',
                    'email' => "marcus.a.p{$parentId}@example.com",
                    'phone_number' => '+91 99100 99884',
                    'city' => 'Mumbai',
                    'address' => '12 Colaba Causeway, Fort, Mumbai',
                    'notes' => 'Linen casual suits for summer cruise.',
                    'body_shape' => 'Tall Slim',
                    'posture_notes' => 'Longer torso, extra 2 inches jacket length.',
                ],
                [
                    'name' => 'Rohan Malhotra',
                    'email' => "rohan.m.p{$parentId}@example.com",
                    'phone_number' => '+91 97690 33445',
                    'city' => 'Jaipur',
                    'address' => '78 Civil Lines, Pink City, Jaipur',
                    'notes' => 'Bandhgala suit for reception party with brass buttons.',
                    'body_shape' => 'Broad Shouldered',
                    'posture_notes' => 'Square shoulders, minimum shoulder padding.',
                ],
            ];

            $createdCustomers = [];
            foreach ($customers as $c) {
                $user = User::firstOrCreate(
                    ['email' => $c['email']],
                    [
                        'name' => $c['name'],
                        'phone_number' => $c['phone_number'],
                        'password' => Hash::make('123456'),
                        'type' => 'customer',
                        'parent_id' => $parentId,
                        'lang' => 'en',
                    ]
                );

                Customer::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'customer_id' => 'CUST-' . (1000 + $user->id),
                        'city' => $c['city'],
                        'address' => $c['address'],
                        'notes' => $c['notes'],
                        'body_shape' => $c['body_shape'],
                        'posture_notes' => $c['posture_notes'],
                        'parent_id' => $parentId,
                    ]
                );

                $createdCustomers[] = $user;
            }

            // 3. Create Cloth Types
            $clothTypes = [
                ['title' => 'Bespoke 2-Piece Suit', 'gender' => 'Male', 'amount' => 45000.00],
                ['title' => 'Executive Shirt', 'gender' => 'Male', 'amount' => 4500.00],
                ['title' => 'Royal Wedding Sherwani', 'gender' => 'Male', 'amount' => 65000.00],
                ['title' => 'Designer Anarkali Suit', 'gender' => 'Female', 'amount' => 38000.00],
                ['title' => 'Classic Bandhgala Jacket', 'gender' => 'Male', 'amount' => 28000.00],
                ['title' => 'Tailored Chinos', 'gender' => 'Male', 'amount' => 6500.00],
            ];

            $createdClothTypes = [];
            foreach ($clothTypes as $ct) {
                $createdClothTypes[] = ClothType::firstOrCreate(
                    ['title' => $ct['title'], 'parent_id' => $parentId],
                    [
                        'gender' => $ct['gender'],
                        'amount' => $ct['amount'],
                    ]
                );
            }

            // 4. Create Anatomical Measurements
            foreach ($createdCustomers as $index => $cUser) {
                $cType = $createdClothTypes[$index % count($createdClothTypes)];
                $m = Measurement::firstOrCreate(
                    ['customer' => $cUser->id],
                    [
                        'measurement_id' => 'MS-' . (100 + $cUser->id),
                        'date' => now()->subDays(5)->format('Y-m-d'),
                        'cloth_type' => $cType->id,
                        'responsible' => $createdStaff[0]->id,
                        'measurement_detail' => [
                            'Neck' => '15.5"',
                            'Chest' => '40.5"',
                            'Waist' => '33.5"',
                            'Hip' => '39.0"',
                            'Shoulder' => '18.0"',
                            'Sleeve Length' => '25.5"',
                            'Jacket Length' => '30.0"',
                            'Trouser Length' => '41.0"',
                            'Inseam' => '32.0"',
                        ],
                        'posture_adjustments' => [
                            'Shoulder Slope' => 'Right shoulder drop 0.5"',
                            'Back Posture' => 'Slight Erect',
                        ],
                        'parent_id' => $parentId,
                    ]
                );

                // Measurement Audit History
                MeasurementHistory::firstOrCreate(
                    ['measurement_id' => $m->id, 'customer_id' => $cUser->id],
                    [
                        'cloth_type_id' => $cType->id,
                        'snapshot_data' => $m->measurement_detail,
                        'change_notes' => 'Adjusted Chest (+1.5") and Waist (-0.5") after first trial fitting.',
                        'updated_by' => $createdStaff[0]->id,
                        'parent_id' => $parentId,
                    ]
                );
            }

            // 5. Create Fabric & Material Inventory
            $materials = [
                ['name' => "Loro Piana Super 130s Merino Wool (P{$parentId})", 'code' => "MAT-WOOL-P{$parentId}", 'category' => 'Fabric', 'quantity' => 125.5, 'unit' => 'Meters', 'reorder_level' => 20.0, 'unit_cost' => 1800.00],
                ['name' => "Sea Island 120s Two-Ply Cotton (P{$parentId})", 'code' => "MAT-COT-P{$parentId}", 'category' => 'Fabric', 'quantity' => 84.0, 'unit' => 'Meters', 'reorder_level' => 15.0, 'unit_cost' => 650.00],
                ['name' => "Banarasi Silk Velvet (P{$parentId})", 'code' => "MAT-SILK-P{$parentId}", 'category' => 'Fabric', 'quantity' => 45.0, 'unit' => 'Meters', 'reorder_level' => 10.0, 'unit_cost' => 2400.00],
                ['name' => "Natural Horn Jacket Buttons (P{$parentId})", 'code' => "MAT-BTN-P{$parentId}", 'category' => 'Trimmings', 'quantity' => 450.0, 'unit' => 'Pieces', 'reorder_level' => 50.0, 'unit_cost' => 35.00],
                ['name' => "Bemberg Cupro Jacket Lining (P{$parentId})", 'code' => "MAT-LIN-P{$parentId}", 'category' => 'Lining', 'quantity' => 95.0, 'unit' => 'Meters', 'reorder_level' => 15.0, 'unit_cost' => 220.00],
                ['name' => "YKK Antique Brass Zippers (P{$parentId})", 'code' => "MAT-ZIP-P{$parentId}", 'category' => 'Notions', 'quantity' => 180.0, 'unit' => 'Pieces', 'reorder_level' => 30.0, 'unit_cost' => 45.00],
            ];

            foreach ($materials as $mat) {
                Material::firstOrCreate(
                    ['code' => $mat['code'], 'parent_id' => $parentId],
                    [
                        'name' => $mat['name'],
                        'category' => $mat['category'],
                        'quantity' => $mat['quantity'],
                        'unit' => $mat['unit'],
                        'reorder_level' => $mat['reorder_level'],
                        'unit_cost' => $mat['unit_cost'],
                    ]
                );
            }

            // 6. Fetch Production Stages
            $stages = ProductionStage::where('parent_id', $parentId)->orderBy('order_by')->get();
            if ($stages->isEmpty()) {
                $stageNames = [
                    ['name' => 'Pending Confirmation', 'color' => '#78909C', 'order_by' => 1],
                    ['name' => 'Pattern & Cutting', 'color' => '#00897B', 'order_by' => 2],
                    ['name' => 'Stitching & Canvas', 'color' => '#2196F3', 'order_by' => 3],
                    ['name' => 'Trial & Fitting', 'color' => '#FF8F00', 'order_by' => 4],
                    ['name' => 'Finishing & Pressing', 'color' => '#8E24AA', 'order_by' => 5],
                    ['name' => 'Ready for Delivery', 'color' => '#43A047', 'order_by' => 6],
                ];
                foreach ($stageNames as $sn) {
                    $stages->push(ProductionStage::create([
                        'name' => $sn['name'],
                        'color' => $sn['color'],
                        'order_by' => $sn['order_by'],
                        'parent_id' => $parentId,
                    ]));
                }
            }

            // 7. Create Custom Orders with Assignments, Invoices & Payments
            $sampleOrdersData = [
                [
                    'order_id' => "TXN-P{$parentId}-88294",
                    'customer_index' => 0,
                    'cloth_type_index' => 0,
                    'fabric' => 'Loro Piana Super 130s Merino Wool (Navy)',
                    'febric_color' => 'Navy Blue',
                    'gender' => 'Male',
                    'status' => 'in_progress',
                    'stage_order' => 3, // Stitching
                    'subtotal' => 45000.00,
                    'tax' => 3600.00,
                    'total' => 48600.00,
                    'notes' => 'Italian Wool • Slim Fit • Peak Lapel • Double Vent',
                ],
                [
                    'order_id' => "TXN-P{$parentId}-88301",
                    'customer_index' => 1,
                    'cloth_type_index' => 2,
                    'fabric' => 'Banarasi Silk Velvet (Maroon)',
                    'febric_color' => 'Maroon Velvet',
                    'gender' => 'Male',
                    'status' => 'in_progress',
                    'stage_order' => 4, // Trial & Fitting
                    'subtotal' => 65000.00,
                    'tax' => 5200.00,
                    'total' => 70200.00,
                    'notes' => 'Royal Zardozi Embroidery on Collar & Sleeves.',
                ],
                [
                    'order_id' => "TXN-P{$parentId}-88315",
                    'customer_index' => 2,
                    'cloth_type_index' => 3,
                    'fabric' => 'Pure Georgette Silk (Emerald Green)',
                    'febric_color' => 'Emerald Green',
                    'gender' => 'Female',
                    'status' => 'in_progress',
                    'stage_order' => 2, // Pattern & Cutting
                    'subtotal' => 38000.00,
                    'tax' => 3040.00,
                    'total' => 41040.00,
                    'notes' => 'Anarkali flared skirt with gold thread work.',
                ],
                [
                    'order_id' => "TXN-P{$parentId}-88320",
                    'customer_index' => 3,
                    'cloth_type_index' => 1,
                    'fabric' => 'Sea Island 120s Cotton (White)',
                    'febric_color' => 'Crisp White',
                    'gender' => 'Male',
                    'status' => 'completed',
                    'stage_order' => 6, // Ready for Delivery
                    'subtotal' => 12000.00,
                    'tax' => 960.00,
                    'total' => 12960.00,
                    'notes' => '3 Pack Monogrammed Executive Shirts.',
                ],
                [
                    'order_id' => "TXN-P{$parentId}-88334",
                    'customer_index' => 4,
                    'cloth_type_index' => 4,
                    'fabric' => 'Italian Herringbone Tweed (Charcoal)',
                    'febric_color' => 'Charcoal Grey',
                    'gender' => 'Male',
                    'status' => 'pending',
                    'stage_order' => 1, // Pending Confirmation
                    'subtotal' => 28000.00,
                    'tax' => 2240.00,
                    'total' => 30240.00,
                    'notes' => 'Classic Bandhgala with Horn Buttons.',
                ],
            ];

            foreach ($sampleOrdersData as $sOrder) {
                $custUser = $createdCustomers[$sOrder['customer_index']];
                $cType = $createdClothTypes[$sOrder['cloth_type_index']];
                $stage = $stages->where('order_by', $sOrder['stage_order'])->first() ?? $stages->first();
                $responsibleStaff = $createdStaff[array_rand($createdStaff)];

                $order = Order::firstOrCreate(
                    ['order_id' => $sOrder['order_id']],
                    [
                        'tracking_token' => (string) Str::uuid(),
                        'customer_id' => $custUser->id,
                        'order_date' => now()->subDays(rand(1, 14))->format('Y-m-d'),
                        'deadline_date' => now()->addDays(rand(5, 20))->format('Y-m-d'),
                        'quantity' => 1,
                        'febric' => $sOrder['fabric'],
                        'febric_color' => $sOrder['febric_color'],
                        'gender' => $sOrder['gender'],
                        'responsible' => $responsibleStaff->id,
                        'cloth_type' => $cType->id,
                        'status' => $sOrder['status'],
                        'notes' => $sOrder['notes'],
                        'production_stage_id' => $stage->id,
                        'measurement' => [
                            'Chest' => '40.5"',
                            'Waist' => '33.5"',
                            'Sleeve' => '25.0"',
                            'Length' => '30.5"',
                        ],
                        'parent_id' => $parentId,
                    ]
                );

                // Assign Worker to Order
                ProductionAssignment::firstOrCreate(
                    ['order_id' => $order->id, 'worker_id' => $responsibleStaff->id],
                    [
                        'stage_id' => $stage->id,
                        'assigned_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
                        'status' => 'in_progress',
                        'piece_rate_pay' => 1500.00,
                        'notes' => 'Master Tailor assigned for cutting and stitching.',
                        'parent_id' => $parentId,
                    ]
                );

                // Invoice for Order
                $invNum = rand(10000, 99999);
                $invoice = Invoice::firstOrCreate(
                    ['invoice_id' => $invNum, 'parent_id' => $parentId],
                    [
                        'customer_id' => $custUser->id,
                        'invoice_date' => $order->order_date,
                        'due_date' => $order->deadline_date,
                        'status' => 'partial_paid',
                        'parent_id' => $parentId,
                    ]
                );

                // Invoice Items
                InvoiceItem::firstOrCreate(
                    ['invoice_id' => $invoice->id],
                    [
                        'cloth_type_id' => $cType->id,
                        'quantity' => 1,
                        'amount' => $sOrder['subtotal'],
                        'tax' => '8',
                        'note' => $cType->title . ' - ' . $sOrder['fabric'],
                        'parent_id' => $parentId,
                    ]
                );

                // Invoice Payment (Deposit)
                InvoicePayment::firstOrCreate(
                    ['invoice_id' => $invoice->id],
                    [
                        'transaction_id' => 'TXN-PAY-' . rand(10000, 99999),
                        'payment_type' => rand(0, 1) ? 'UPI' : 'Card',
                        'amount' => round($sOrder['total'] * 0.5, 2),
                        'payment_date' => $order->order_date,
                        'notes' => '50% Initial Advance Deposit received via POS',
                        'parent_id' => $parentId,
                    ]
                );
            }

            // 8. Create Fitting Appointments
            foreach ($createdCustomers as $index => $cUser) {
                $custModel = Customer::where('user_id', $cUser->id)->first();
                Appointment::firstOrCreate(
                    ['customer_id' => $custModel ? $custModel->id : 1, 'appointment_date' => now()->addDays($index + 2)->format('Y-m-d')],
                    [
                        'appointment_time' => '14:30:00',
                        'type' => $index % 2 == 0 ? 'in_store_fitting' : 'trial',
                        'status' => $index % 2 == 0 ? 'scheduled' : 'completed',
                        'notes' => 'Master Vikram to adjust shoulder slope and waist taper.',
                        'parent_id' => $parentId,
                    ]
                );
            }

            // 9. Multi-Branch Store Locations
            $branches = [
                ['name' => "Savile Row Atelier (P{$parentId})", 'code' => "MUM-01-P{$parentId}", 'address' => '42 Altamount Road, Mumbai', 'phone' => '+91 22 2355 9900'],
                ['name' => "Royal Heritage (P{$parentId})", 'code' => "DEL-01-P{$parentId}", 'address' => '45 Connaught Place, New Delhi', 'phone' => '+91 11 4155 8811'],
                ['name' => "Bespoke Studio (P{$parentId})", 'code' => "BLR-01-P{$parentId}", 'address' => '102 100ft Road, Indiranagar, Bengaluru', 'phone' => '+91 80 4200 7722'],
            ];

            foreach ($branches as $b) {
                Branch::firstOrCreate(
                    ['code' => $b['code']],
                    [
                        'name' => $b['name'],
                        'address' => $b['address'],
                        'phone' => $b['phone'],
                        'manager_id' => $owner->id,
                        'parent_id' => $parentId,
                    ]
                );
            }

            // 10. Register Cash Reconciliations
            RegisterReconciliation::firstOrCreate(
                ['reconciliation_date' => now()->format('Y-m-d'), 'finalized_by' => $owner->id],
                [
                    'expected_cash' => 42850.00,
                    'actual_cash' => 42850.00,
                    'net_sales' => 158420.00,
                    'discrepancy' => 0.00,
                    'closing_notes' => 'Daily till count matched perfectly. Cash deposited to main vault.',
                    'status' => 'balanced',
                    'finalized_by' => $owner->id,
                ]
            );

            // 11. Tailor Ledger Payout Entries
            foreach ($createdStaff as $staff) {
                TailorLedger::firstOrCreate(
                    ['tailor_id' => $staff->id, 'parent_id' => $parentId],
                    [
                        'amount' => 18500.00,
                        'type' => 'earning',
                        'notes' => 'Weekly piecerate payout for 12 completed suit alterations.',
                        'parent_id' => $parentId,
                    ]
                );
            }

            // 12. System Notifications
            $notificationsList = [
                ['subject' => "Trial Fitting Tomorrow (P{$parentId})", 'message' => 'Trial fitting scheduled for Alexander Hamilton at 02:30 PM.', 'type' => 'appointment'],
                ['subject' => "Stock Low Warning (P{$parentId})", 'message' => 'Sea Island Cotton (White) is running low (14m remaining).', 'type' => 'general'],
                ['subject' => "New Customer Order (P{$parentId})", 'message' => 'Order created for Rohan Malhotra.', 'type' => 'order'],
            ];

            foreach ($notificationsList as $notif) {
                Notification::firstOrCreate(
                    ['subject' => $notif['subject'], 'user_id' => $owner->id],
                    [
                        'type' => $notif['type'],
                        'message' => $notif['message'],
                        'is_read' => 0,
                        'parent_id' => $parentId,
                    ]
                );
            }
        }
    }
}
