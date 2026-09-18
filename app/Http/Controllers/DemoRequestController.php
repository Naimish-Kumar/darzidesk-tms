<?php

namespace App\Http\Controllers;

use App\Models\DemoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemoRequestController extends Controller
{
    /**
     * Store a newly created demo request.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'mobile' => 'required|string|max:20',
            'business_type' => 'nullable|string|max:255',
            'workers_count' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->first());
        }

        $demo = DemoRequest::create([
            'name' => $request->name,
            'business_name' => $request->business_name ?? 'Tailoring Shop',
            'city' => $request->city ?? '',
            'mobile' => $request->mobile,
            'business_type' => $request->business_type ?? 'Tailor Shop',
            'workers_count' => $request->workers_count ?? '1-5',
            'status' => 'pending',
        ]);

        // Pre-build WhatsApp text for easy direct connect
        $encodedMsg = urlencode("Hi DarziDesk Team, I just requested a Free Demo for my shop ({$demo->business_name}, {$demo->city}). Name: {$demo->name}, Phone: {$demo->mobile}. Please schedule my demo.");

        $whatsappUrl = "https://wa.me/919999999999?text={$encodedMsg}";

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Thank you! Your demo request has been received. Our team will contact you shortly.',
                'whatsapp_url' => $whatsappUrl,
                'data' => $demo
            ]);
        }

        return redirect()->back()->with('success', 'Thank you! Your demo request has been booked successfully. Our team will contact you within 2 business hours.')->with('whatsapp_url', $whatsappUrl);
    }
}
