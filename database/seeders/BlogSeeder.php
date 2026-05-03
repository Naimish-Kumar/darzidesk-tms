<?php

namespace database\seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'How to manage tailoring business effectively',
                'slug' => 'how-to-manage-tailoring-business',
                'short_description' => 'Managing a tailoring business can be challenging. Learn how to digitalize your workflow and increase efficiency.',
                'content' => '<p>Tailoring business ko digital banaye! In today\'s fast-paced world, manual registers are not enough. Using a professional Tailor Management System (TMS) helps you track orders, manage customer measurements, and handle billing with ease.</p><p>Key tips: 1. Keep digital records. 2. Automate notifications. 3. Track deadlines.</p>',
                'is_active' => 1
            ],
            [
                'title' => 'Best software for tailors in India',
                'slug' => 'best-software-for-tailors-india',
                'short_description' => 'Looking for the best darzi software in India? Compare top features and choose the right one for your boutique.',
                'content' => '<p>If you are looking for tailor software India, DarziDesk is your best bet. It supports local payment gateways like Razorpay and offers an intuitive interface for both owners and staff.</p>',
                'is_active' => 1
            ],
            [
                'title' => 'Digital vs manual tailoring management',
                'slug' => 'digital-vs-manual-tailoring',
                'short_description' => 'Why you should switch from paper registers to a digital Tailor Management System like DarziDesk.',
                'content' => '<p>Manual tailoring registers are prone to errors and loss. Digital systems provide security, searchability, and scalability for your growing boutique software India needs.</p>',
                'is_active' => 1
            ]
        ];

        foreach ($blogs as $blogData) {
            Blog::updateOrCreate(['slug' => $blogData['slug']], $blogData);
        }
    }
}
