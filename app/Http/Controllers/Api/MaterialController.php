<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::where('parent_id', parentId())
            ->orderBy('name')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'name' => $m->name,
                    'category' => $m->category,
                    'quantity' => $m->quantity,
                    'unit' => $m->unit,
                    'cost_per_unit' => $m->cost_per_unit,
                    'reorder_level' => $m->reorder_level,
                    'supplier' => $m->supplier,
                ];
            });

        return response()->json([
            'success' => true,
            'materials' => $materials,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:fabric,thread,button,zip,lining,interlining,other',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'reorder_level' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
        ]);

        $material = Material::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Material added successfully',
            'material' => $material,
        ]);
    }

    public function restock(Request $request, $id)
    {
        $request->validate(['add_quantity' => 'required|numeric|min:0.01']);

        $material = Material::where('parent_id', parentId())->findOrFail($id);
        $material->quantity += $request->add_quantity;
        $material->save();

        return response()->json([
            'success' => true,
            'message' => 'Restocked successfully',
            'new_quantity' => $material->quantity,
        ]);
    }
}
