<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClothType;
use Illuminate\Http\Request;

class ClothTypeController extends Controller
{
    public function index()
    {
        $clothTypes = ClothType::where('parent_id', parentId())->get();
        return response()->json(['success' => true, 'data' => $clothTypes]);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'gender' => 'required',
            'amount' => 'required',
        ]);

        $clothType = new ClothType();
        $clothType->parent_id = parentId();
        $clothType->title = $request->title;
        $clothType->gender = $request->gender;
        $clothType->amount = $request->amount;
        $clothType->taxes = !empty($request->taxes) ? implode(',', (array)$request->taxes) : null;
        $clothType->note = $request->note ?? null;
        $clothType->save();

        if ($request->has('measurements') && is_array($request->measurements)) {
            foreach ($request->measurements as $measure) {
                $clothMeasureType = new \App\Models\ClothMeasureType();
                $clothMeasureType->cloth_type_id = $clothType->id;
                $clothMeasureType->title = $measure['title'];
                $clothMeasureType->unit = $measure['unit'];
                $clothMeasureType->order = $measure['order'] ?? 0;
                $clothMeasureType->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Cloth Type created successfully',
            'data' => $clothType
        ]);
    }

    public function update(Request $request, $id)
    {
        $clothType = ClothType::where('id', $id)->where('parent_id', parentId())->first();
        if (!$clothType) {
            return response()->json(['success' => false, 'message' => 'Cloth type not found'], 404);
        }

        $request->validate([
            'title' => 'required',
            'gender' => 'required',
            'amount' => 'required',
        ]);

        $clothType->title = $request->title;
        $clothType->gender = $request->gender;
        $clothType->amount = $request->amount;
        $clothType->taxes = !empty($request->taxes) ? implode(',', (array)$request->taxes) : null;
        $clothType->note = $request->note ?? null;
        $clothType->save();

        if ($request->has('measurements') && is_array($request->measurements)) {
            // In a real app we might update existing or delete omitted ones. For simplicity, we just clear and recreate them or update if ID is provided.
            // Let's clear and recreate to be simple.
            \App\Models\ClothMeasureType::where('cloth_type_id', $clothType->id)->delete();
            foreach ($request->measurements as $measure) {
                $clothMeasureType = new \App\Models\ClothMeasureType();
                $clothMeasureType->cloth_type_id = $clothType->id;
                $clothMeasureType->title = $measure['title'];
                $clothMeasureType->unit = $measure['unit'];
                $clothMeasureType->order = $measure['order'] ?? 0;
                $clothMeasureType->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Cloth Type updated successfully',
            'data' => $clothType
        ]);
    }

    public function destroy($id)
    {
        $clothType = ClothType::where('id', $id)->where('parent_id', parentId())->first();
        if (!$clothType) {
            return response()->json(['success' => false, 'message' => 'Cloth type not found'], 404);
        }

        \App\Models\ClothMeasureType::where('cloth_type_id', $clothType->id)->delete();
        $clothType->delete();

        return response()->json(['success' => true, 'message' => 'Cloth Type deleted successfully']);
    }
}
