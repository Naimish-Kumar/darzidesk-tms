<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::orderBy('name', 'asc')->get();
        $lowStockMaterials = $materials->filter(fn($m) => $m->isLowStock());

        return view('materials.index', compact('materials', 'lowStockMaterials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|numeric|min:0',
            'reorder_level' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Material::create($request->all());

        return redirect()->back()->with('success', __('Material added to inventory successfully.'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|numeric|min:0',
            'reorder_level' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $material->update($request->all());

        return redirect()->back()->with('success', __('Material inventory updated successfully.'));
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->back()->with('success', __('Material deleted successfully.'));
    }

    public function restock(Request $request, $id)
    {
        $request->validate([
            'add_quantity' => 'required|numeric|min:0.01',
        ]);

        $material = Material::findOrFail($id);
        $material->quantity += $request->add_quantity;
        $material->save();

        return redirect()->back()->with('success', __('Material restocked successfully.'));
    }
}
