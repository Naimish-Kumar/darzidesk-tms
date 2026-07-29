<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $query = Supplier::where('parent_id', parentId());

        if ($category && $category !== 'All') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->orderBy('name', 'asc')->get();

        // Seed default demo suppliers if empty
        if ($suppliers->isEmpty() && !$search && (!$category || $category === 'All')) {
            $demoSuppliers = [
                [
                    'name' => 'Milanese Textiles Ltd',
                    'category' => 'FABRIC',
                    'specialization' => 'Specialization: Super 150s & Cashmere Blends',
                    'contact_person' => 'Alessandro Rossi',
                    'phone' => '+39 02 5551234',
                    'email' => 'contact@milanese-textiles.it',
                    'location' => 'Milan, IT',
                    'status' => 'ACTIVE',
                    'parent_id' => parentId(),
                ],
                [
                    'name' => 'Savile Row Buttons',
                    'category' => 'HARDWARE',
                    'specialization' => 'Specialization: Engraved Horn & Gold Plated',
                    'contact_person' => 'James Sterling',
                    'phone' => '+44 20 79460912',
                    'email' => 'orders@savilerowbuttons.co.uk',
                    'location' => 'London, UK',
                    'status' => 'ACTIVE',
                    'parent_id' => parentId(),
                ],
                [
                    'name' => 'Luxe Linings Int.',
                    'category' => 'TRIMMINGS',
                    'specialization' => 'Specialization: Silk & Bemberg Linings',
                    'contact_person' => 'Marie Dubois',
                    'phone' => '+33 4 72001122',
                    'email' => 'sales@luxelinings.fr',
                    'location' => 'Lyon, FR',
                    'status' => 'ACTIVE',
                    'parent_id' => parentId(),
                ],
            ];

            foreach ($demoSuppliers as $sup) {
                Supplier::create($sup);
            }

            $suppliers = Supplier::where('parent_id', parentId())->orderBy('name', 'asc')->get();
        }

        return response()->json([
            'success' => true,
            'suppliers' => $suppliers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:ACTIVE,INACTIVE,EXPIRED',
        ]);

        $supplier = Supplier::create([
            'name' => $request->name,
            'category' => $request->category ?? 'FABRIC',
            'specialization' => $request->specialization,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'email' => $request->email,
            'location' => $request->location,
            'status' => $request->status ?? 'ACTIVE',
            'parent_id' => parentId(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Supplier created successfully',
            'supplier' => $supplier,
        ]);
    }

    public function show($id)
    {
        $supplier = Supplier::where('parent_id', parentId())->findOrFail($id);

        return response()->json([
            'success' => true,
            'supplier' => $supplier,
        ]);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::where('parent_id', parentId())->findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:ACTIVE,INACTIVE,EXPIRED',
        ]);

        $supplier->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Supplier updated successfully',
            'supplier' => $supplier,
        ]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::where('parent_id', parentId())->findOrFail($id);
        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Supplier deleted successfully',
        ]);
    }
}
