<?php

namespace Database\Seeders;

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
                'title' => 'Best Tailoring Shop Management Software in India (2026 Guide)',
                'slug' => 'best-tailoring-shop-management-software-in-india',
                'short_description' => 'A complete comparison guide to choosing the best tailor software in India for managing measurements, orders, workers, and GST billing.',
                'content' => '<h2>Why Indian Tailors Need Dedicated Software</h2>
                <p>In 2026, running a tailoring shop or boutique using traditional paper registers is one of the biggest bottlenecks to growth. A modern <strong>Tailoring Management System (TMS)</strong> like DarziDesk simplifies everyday shop operations.</p>
                <h3>Top Features to Look For:</h3>
                <ul>
                    <li><strong>Digital Measurement Vault:</strong> Save measurements for Men (Suits, Shirts, Kurta) and Women (Blouses, Lehengas, Salwar Suits).</li>
                    <li><strong>Live Production Pipeline:</strong> Track cutting, basting, stitching, and trial fitting stages.</li>
                    <li><strong>WhatsApp Billing:</strong> Send instant digital invoices and delivery alerts to customers without printing paper.</li>
                    <li><strong>Karigar & Piece-Rate Tracking:</strong> Calculate worker wages accurately based on completed garments.</li>
                </ul>
                <p>Switch to DarziDesk today and experience seamless tailoring operations with a 14-day free trial.</p>',
                'is_active' => 1
            ],
            [
                'title' => 'How to Digitize Your Tailoring Business: Step-by-Step Guide',
                'slug' => 'how-to-digitize-your-tailoring-business',
                'short_description' => 'Learn how to transition from physical paper registers to digital cloud management in 4 simple steps without disrupting daily customer orders.',
                'content' => '<h2>Step-by-Step Migration from Registers to Digital Software</h2>
                <p>Many tailor shop owners worry that moving to software is complicated. With DarziDesk, the transition takes less than 24 hours.</p>
                <ol>
                    <li><strong>Step 1: Start Recording New Walk-ins Digitally:</strong> Whenever a new customer enters your shop, create their profile and save measurements on your mobile phone or tablet.</li>
                    <li><strong>Step 2: Track Orders on a Kanban Board:</strong> Assign status tags (Cutting, Stitching, Trial, Ready) instead of relying on verbal instructions.</li>
                    <li><strong>Step 3: Collect Advance Payments via UPI:</strong> Record booking deposits and automatically generate remaining balance calculations.</li>
                    <li><strong>Step 4: Send WhatsApp Ready Notifications:</strong> Delight clients with instant automated messages when their dress is ready for pickup.</li>
                </ol>',
                'is_active' => 1
            ],
            [
                'title' => 'How Tailors Can Manage Customer Measurements Without Paper Cards',
                'slug' => 'how-tailors-can-manage-customer-measurements',
                'short_description' => 'Say goodbye to lost measurement slips. Discover how digital measurement books help tailor shops save time and prevent costly fitting mistakes.',
                'content' => '<h2>The Problem with Paper Measurement Cards</h2>
                <p>Paper cards fade, get torn, stained with tea, or lost in drawer piles. When a loyal customer asks to replicate the exact fitting of a shirt made 6 months ago, searching a 500-page notebook is frustrating.</p>
                <h3>Advantages of Digital Measurement Vault:</h3>
                <ul>
                    <li>1-Second Search by customer name or mobile number.</li>
                    <li>Support for fractional inches (1/4, 1/2, 3/4) and centimeters.</li>
                    <li>Custom fields for complex ladies blouse cuts and bespoke suit postures.</li>
                    <li>100% encrypted cloud backup — accessible even if you change phones.</li>
                </ul>',
                'is_active' => 1
            ],
            [
                'title' => 'Notebook vs Tailoring Management Software: Which is Better for Your Shop?',
                'slug' => 'notebook-vs-tailoring-management-software',
                'short_description' => 'A detailed side-by-side comparison between manual bookkeeping and cloud TMS software for Indian tailoring stores and boutiques.',
                'content' => '<h2>Comparing Manual Registers vs Cloud Software</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Feature</th>
                            <th>Traditional Notebook</th>
                            <th>DarziDesk TMS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Search Speed</td>
                            <td>5–10 Minutes</td>
                            <td>1 Second</td>
                        </tr>
                        <tr>
                            <td>Delivery Reminders</td>
                            <td>Manual Memory</td>
                            <td>Automated 24h Alerts</td>
                        </tr>
                        <tr>
                            <td>Karigar Payroll</td>
                            <td>Frequent Disputes</td>
                            <td>Automated Piece-Rate Log</td>
                        </tr>
                        <tr>
                            <td>Data Security</td>
                            <td>High Risk of Loss/Damage</td>
                            <td>100% Cloud Encrypted</td>
                        </tr>
                    </tbody>
                </table>',
                'is_active' => 1
            ],
            [
                'title' => 'How to Track Tailoring Orders Efficiently & Eliminate Delivery Delays',
                'slug' => 'how-to-track-tailoring-orders-efficiently',
                'short_description' => 'Eliminate customer complaints about late delivery dates. Learn how visual production pipelines keep your master cutters and tailors on schedule.',
                'content' => '<h2>Why Tailoring Orders Get Delayed</h2>
                <p>Most delivery delays happen because shop owners lack visibility into workshop bottleneck stages. When an urgent wedding suit is buried under regular repair garments, delivery commitments fail.</p>
                <h3>How Visual Stage Tracking Solves This:</h3>
                <p>By organizing orders into clear visual columns (Pending -> Cutting -> Stitching -> Trial -> Ready), shop managers can spot delayed jobs days before the promised delivery date.</p>',
                'is_active' => 1
            ],
            [
                'title' => 'Best Boutique Management Software for Small Businesses',
                'slug' => 'best-boutique-management-software-for-small-businesses',
                'short_description' => 'Discover how boutique software helps fashion designers manage custom bridal wear, fabric stock, and client trial appointments seamlessly.',
                'content' => '<h2>Elevating Your Boutique Client Experience</h2>
                <p>Boutique customers expect a premium experience. Providing handwritten paper slips hurts your luxury brand perception.</p>
                <h3>Key Boutique Software Features:</h3>
                <ul>
                    <li>Attach reference design photos, embroidery sketches, and neckline styles.</li>
                    <li>Track fabric roll inventory in meters with low-stock reorder warnings.</li>
                    <li>Branded digital invoices sent directly over WhatsApp.</li>
                    <li>Trial fitting scheduling with automated SMS/WhatsApp reminders.</li>
                </ul>',
                'is_active' => 1
            ],
            [
                'title' => 'How to Manage Tailor Shop Payments, Advances & Invoices',
                'slug' => 'how-to-manage-tailor-shop-payments',
                'short_description' => 'Stop revenue leakage in your tailoring business. Master advance deposit tracking, balance payment collection, and daily cash reconciliation.',
                'content' => '<h2>Preventing Revenue Loss at Delivery Time</h2>
                <p>A common issue in tailoring shops is releasing finished garments without collecting full pending balances because nobody remembered what was paid as advance.</p>
                <h3>The Solution:</h3>
                <p>DarziDesk locks payment status and clearly prints the exact advance paid, discount applied, and remaining balance due on every receipt.</p>',
                'is_active' => 1
            ],
            [
                'title' => 'How to Grow Your Tailoring Business in India in 2026',
                'slug' => 'how-to-grow-your-tailoring-business-in-india',
                'short_description' => 'Actionable marketing and operational tips for tailor shop owners looking to double their repeat customer orders and boutique revenue.',
                'content' => '<h2>Proven Strategies to Scale Your Tailoring Revenue</h2>
                <ul>
                    <li><strong>Send Festival Greeting & Offer Broadcasts:</strong> Reach out to past customers before Diwali, Eid, and wedding seasons.</li>
                    <li><strong>Speed Up Delivery Times:</strong> On-time delivery is the #1 reason customers recommend a tailor to friends and family.</li>
                    <li><strong>Offer Professional Digital Receipts:</strong> Build trust with itemized digital bills showing fabric charges, stitching cost, and GST.</li>
                </ul>',
                'is_active' => 1
            ],
            [
                'title' => 'Digital Tools Every Boutique Owner & Fashion Designer Needs',
                'slug' => 'digital-tools-every-boutique-owner-needs',
                'short_description' => 'From digital measurement books to WhatsApp marketing and POS software, here are the essential digital tools for boutique entrepreneurs.',
                'content' => '<h2>The Essential Tech Stack for Modern Boutiques</h2>
                <p>Running a successful boutique requires blending creative design talent with disciplined operations. The right software handles the repetitive administrative tasks so designers can focus on styling.</p>',
                'is_active' => 1
            ],
            [
                'title' => 'How to Manage Multiple Tailors, Master Cutters and Workers',
                'slug' => 'how-to-manage-multiple-tailors-and-workers',
                'short_description' => 'Streamline karigar job assignments, monitor production output, and calculate piece-rate wages without daily arguments or confusion.',
                'content' => '<h2>Managing Tailoring Workshop Staff with Clarity</h2>
                <p>When you have 5 to 20 karigars working on different garments, tracking who cut which suit and who stitched which blouse becomes difficult without centralized software.</p>
                <p>DarziDesk assigns unique job cards and tracks individual worker productivity in real time.</p>',
                'is_active' => 1
            ]
        ];

        foreach ($blogs as $blogData) {
            Blog::updateOrCreate(['slug' => $blogData['slug']], $blogData);
        }
    }
}
