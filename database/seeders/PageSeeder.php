<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about_us',
                'content' => '<h3>Empowering India\'s Tailoring Industry</h3><p>DarziDesk is a dedicated Tailoring Management System (TMS) built to solve the unique challenges faced by boutiques and tailoring shops in India. We believe that technology can help every darzi and boutique owner to organize their work, save time, and provide a better experience to their customers.</p><p>Our features include digital measurement records, order tracking, staff management, and automated notifications. Join the digital revolution with DarziDesk.</p>',
                'enabled' => 1,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy_policy',
                'content' => '<p>Privacy policy content goes here...</p>',
                'enabled' => 1,
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms_conditions',
                'content' => '<p>Terms and conditions content goes here...</p>',
                'enabled' => 1,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
