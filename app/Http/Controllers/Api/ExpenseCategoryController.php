<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::where('parent_id', parentId())
            ->orderBy('id', 'desc')
            ->get();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $category = ExpenseCategory::create([
            'name' => $request->name,
            'parent_id' => parentId(),
        ]);

        return response()->json(['success' => true, 'message' => 'Expense category created', 'data' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = ExpenseCategory::where('parent_id', parentId())->findOrFail($id);
        $request->validate(['name' => 'required|string|max:255']);
        $category->name = $request->name;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Expense category updated', 'data' => $category]);
    }

    public function destroy($id)
    {
        $category = ExpenseCategory::where('parent_id', parentId())->findOrFail($id);
        $category->delete();
        return response()->json(['success' => true, 'message' => 'Expense category deleted']);
    }
}
