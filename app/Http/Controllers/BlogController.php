<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = [
            [
                'title' => 'How to manage tailoring business effectively',
                'slug' => 'how-to-manage-tailoring-business',
                'description' => 'Managing a tailoring business can be challenging. Learn how to digitalize your workflow and increase efficiency.',
                'image' => 'assets/images/landing/blog1.jpg',
                'date' => 'May 03, 2026'
            ],
            [
                'title' => 'Best software for tailors in India',
                'slug' => 'best-software-for-tailors-india',
                'description' => 'Looking for the best darzi software in India? Compare top features and choose the right one for your boutique.',
                'image' => 'assets/images/landing/blog2.jpg',
                'date' => 'May 02, 2026'
            ],
            [
                'title' => 'Digital vs manual tailoring management',
                'slug' => 'digital-vs-manual-tailoring',
                'description' => 'Why you should switch from paper registers to a digital Tailor Management System like DarziDesk.',
                'image' => 'assets/images/landing/blog3.jpg',
                'date' => 'May 01, 2026'
            ]
        ];

        return view('blog.index', compact('blogs'));
    }

    public function show($slug)
    {
        // Simple switch for static content as requested
        $content = [
            'how-to-manage-tailoring-business' => [
                'title' => 'How to manage tailoring business effectively',
                'content' => '<p>Tailoring business ko digital banaye! In today\'s fast-paced world, manual registers are not enough. Using a professional Tailor Management System (TMS) helps you track orders, manage customer measurements, and handle billing with ease.</p><p>Key tips: 1. Keep digital records. 2. Automate notifications. 3. Track deadlines.</p>',
                'date' => 'May 03, 2026'
            ],
            'best-software-for-tailors-india' => [
                'title' => 'Best software for tailors in India',
                'content' => '<p>If you are looking for tailor software India, DarziDesk is your best bet. It supports local payment gateways like Razorpay and offers an intuitive interface for both owners and staff.</p>',
                'date' => 'May 02, 2026'
            ],
            'digital-vs-manual-tailoring' => [
                'title' => 'Digital vs manual tailoring management',
                'content' => '<p>Manual tailoring registers are prone to errors and loss. Digital systems provide security, searchability, and scalability for your growing boutique software India needs.</p>',
                'date' => 'May 01, 2026'
            ]
        ];

        if (!isset($content[$slug])) {
            abort(404);
        }

        $blog = (object) $content[$slug];
        return view('blog.show', compact('blog'));
    }
}
