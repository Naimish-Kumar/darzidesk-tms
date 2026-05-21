<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClothType;
use App\Models\Measurement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeasurementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Measurement::orderBy('id', 'desc');

        if ($user->type == 'customer') {
            $query->where('customer', $user->id);
        } elseif ($user->type == 'employee') {
            $query->where('responsible', $user->id);
        } else {
            $query->where('parent_id', parentId());
        }

        $measurements = $query->get()->map(function($m) {
            return [
                'id' => $m->id,
                'measurement_id' => $m->measurement_id,
                'customer_name' => $m->customer_user->name ?? 'Unknown',
                'cloth_type' => $m->cloth_type_user->title ?? 'Unknown',
                'date' => $m->date,
                'details' => $m->measurement_detail,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $measurements
        ]);
    }

    public function getFormData()
    {
        $customers = User::where('parent_id', parentId())
            ->where('type', 'customer')
            ->get(['id', 'name']);

        $staff = User::where('parent_id', parentId())
            ->where('type', '!=', 'customer')
            ->get(['id', 'name']);

        $clothTypes = ClothType::where('parent_id', parentId())
            ->get(['id', 'title']);

        return response()->json([
            'success' => true,
            'data' => [
                'customers' => $customers,
                'staff' => $staff,
                'cloth_types' => $clothTypes,
                'next_id' => measurementNumber()
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'customer' => 'required',
            'responsible' => 'required',
            'date' => 'required',
            'cloth_type' => 'required',
            'details' => 'required|array',
            'details.*.type' => 'required',
            'details.*.measurement' => 'required',
            'details.*.unit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $measurement = new Measurement();
        $measurement->measurement_id = $request->measurement_id ?? measurementNumber();
        $measurement->customer = $request->customer;
        $measurement->date = $request->date;
        $measurement->cloth_type = $request->cloth_type;
        $measurement->responsible = $request->responsible;
        $measurement->measurement_detail = $request->details;
        $measurement->parent_id = parentId();
        $measurement->save();

        return response()->json([
            'success' => true,
            'message' => 'Measurement saved successfully',
            'data' => $measurement
        ]);
    }

    public function update(Request $request, $id)
    {
        $measurement = Measurement::where('id', $id)->where('parent_id', parentId())->first();
        if (!$measurement) {
            return response()->json(['success' => false, 'message' => 'Measurement not found'], 404);
        }

        if ($request->customer) $measurement->customer = $request->customer;
        if ($request->date) $measurement->date = $request->date;
        if ($request->cloth_type) $measurement->cloth_type = $request->cloth_type;
        if ($request->responsible) $measurement->responsible = $request->responsible;
        if ($request->details) $measurement->measurement_detail = $request->details;
        $measurement->save();

        return response()->json([
            'success' => true,
            'message' => 'Measurement updated successfully',
            'data' => $measurement
        ]);
    }

    public function destroy($id)
    {
        $measurement = Measurement::where('id', $id)->where('parent_id', parentId())->first();
        if (!$measurement) {
            return response()->json(['success' => false, 'message' => 'Measurement not found'], 404);
        }
        $measurement->delete();
        return response()->json(['success' => true, 'message' => 'Measurement deleted successfully']);
    }
}
