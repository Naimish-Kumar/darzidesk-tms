<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TailorService;
use Illuminate\Http\Request;

class TailorServiceController extends Controller
{
    /**
     * List shop owner's tailor services
     */
    public function index(Request $request)
    {
        $services = TailorService::where('user_id', parentId())
            ->orderBy('id', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $services]);
    }

    /**
     * Create a new tailor service / price list item
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_starts_at' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
            'category' => 'nullable|string',
        ]);

        $service = TailorService::create([
            'user_id' => parentId(),
            'title' => $request->title,
            'description' => $request->description,
            'price_starts_at' => $request->price_starts_at,
            'estimated_days' => $request->estimated_days,
            'category' => $request->category ?? 'General',
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service added to price list successfully',
            'data' => $service
        ]);
    }

    /**
     * Update an existing service
     */
    public function update(Request $request, $id)
    {
        $service = TailorService::where('user_id', parentId())->find($id);

        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Service not found'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'price_starts_at' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ]);

        $service->update($request->only([
            'title', 'description', 'price_starts_at', 'estimated_days', 'category', 'is_active'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully',
            'data' => $service
        ]);
    }

    /**
     * Delete a service
     */
    public function destroy($id)
    {
        $service = TailorService::where('user_id', parentId())->find($id);

        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Service not found'], 404);
        }

        $service->delete();

        return response()->json(['success' => true, 'message' => 'Service deleted successfully']);
    }
}
