<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $currency_symbol = settings()['CURRENCY_SYMBOL'] ?? '₹';
        $expenses = Expense::where('parent_id', parentId())
            ->orderBy('id', 'desc')
            ->get()
            ->map(function($e) use ($currency_symbol) {
                return [
                    'id' => $e->id,
                    'expense_id' => "#EXP" . $e->expense_id,
                    'title' => $e->title,
                    'amount' => $currency_symbol . number_format($e->amount, 2),
                    'date' => $e->date,
                    'category' => $e->category->name ?? 'Uncategorized',
                    'receipt' => !empty($e->receipt) ? asset('/storage/upload/receipt/' . $e->receipt) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $expenses
        ]);
    }

    public function getCategories()
    {
        $categories = ExpenseCategory::where('parent_id', parentId())->get(['id', 'name']);
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $expense = new Expense();
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->date = $request->date;
        $expense->category_id = $request->category_id;
        $expense->expense_id = $this->expenseNumber();
        $expense->parent_id = parentId();
        
        if ($request->hasFile('receipt')) {
            $receiptFileName = $request->file('receipt')->hashName();
            $request->file('receipt')->storeAs('upload/receipt/', $receiptFileName);
            $expense->receipt = $receiptFileName;
        }

        $expense->save();

        return response()->json([
            'success' => true,
            'message' => 'Expense recorded successfully',
            'data' => $expense
        ]);
    }

    private function expenseNumber()
    {
        $latest = Expense::where('parent_id', parentId())->latest()->first();
        return $latest ? $latest->expense_id + 1 : 1;
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::where('id', $id)->where('parent_id', parentId())->first();
        if (!$expense) {
            return response()->json(['success' => false, 'message' => 'Expense not found'], 404);
        }

        if ($request->title) $expense->title = $request->title;
        if ($request->amount) $expense->amount = $request->amount;
        if ($request->date) $expense->date = $request->date;
        if ($request->category_id) $expense->category_id = $request->category_id;

        if ($request->hasFile('receipt')) {
            $receiptFileName = $request->file('receipt')->hashName();
            $request->file('receipt')->storeAs('upload/receipt/', $receiptFileName);
            $expense->receipt = $receiptFileName;
        }

        $expense->save();

        return response()->json([
            'success' => true,
            'message' => 'Expense updated successfully',
            'data' => $expense
        ]);
    }

    public function destroy($id)
    {
        $expense = Expense::where('id', $id)->where('parent_id', parentId())->first();
        if (!$expense) {
            return response()->json(['success' => false, 'message' => 'Expense not found'], 404);
        }
        $expense->delete();
        return response()->json(['success' => true, 'message' => 'Expense deleted successfully']);
    }
}
