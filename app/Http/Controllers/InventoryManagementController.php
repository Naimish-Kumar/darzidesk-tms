<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class InventoryManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        $materials = $query->latest()->get();
        $totalMaterials = $materials->count();
        $lowStock = $materials->filter(function($m) { return $m->quantity <= ($m->alert_level ?? 5); })->count();

        return view('inventory.index', compact('materials', 'totalMaterials', 'lowStock'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'unit' => 'nullable|string|max:50',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        Material::create([
            'name' => $request->name,
            'code' => $request->code ?? 'MAT-'.rand(1000, 9999),
            'unit' => $request->unit ?? 'Meters',
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price ?? 0,
            'parent_id' => ownerId(),
        ]);

        return redirect()->route('inventory.index')->with('success', 'Fabric material registered successfully.');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('inventory.index')->with('success', 'Material removed successfully.');
    }
}
