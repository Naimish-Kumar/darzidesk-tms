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
                'content' => '<h3>DarziDesk Privacy Policy</h3><p>At DarziDesk, we protect your personal information, customer body measurement records, and shop data with enterprise-grade security.</p><h4>Information We Collect</h4><p>We collect essential account details, boutique profile settings, customer contact information, and body measurements required to deliver tailoring management services.</p><h4>Data Protection</h4><p>Body measurement logs and fitting photos are strictly isolated by shop account ID and encrypted using AES-256 standards.</p><p>For full details or account deletion, visit our <a href="/privacy-policy">Privacy Policy</a> and <a href="/delete-account">Account Deletion Portal</a>.</p>',
                'enabled' => 1,
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms_conditions',
                'content' => '<h3>DarziDesk Terms & Services</h3><p>By creating an account or accessing DarziDesk, you agree to our terms of service, subscription billing policies, and platform guidelines.</p><h4>Service Terms</h4><p>DarziDesk provides cloud software for tailoring shop management, order status tracking, thermal printing, and GST invoicing. Subscriptions are billed in advance.</p><p>For full details, visit our <a href="/terms-and-conditions">Terms & Conditions Page</a>.</p>',
                'enabled' => 1,
            ],
            [
                'title' => 'Delete Account',
                'slug' => 'delete_account',
                'content' => '<h3>Google Play Console Account & Data Deletion</h3><p>DarziDesk provides mobile and web users with complete rights to delete their account and personal data.</p><p>Submit your deletion request through our <a href="/delete-account">Account Deletion Request Form</a>.</p>',
                'enabled' => 1,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}

