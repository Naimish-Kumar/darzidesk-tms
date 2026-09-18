<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\FAQ;
use Illuminate\Http\Request;

class LandingSegmentController extends Controller
{
    /**
     * Dedicated Pricing Page
     */
    public function pricing()
    {
        $subscriptions = Subscription::orderBy('package_amount', 'asc')->get();
        $faqs = [
            [
                'q' => 'Is there a free trial available?',
                'a' => 'Yes! DarziDesk offers a 14-day full-access free trial. No credit card or upfront commitment required to start.'
            ],
            [
                'q' => 'Can I upgrade or downgrade my plan anytime?',
                'a' => 'Absolutely. You can switch between Monthly and Annual plans or upgrade to higher capacity plans as your shop grows.'
            ],
            [
                'q' => 'Do you support Indian payment methods (UPI, Cards, Netbanking)?',
                'a' => 'Yes, we integrate seamlessly with Razorpay, UPI, PhonePe, Google Pay, PayTM, Credit/Debit cards, and Netbanking.'
            ],
            [
                'q' => 'Does DarziDesk work on Android and iPhone?',
                'a' => 'Yes! You can download the native DarziDesk mobile app from both Google Play Store and Apple App Store, and also access your store from any laptop/desktop web browser.'
            ],
            [
                'q' => 'Will your team help me migrate my old customer records & measurements?',
                'a' => 'Yes! Our support team provides dedicated onboarding assistance, bulk customer import, and one-on-one setup over WhatsApp/phone.'
            ]
        ];

        return view('home_pages.pricing', compact('subscriptions', 'faqs'));
    }

    /**
     * Dedicated Segment Landing Pages for SEO
     */
    public function showSegment($slug)
    {
        $segments = $this->getSegmentData();

        if (!isset($segments[$slug])) {
            abort(404);
        }

        $segment = $segments[$slug];
        $subscriptions = Subscription::orderBy('package_amount', 'asc')->get();

        return view('landing_pages.segment', compact('segment', 'subscriptions', 'slug'));
    }

    /**
     * Segment Meta, Copy & Features Dictionary
     */
    private function getSegmentData()
    {
        return [
            'tailoring-shop-management-software' => [
                'meta_title' => 'Tailoring Shop Management Software India | DarziDesk',
                'meta_desc' => 'Best tailoring shop management software in India. Track customer measurements, orders, karigar assignments, and billing from mobile and web.',
                'badge' => 'All-In-One Tailoring Software',
                'h1' => 'Tailoring Shop Management Software Built for India',
                'subtitle' => 'Say goodbye to lost paper registers and chaotic WhatsApp messages. Streamline your entire tailoring workshop from measurement to final delivery.',
                'target_audience' => 'Independent Tailors, Custom Suit Makers & Garment Workshops',
                'pain_points' => [
                    'Lost or torn paper measurement cards when repeat customers return',
                    'Missing promised delivery dates leading to angry customers',
                    'Karigars forgetting garment design specs and urgent alteration requests',
                    'Zero record of advance deposits and pending balance payments'
                ],
                'features' => [
                    ['icon' => 'straighten', 'title' => 'Digital Measurement Vault', 'desc' => 'Save detailed measurements for Suits, Shirts, Kurta-Pajama, Sherwanis with zero errors.'],
                    ['icon' => 'view_kanban', 'title' => 'Live Production Pipeline', 'desc' => 'Move orders across Cutting, Stitching, Trial, and Ready stages in real time.'],
                    ['icon' => 'receipt_long', 'title' => 'Advance Deposit & Invoicing', 'desc' => 'Collect advance, generate thermal/PDF bills, and send instant WhatsApp receipts.'],
                    ['icon' => 'group', 'title' => 'Worker & Karigar Pay', 'desc' => 'Assign master cutters and tailors with automated piece-rate wage calculation.']
                ],
                'faqs' => [
                    ['q' => 'Can small single-worker shops use DarziDesk?', 'a' => 'Yes! DarziDesk is designed for shops of all sizes — from single-tailor shops to multi-branch studios.'],
                    ['q' => 'Is it easy to use for non-tech-savvy tailors?', 'a' => '100%. The interface is simple, visual, and available in clean Hindi and English with one-tap order creation.'],
                    ['q' => 'Does it work offline?', 'a' => 'Your data is securely synchronized on the cloud so you never lose customer records even if you switch phones.']
                ]
            ],

            'boutique-management-software' => [
                'meta_title' => 'Boutique Management Software in India | DarziDesk',
                'meta_desc' => 'Streamline your boutique business with DarziDesk. Manage designer orders, fabric stock, client fittings, bridal customization and GST invoices.',
                'badge' => 'Boutique & Designer TMS',
                'h1' => 'Smart Boutique Management Software for Designer Studios',
                'subtitle' => 'Deliver an elite experience for your boutique clientele. Manage custom dress designing, fabric inventory, trial fittings, and sales reports in one sleek platform.',
                'target_audience' => 'Fashion Boutiques, Custom Dressmakers & Bridal Studios',
                'pain_points' => [
                    'Difficult to track custom bridal embroidery and stitching deadlines',
                    'Fabric meterage stock wastage and untracked supplier bills',
                    'Managing multiple trial fitting dates across high-value clients',
                    'Unprofessional manual handwritten slips given to premium clients'
                ],
                'features' => [
                    ['icon' => 'apparel', 'title' => 'Designer Catalog & Specs', 'desc' => 'Attach reference photos, necklines, sleeve styles, and embroidery notes per order.'],
                    ['icon' => 'inventory', 'title' => 'Fabric Stock Ledger', 'desc' => 'Track fabric rolls in meters/yards with automated low-stock reorder warnings.'],
                    ['icon' => 'event', 'title' => 'Trial Fitting Scheduler', 'desc' => 'Schedule and notify clients automatically for trials, basting, and final pick-up.'],
                    ['icon' => 'verified', 'title' => 'Branded GST Invoices', 'desc' => 'Send beautiful digital invoices with your boutique logo directly on WhatsApp.']
                ],
                'faqs' => [
                    ['q' => 'Can I upload custom design sketches or dress photos?', 'a' => 'Yes, you can attach client photo references and pattern sketches directly to order cards.'],
                    ['q' => 'Can I manage multiple boutique branches?', 'a' => 'Yes, DarziDesk Master Studio plan supports multi-branch governance with separate staff access.']
                ]
            ],

            'ladies-tailor-management-software' => [
                'meta_title' => 'Ladies Tailor Software | Blouse, Suit & Kurti Tailoring App',
                'meta_desc' => 'Specialized software for Ladies Tailors in India. Save measurements for Blouse, Kurti, Salwar Suit, Lehengas, and send WhatsApp delivery alerts.',
                'badge' => 'Built For Ladies Tailoring',
                'h1' => 'Ladies Tailor Management Software & Measurement App',
                'subtitle' => 'Manage Blouse, Kurti, Lehenga, Salwar, Gowns, and Western wear measurements with ease. Keep customer patterns organized forever.',
                'target_audience' => 'Ladies Tailors, Blouse Specialists & Women Wear Boutiques',
                'pain_points' => [
                    'Dozens of measurement points for Blouses, Anarkalis & Lehengas written on messy diaries',
                    'Customers complaining about fitting changes across different seasons',
                    'Heavy wedding season order rush leading to mixed-up cloth pieces',
                    'Manual phone calls to tell customers their dresses are ready'
                ],
                'features' => [
                    ['icon' => 'design_services', 'title' => 'Pre-Built Ladies Templates', 'desc' => 'Ready-made templates for Blouse (Katori, Princess cut), Salwar Suit, Kurti, Plazos & Lehengas.'],
                    ['icon' => 'history', 'title' => 'Measurement History', 'desc' => 'Store date-wise alteration history and fitting preferences per customer.'],
                    ['icon' => 'sms', 'title' => 'Automated Ready Alerts', 'desc' => 'Send 1-click WhatsApp message: "Aapka Suit/Blouse ready hai, pick up kar lein".'],
                    ['icon' => 'qr_code_2', 'title' => 'Garment QR Tags', 'desc' => 'Print tags for cloth pieces so workers never mix up fabrics or borders.']
                ],
                'faqs' => [
                    ['q' => 'Are Indian ladies garment measurement fields available?', 'a' => 'Yes! Katori cut, Deep neck, Shoulder, Apex point, Waist, Armhole, Bottom flair, and 30+ tailored fields are built-in.'],
                    ['q' => 'Can my master cutter access measurements on a tablet or phone?', 'a' => 'Yes! Cutters can view precise measurements on any Android/iOS mobile or tablet in the workshop.']
                ]
            ],

            'mens-tailor-management-software' => [
                'meta_title' => 'Men\'s Tailor Software | Suit, Shirt & Tuxedo Tailoring App',
                'meta_desc' => 'Complete Men\'s Tailoring Software. Manage Bespoke Suits, Tuxedos, Blazers, Sherwanis, Kurta-Pajama, Safari Suits & Coat-Pant measurements.',
                'badge' => 'Bespoke Men\'s Tailoring',
                'h1' => 'Men\'s Tailor Management Software & Bespoke Suite',
                'subtitle' => 'Crafted for master cutters and suiting specialists. Manage full bespoke tailoring, CMT jobs, style selections, and trial fittings seamlessly.',
                'target_audience' => 'Men\'s Tailors, Suiting & Shirting Stores, Bespoke Ateliers',
                'pain_points' => [
                    'Complex measurements (Chest, Posture, Shoulders, Inseam, Rise) lost in registers',
                    'Tracking suit jacket styling (Single/Double breasted, Peak/Notch lapel, Vents)',
                    'Multi-stage production (Cutting -> Basting -> Canvas Fitting -> Hand Finishing)',
                    'Managing high-value cloth provided by customers (CMT orders)'
                ],
                'features' => [
                    ['icon' => 'style', 'title' => 'Bespoke Style Configurator', 'desc' => 'Select Lapel styles, Pocket types, Buttons, Lining choices, and Monogram details.'],
                    ['icon' => 'straighten', 'title' => 'Anatomical Measurements', 'desc' => 'Record posture adjustments, shoulder slope, chest drop, and sleeve crowns accurately.'],
                    ['icon' => 'engineering', 'title' => 'Master Cutter Job Cards', 'desc' => 'Generate printable cutting & tailoring job tickets with full cutting instructions.'],
                    ['icon' => 'payments', 'title' => 'Advance & Balance Split POS', 'desc' => 'Log booking advance, trial installment, and final delivery balance instantly.']
                ],
                'faqs' => [
                    ['q' => 'Can we configure Sherwani and Indo-Western styles?', 'a' => 'Yes, full support for 2-piece/3-piece suits, Bandhgala, Nehru Jacket, Kurta-Pajama, and Sherwanis.'],
                    ['q' => 'Can we print thermal receipts for customers?', 'a' => 'Yes, supports standard 2-inch, 3-inch Bluetooth thermal printers and A4/A5 PDF invoices.']
                ]
            ],

            'tailor-measurement-management' => [
                'meta_title' => 'Tailor Measurement App & Digital Measurement Book | DarziDesk',
                'meta_desc' => 'Replace paper measurement diary with DarziDesk digital measurement book. Save unlimited customer measurements with instant search and unit conversion.',
                'badge' => 'Digital Measurement Book',
                'h1' => 'Digital Measurement Book & Management Software',
                'subtitle' => 'Never lose a customer\'s measurement card again. Search any customer by phone number or name in 1 second and reuse their saved measurements.',
                'target_audience' => 'Tailoring Masters, Pattern Cutters, Boutique Owners',
                'pain_points' => [
                    'Flipping through 500 pages of paper diaries to find one old measurement',
                    'Customer asks to make a new shirt with "same old fitting" and diary is lost',
                    'Confusion between inches, centimeters, and fractional measurements (1/2, 1/4, 3/4)',
                    'Paper measurement registers getting damaged by tea spills or water'
                ],
                'features' => [
                    ['icon' => 'search', 'title' => '1-Second Customer Search', 'desc' => 'Type customer name or mobile number to instantly pull up all past garment measurements.'],
                    ['icon' => 'calculate', 'title' => 'Unit Conversion & Fractions', 'desc' => 'Supports Inches with fractions (1/4, 1/2, 3/4) and Centimeters with auto-conversion.'],
                    ['icon' => 'cloud_sync', 'title' => '100% Safe Cloud Backup', 'desc' => 'Your measurement records are encrypted and backed up daily in the secure cloud.'],
                    ['icon' => 'share', 'title' => 'WhatsApp Measurement Sharing', 'desc' => 'Share measurement slip with customer or karigar with one tap on WhatsApp.']
                ],
                'faqs' => [
                    ['q' => 'Can I add custom measurement fields for unique dresses?', 'a' => 'Yes! You can define custom measurement parameters for any cloth type or styling need.'],
                    ['q' => 'Is there a limit on how many measurements I can save?', 'a' => 'No limit on standard plans. Save thousands of customer measurement books securely.']
                ]
            ],

            'tailoring-billing-software' => [
                'meta_title' => 'Tailoring Billing Software & POS System in India | DarziDesk',
                'meta_desc' => 'Fast, easy billing software for tailor shops & boutiques. Manage advance payments, pending balance, thermal bills, GST invoices and WhatsApp receipts.',
                'badge' => 'Tailoring POS & Invoicing',
                'h1' => 'Tailoring Billing Software & POS Invoicing System',
                'subtitle' => 'Professional billing made effortless for tailoring businesses. Track advance cash deposits, pending customer balances, and daily sales collection.',
                'target_audience' => 'Tailor Shops, Boutiques, Alteration Centers, Retail Tailors',
                'pain_points' => [
                    'Customers disputing how much advance they paid at booking time',
                    'Garments delivered without collecting pending payment balance',
                    'Uncertainty about daily cash register collection vs expenses',
                    'Expensive, complicated traditional accounting software built for grocery stores'
                ],
                'features' => [
                    ['icon' => 'point_of_sale', 'title' => 'Advance Deposit Tracking', 'desc' => 'Record advance cash/UPI deposits at booking and lock balance for delivery checkout.'],
                    ['icon' => 'print', 'title' => 'Thermal & Digital Invoices', 'desc' => 'Print on 58mm/80mm receipt printers or dispatch branded WhatsApp invoice PDFs.'],
                    ['icon' => 'account_balance_wallet', 'title' => 'Daily Register Reconciliation', 'desc' => 'Calculate daily cash, UPI, card intake and reconcile store expenses automatically.'],
                    ['icon' => 'receipt', 'title' => 'GST & Non-GST Support', 'desc' => 'Easily apply CGST/SGST or operate in simple composite/non-GST mode.']
                ],
                'faqs' => [
                    ['q' => 'Can I send bills on WhatsApp without printing paper?', 'a' => 'Yes! 1-click WhatsApp bill sharing with complete garment breakdown and payment balance.'],
                    ['q' => 'Can I track expense payments like thread, buttons, electricity?', 'a' => 'Yes, DarziDesk includes full store expense tracking and monthly profit/loss reports.']
                ]
            ],

            'tailoring-order-management' => [
                'meta_title' => 'Tailoring Order Management System & Production Kanban | DarziDesk',
                'meta_desc' => 'Track tailoring orders from booking to delivery. Visual kanban board, stage updates, urgent order tags, karigar assignment & delivery calendar.',
                'badge' => 'Order Pipeline & Kanban',
                'h1' => 'Tailoring Order Tracking & Production Pipeline Software',
                'subtitle' => 'Never miss a delivery date again. Manage cutting, stitching, trials, alterations, and deliveries from one visual live dashboard.',
                'target_audience' => 'Tailoring Workshops, Production Managers, Boutiques',
                'pain_points' => [
                    'Customer standing in shop for delivery and garment is not even cut yet',
                    'No visual clue on which karigar has which cloth piece',
                    'Urgent wedding orders buried under regular alteration jobs',
                    'Master cutter and stitching worker blaming each other for delays'
                ],
                'features' => [
                    ['icon' => 'view_column', 'title' => 'Visual Production Kanban', 'desc' => 'Drag and drop orders between Pending, Cutting, Stitching, Trial, and Ready stages.'],
                    ['icon' => 'notifications_active', 'title' => 'Urgent Delivery Reminders', 'desc' => 'Color-coded urgent tags and automated alerts 24 hours before delivery date.'],
                    ['icon' => 'badge', 'title' => 'Karigar Task Assignment', 'desc' => 'Assign specific jobs to master cutters or tailors with target completion times.'],
                    ['icon' => 'calendar_month', 'title' => 'Delivery Calendar', 'desc' => 'View all daily, weekly, and monthly delivery commitments at a glance.']
                ],
                'faqs' => [
                    ['q' => 'Can customers check their order status online?', 'a' => 'Yes! Each order has a unique QR code / tracking link so clients can track status live without calling you.'],
                    ['q' => 'Can I filter orders by specific karigar or cloth type?', 'a' => 'Yes, instant filtering by delivery date, worker, garment category, or stage.']
                ]
            ],

            'tailoring-software-india' => [
                'meta_title' => 'Best Tailoring Software in India | Darzi Software App',
                'meta_desc' => 'The #1 Tailor Management Software in India. Designed specifically for Indian tailors, boutiques, karigars, UPI payments, and regional styles.',
                'badge' => 'Built For Indian Businesses',
                'h1' => 'India\'s #1 Tailoring Business Management Platform',
                'subtitle' => 'Built specifically for Indian darzi shops, designer boutiques, and garment workshops. Support for UPI, Hindi language, WhatsApp alerts, and Indian garment styles.',
                'target_audience' => 'Indian Tailors, Boutiques, Karigars & Master Cutters Across India',
                'pain_points' => [
                    'Foreign software doesn\'t support Kurta-Pajama, Blouse, Sherwani, or Indian sizing',
                    'Foreign software charges in expensive US Dollars and lacks UPI integration',
                    'Hard for Indian shop staff to navigate complex English-only ERPs',
                    'Lack of local phone and WhatsApp customer support'
                ],
                'features' => [
                    ['icon' => 'currency_rupee', 'title' => 'Affordable INR Pricing & UPI', 'desc' => 'Pocket-friendly Indian Rupee pricing with Razorpay, PhonePe, GPay, and PayTM support.'],
                    ['icon' => 'translate', 'title' => 'Hindi & Hinglish Friendly', 'desc' => 'Intuitive iconography and language support for shop owners and karigars.'],
                    ['icon' => 'chat', 'title' => 'Native WhatsApp Integration', 'desc' => 'Dispatch order updates, receipts, measurement cards, and fitting reminders on WhatsApp.'],
                    ['icon' => 'support_agent', 'title' => 'Direct Indian Support Team', 'desc' => 'Get phone and WhatsApp assistance from our support team based in India.']
                ],
                'faqs' => [
                    ['q' => 'Do I need a computer/laptop or will my smartphone work?', 'a' => 'You can run 100% of your business using our Android/iOS mobile app right from your smartphone!'],
                    ['q' => 'Is my customer data safe and private?', 'a' => 'Yes, your data belongs strictly to your business. We use bank-grade encryption and daily cloud backups.']
                ]
            ]
        ];
    }
}
