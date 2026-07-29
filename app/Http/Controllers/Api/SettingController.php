<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = settings();
        return response()->json([
            'success' => true,
            'settings' => [
                'app_name' => $settings['app_name'] ?? 'DarziDesk',
                'currency_symbol' => $settings['CURRENCY_SYMBOL'] ?? '₹',
                'currency' => $settings['currency'] ?? 'INR',
                'company_name' => $settings['company_name'] ?? '',
                'company_email' => $settings['company_email'] ?? '',
                'company_phone' => $settings['company_phone'] ?? '',
                'company_address' => $settings['company_address'] ?? '',
                'invoice_footer_title' => $settings['invoice_footer_title'] ?? '',
                'invoice_footer_notes' => $settings['invoice_footer_notes'] ?? '',
            ]
        ]);
    }

    public function store(Request $request)
    {
        $post = $request->except(['_token']);
        foreach ($post as $key => $value) {
            Setting::updateOrCreate(
                ['name' => $key, 'parent_id' => parentId()],
                ['value' => $value]
            );
        }

        return response()->json(['success' => true, 'message' => 'Settings updated successfully']);
    }
}
