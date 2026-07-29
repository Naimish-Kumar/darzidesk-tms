<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MeasurementHistory;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('parent_id', parentId())
            ->where('type', 'customer')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json(['success' => true, 'data' => $customers]);
    }

    public function show($id)
    {
        $customer = User::where('id', $id)
            ->where('parent_id', parentId())
            ->where('type', 'customer')
            ->first();

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }

        $measurementHistory = MeasurementHistory::where('customer_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($h) {
                return [
                    'id' => $h->id,
                    'field_name' => $h->field_name,
                    'old_value' => $h->old_value,
                    'new_value' => $h->new_value,
                    'changed_at' => $h->created_at->format('Y-m-d H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $customer,
            'fitting_photo_url' => $customer->fitting_photo ? asset('storage/' . $customer->fitting_photo) : null,
            'measurement_history' => $measurementHistory,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'body_shape' => 'nullable|string',
            'posture_notes' => 'nullable|string',
            'fitting_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $fittingPhotoPath = null;
        if ($request->hasFile('fitting_photo')) {
            $fittingPhotoPath = $request->file('fitting_photo')->store('fitting_photos', 'public');
        }

        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'body_shape' => $request->body_shape,
            'posture_notes' => $request->posture_notes,
            'fitting_photo' => $fittingPhotoPath,
            'password' => \Hash::make('customer123'),
            'type' => 'customer',
            'parent_id' => parentId(),
            'lang' => 'en',
        ]);

        return response()->json(['success' => true, 'data' => $customer]);
    }

    public function update(Request $request, $id)
    {
        $customer = User::where('id', $id)->where('parent_id', parentId())->where('type', 'customer')->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'body_shape' => 'nullable|string',
            'posture_notes' => 'nullable|string',
            'fitting_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $customer->name = $request->name;
        $customer->email = $request->email;
        if ($request->phone_number) $customer->phone_number = $request->phone_number;
        if ($request->has('body_shape')) $customer->body_shape = $request->body_shape;
        if ($request->has('posture_notes')) $customer->posture_notes = $request->posture_notes;

        if ($request->hasFile('fitting_photo')) {
            $customer->fitting_photo = $request->file('fitting_photo')->store('fitting_photos', 'public');
        }

        $customer->save();

        return response()->json(['success' => true, 'message' => 'Customer updated successfully', 'data' => $customer]);
    }

    public function destroy($id)
    {
        $customer = User::where('id', $id)->where('parent_id', parentId())->where('type', 'customer')->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }
        $customer->delete();
        return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
    }
}
