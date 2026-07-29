<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MeasurementUnit;
use Illuminate\Http\Request;

class MeasurementUnitController extends Controller
{
    public function index()
    {
        $units = MeasurementUnit::where('parent_id', parentId())
            ->orderBy('id', 'desc')
            ->get();
        return response()->json(['success' => true, 'data' => $units]);
    }

    public function store(Request $request)
    {
        $request->validate(['unit' => 'required|string|max:255']);

        $unit = MeasurementUnit::create([
            'unit' => $request->unit,
            'parent_id' => parentId(),
        ]);

        return response()->json(['success' => true, 'message' => 'Measurement unit created', 'data' => $unit]);
    }

    public function update(Request $request, $id)
    {
        $unit = MeasurementUnit::where('parent_id', parentId())->findOrFail($id);
        $request->validate(['unit' => 'required|string|max:255']);
        $unit->unit = $request->unit;
        $unit->save();

        return response()->json(['success' => true, 'message' => 'Measurement unit updated', 'data' => $unit]);
    }

    public function destroy($id)
    {
        $unit = MeasurementUnit::where('parent_id', parentId())->findOrFail($id);
        $unit->delete();
        return response()->json(['success' => true, 'message' => 'Measurement unit deleted']);
    }
}
