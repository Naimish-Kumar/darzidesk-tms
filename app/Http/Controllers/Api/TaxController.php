<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index()
    {
        $taxes = Tax::where('parent_id', parentId())
            ->orderBy('id', 'desc')
            ->get();
        return response()->json(['success' => true, 'data' => $taxes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tax' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);

        $tax = Tax::create([
            'tax' => $request->tax,
            'rate' => $request->rate,
            'parent_id' => parentId(),
        ]);

        return response()->json(['success' => true, 'message' => 'Tax created', 'data' => $tax]);
    }

    public function update(Request $request, $id)
    {
        $tax = Tax::where('parent_id', parentId())->findOrFail($id);
        $request->validate([
            'tax' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);

        $tax->tax = $request->tax;
        $tax->rate = $request->rate;
        $tax->save();

        return response()->json(['success' => true, 'message' => 'Tax updated', 'data' => $tax]);
    }

    public function destroy($id)
    {
        $tax = Tax::where('parent_id', parentId())->findOrFail($id);
        $tax->delete();
        return response()->json(['success' => true, 'message' => 'Tax deleted']);
    }
}
