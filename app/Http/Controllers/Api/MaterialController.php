<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $parentId = parentId();
        $materials = Material::where('parent_id', $parentId)
            ->orderBy('name')
            ->get();

        if ($materials->isEmpty()) {
            $demos = [
                [
                    'name' => 'Brass Blazer Buttons',
                    'code' => 'BTN-BRASS-01',
                    'category' => 'button',
                    'color_name' => 'Gold',
                    'unit' => 'Units',
                    'quantity' => 42,
                    'reorder_level' => 50,
                    'unit_cost' => 15.00,
                    'description' => 'Vintage Series Blazer Buttons',
                    'parent_id' => $parentId,
                ],
                [
                    'name' => 'Super 120s Wool - Black',
                    'code' => 'FAB-WOL-120',
                    'category' => 'fabric',
                    'color_name' => 'Black',
                    'unit' => 'Meters',
                    'quantity' => 18.5,
                    'reorder_level' => 10,
                    'unit_cost' => 1200.00,
                    'description' => 'Luxury Italian Suit Fabric',
                    'parent_id' => $parentId,
                ],
                [
                    'name' => 'Viscose Lining - Silver',
                    'code' => 'LIN-VIS-09',
                    'category' => 'lining',
                    'color_name' => 'Silver',
                    'unit' => 'Meters',
                    'quantity' => 4.0,
                    'reorder_level' => 15,
                    'unit_cost' => 350.00,
                    'description' => 'Standard Utility Lining',
                    'parent_id' => $parentId,
                ],
                [
                    'name' => 'YKK Invisible Zip - Grey',
                    'code' => 'ZIP-YKK-03',
                    'category' => 'zip',
                    'color_name' => 'Grey',
                    'unit' => 'Units',
                    'quantity' => 120,
                    'reorder_level' => 30,
                    'unit_cost' => 25.00,
                    'description' => 'Fasteners for Trousers & Skirts',
                    'parent_id' => $parentId,
                ],
            ];

            foreach ($demos as $d) {
                Material::create($d);
            }

            $materials = Material::where('parent_id', $parentId)->orderBy('name')->get();
        }

        $formatted = $materials->map(function ($m) {
            return [
                'id' => $m->id,
                'name' => $m->name,
                'code' => $m->code ?? 'MAT-' . $m->id,
                'category' => strtoupper($m->category ?? 'FABRIC'),
                'raw_category' => $m->category,
                'color_name' => $m->color_name ?? 'Default',
                'quantity' => (float) ($m->quantity ?? 0),
                'unit' => $m->unit ?? 'Units',
                'cost_per_unit' => (float) ($m->unit_cost ?? $m->cost_per_unit ?? 0),
                'reorder_level' => (float) ($m->reorder_level ?? 10),
                'is_low' => ($m->quantity ?? 0) <= ($m->reorder_level ?? 10),
                'supplier' => $m->description ?? 'Standard Supplier',
            ];
        });

        return response()->json([
            'success' => true,
            'materials' => $formatted,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'unit_cost' => 'nullable|numeric|min:0',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'reorder_level' => 'nullable|numeric|min:0',
        ]);

        $cost = $request->unit_cost ?? $request->cost_per_unit ?? 0;

        $material = Material::create([
            'name' => $request->name,
            'code' => $request->code ?? ('MAT-' . strtoupper(substr(uniqid(), -4))),
            'category' => strtolower($request->category),
            'color_name' => $request->color_name ?? 'Default',
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'unit_cost' => $cost,
            'reorder_level' => $request->reorder_level ?? 10,
            'description' => $request->supplier ?? $request->description,
            'parent_id' => parentId(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Material added successfully',
            'material' => $material,
        ]);
    }

    public function show($id)
    {
        $material = Material::where('parent_id', parentId())->findOrFail($id);
        return response()->json([
            'success' => true,
            'material' => [
                'id' => $material->id,
                'name' => $material->name,
                'code' => $material->code ?? 'MAT-' . $material->id,
                'category' => strtoupper($material->category ?? 'FABRIC'),
                'quantity' => (float) ($material->quantity ?? 0),
                'unit' => $material->unit ?? 'Units',
                'cost_per_unit' => (float) ($material->unit_cost ?? 0),
                'reorder_level' => (float) ($material->reorder_level ?? 10),
                'supplier' => $material->description ?? '',
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $material = Material::where('parent_id', parentId())->findOrFail($id);

        $cost = $request->unit_cost ?? $request->cost_per_unit ?? $material->unit_cost;

        $material->update([
            'name' => $request->name ?? $material->name,
            'category' => $request->category ? strtolower($request->category) : $material->category,
            'quantity' => $request->quantity ?? $material->quantity,
            'unit' => $request->unit ?? $material->unit,
            'unit_cost' => $cost,
            'reorder_level' => $request->reorder_level ?? $material->reorder_level,
            'description' => $request->supplier ?? $request->description ?? $material->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Material updated successfully',
            'material' => $material,
        ]);
    }

    public function destroy($id)
    {
        $material = Material::where('parent_id', parentId())->findOrFail($id);
        $material->delete();

        return response()->json([
            'success' => true,
            'message' => 'Material deleted successfully',
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
