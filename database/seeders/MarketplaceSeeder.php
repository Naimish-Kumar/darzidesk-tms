<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\Appointment;
use App\Models\Measurement;
use App\Models\TailorService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MarketplaceSeeder extends Seeder
{
    public function run()
    {
        // Sample Tailor Shops across cities
        $shopsData = [
            [
                'name' => 'Master Tailors & Co.',
                'email' => 'mastertailor@darzidesk.test',
                'password' => Hash::make('password123'),
                'type' => 'owner',
                'phone_number' => '+91 9876543210',
                'whatsapp_number' => '+91 9876543210',
                'city' => 'Mumbai',
                'address' => '102 Linking Road, Bandra West, Mumbai',
                'shop_name' => 'Master Tailors & Co.',
                'rating' => 4.90,
                'review_count' => 48,
                'is_featured' => true,
            ],
            [
                'name' => 'Royal Bespoke Tailoring',
                'email' => 'royaltailor@darzidesk.test',
                'password' => Hash::make('password123'),
                'type' => 'owner',
                'phone_number' => '+91 9812345678',
                'whatsapp_number' => '+91 9812345678',
                'city' => 'Delhi',
                'address' => '45 Connaught Place, New Delhi',
                'shop_name' => 'Royal Bespoke Tailoring',
                'rating' => 4.85,
                'review_count' => 36,
                'is_featured' => true,
            ],
            [
                'name' => 'Savile Row Atelier India',
                'email' => 'savilerow@darzidesk.test',
                'password' => Hash::make('password123'),
                'type' => 'owner',
                'phone_number' => '+91 9988776655',
                'whatsapp_number' => '+91 9988776655',
                'city' => 'Mumbai',
                'address' => '12 Colaba Causeway, Fort, Mumbai',
                'shop_name' => 'Savile Row Atelier India',
                'rating' => 4.95,
                'review_count' => 84,
                'is_featured' => true,
            ],
            [
                'name' => 'Urban Fit Atelier',
                'email' => 'urbanfit@darzidesk.test',
                'password' => Hash::make('password123'),
                'type' => 'owner',
                'phone_number' => '+91 9765432109',
                'whatsapp_number' => '+91 9765432109',
                'city' => 'Bengaluru',
                'address' => '78 MG Road, Indiranagar, Bengaluru',
                'shop_name' => 'Urban Fit Atelier',
                'rating' => 4.75,
                'review_count' => 22,
                'is_featured' => true,
            ],
            [
                'name' => 'Heritage Zardozi & Embroidery',
                'email' => 'heritage@darzidesk.test',
                'password' => Hash::make('password123'),
                'type' => 'owner',
                'phone_number' => '+91 9543210987',
                'whatsapp_number' => '+91 9543210987',
                'city' => 'Jaipur',
                'address' => '15 Johari Bazar, Pink City, Jaipur',
                'shop_name' => 'Heritage Zardozi & Embroidery',
                'rating' => 4.92,
                'review_count' => 64,
                'is_featured' => true,
            ],
            [
                'name' => 'Precision Alterations & Fits',
                'email' => 'precisionfit@darzidesk.test',
                'password' => Hash::make('password123'),
                'type' => 'owner',
                'phone_number' => '+91 9432109876',
                'whatsapp_number' => '+91 9432109876',
                'city' => 'Mumbai',
                'address' => '204 Juhu Tara Road, Juhu, Mumbai',
                'shop_name' => 'Precision Alterations & Fits',
                'rating' => 4.80,
                'review_count' => 19,
                'is_featured' => false,
            ]
        ];

        foreach ($shopsData as $data) {
            $shop = User::firstOrCreate(
                ['email' => $data['email']],
                $data
            );
            $shop->update($data);

            // Create sample services for shop
            TailorService::firstOrCreate(
                ['user_id' => $shop->id, 'title' => 'Bespoke 2-Piece Suit Stitching'],
                [
                    'description' => 'Custom fitted 2-piece suit with premium canvas lining and hand-finished lapels.',
                    'price_starts_at' => 4500.00,
                    'estimated_days' => 7,
                    'category' => 'Suits',
                    'is_active' => true,
                ]
            );

            TailorService::firstOrCreate(
                ['user_id' => $shop->id, 'title' => 'Custom Formal Shirt'],
                [
                    'description' => 'Tailored formal shirt with choice of collar, cuff styles, and monogramming.',
                    'price_starts_at' => 950.00,
                    'estimated_days' => 3,
                    'category' => 'Shirts',
                    'is_active' => true,
                ]
            );

            TailorService::firstOrCreate(
                ['user_id' => $shop->id, 'title' => 'Traditional Designer Sherwani'],
                [
                    'description' => 'Hand-embroidered wedding sherwani with custom fitting and inner lining.',
                    'price_starts_at' => 12500.00,
                    'estimated_days' => 12,
                    'category' => 'Traditional',
                    'is_active' => true,
                ]
            );
        }

        // Get customer user or create default customer
        $customer = User::where('type', 'customer')->first();
        if (!$customer) {
            $customer = User::create([
                'name' => 'Naimish Verma',
                'email' => 'naimish@spirehubs.com',
                'password' => Hash::make('password123'),
                'type' => 'customer',
                'phone_number' => '+91 9999888777',
                'city' => 'Mumbai',
            ]);
        }

        if ($customer) {
            // Seed Sample Orders
            Order::firstOrCreate(
                ['order_id' => 8829],
                [
                    'customer_id' => $customer->id,
                    'order_date' => now()->subDays(2)->toDateString(),
                    'deadline_date' => now()->addDays(5)->toDateString(),
                    'quantity' => 1,
                    'febric' => 'Italian Fine Wool',
                    'febric_color' => 'Navy Blue',
                    'gender' => 'male',
                    'status' => 'in_progress',
                    'notes' => 'Bespoke 2-Piece Italian Wool Suit. Slim lapel, double vent back.',
                    'tracking_token' => Str::random(20),
                ]
            );

            Order::firstOrCreate(
                ['order_id' => 8742],
                [
                    'customer_id' => $customer->id,
                    'order_date' => now()->subDays(5)->toDateString(),
                    'deadline_date' => now()->addDays(1)->toDateString(),
                    'quantity' => 2,
                    'febric' => 'Egyptian Giza Cotton',
                    'febric_color' => 'Pure White',
                    'gender' => 'male',
                    'status' => 'completed',
                    'notes' => 'Custom Tuxedo Shirt with French Cuffs.',
                    'tracking_token' => Str::random(20),
                ]
            );

            Order::firstOrCreate(
                ['order_id' => 8910],
                [
                    'customer_id' => $customer->id,
                    'order_date' => now()->subDays(1)->toDateString(),
                    'deadline_date' => now()->addDays(8)->toDateString(),
                    'quantity' => 1,
                    'febric' => 'Raw Silk & Gold Thread',
                    'febric_color' => 'Royal Cream',
                    'gender' => 'male',
                    'status' => 'pending',
                    'notes' => 'Hand-embroidered Wedding Sherwani.',
                    'tracking_token' => Str::random(20),
                ]
            );

            // Seed Sample Appointments if model table exists
            try {
                if (class_exists(Appointment::class)) {
                    Appointment::firstOrCreate(
                        ['customer_id' => $customer->id, 'appointment_date' => now()->addDays(2)->toDateString()],
                        [
                            'appointment_time' => '11:30 AM',
                            'type' => 'Trial & Fitting Session',
                            'status' => 'confirmed',
                            'notes' => 'First fitting trial for Italian Wool Suit #8829',
                        ]
                    );

                    Appointment::firstOrCreate(
                        ['customer_id' => $customer->id, 'appointment_date' => now()->addDays(7)->toDateString()],
                        [
                            'appointment_time' => '04:00 PM',
                            'type' => 'Final Garment Pickup',
                            'status' => 'confirmed',
                            'notes' => 'Final inspection and pickup',
                        ]
                    );
                }
            } catch (\Throwable $e) {}
        }
    }
}
