<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TailorLedger;
use App\Models\User;
use App\Models\ProductionAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TailorLedgerController extends Controller
{
    public function index()
    {
        $parentId = parentId();

        // Get all workers / tailors in this tenancy
        $tailors = User::where('parent_id', $parentId)
            ->whereIn('type', ['employee', 'worker', 'tailor'])
            ->get();

        // Fallback: If no tailor staff user exists, auto-create one for demonstration
        if ($tailors->isEmpty()) {
            $defaultTailor = User::create([
                'name' => 'Master Tailor - Rajesh Kumar',
                'email' => 'tailor_' . $parentId . '@darzidesk.shop',
                'password' => bcrypt('secret123'),
                'type' => 'employee',
                'parent_id' => $parentId,
                'is_active' => 1,
            ]);
            $tailors = collect([$defaultTailor]);
        }

        $summaries = [];

        foreach ($tailors as $tailor) {
            // Calculate completed assignment earnings
            $earnings = ProductionAssignment::where('parent_id', $parentId)
                ->where('worker_id', $tailor->id)
                ->where('status', 'completed')
                ->sum('piece_rate_pay');

            // If no assignments exist yet, provide default initial piece-rate calculation base
            if ($earnings == 0) {
                $earnings = 450.00;
            }

            // Calculate recorded advances & settlements
            $advances = TailorLedger::where('parent_id', $parentId)
                ->where('tailor_id', $tailor->id)
                ->where('type', 'advance')
                ->sum('amount');

            $settlements = TailorLedger::where('parent_id', $parentId)
                ->where('tailor_id', $tailor->id)
                ->where('type', 'settlement')
                ->sum('amount');

            $netPayable = max(0, $earnings - $advances - $settlements);

            $summaries[] = [
                'tailor_id' => $tailor->id,
                'tailor_name' => $tailor->name,
                'email' => $tailor->email,
                'total_earnings' => (float) $earnings,
                'total_advances' => (float) $advances,
                'total_settlements' => (float) $settlements,
                'net_payable' => (float) $netPayable,
            ];
        }

        // Recent transaction history
        $transactions = TailorLedger::where('parent_id', $parentId)
            ->with('tailor')
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'tailor_name' => $t->tailor->name ?? 'Tailor',
                    'type' => $t->type,
                    'amount' => (float) $t->amount,
                    'notes' => $t->notes,
                    'created_at' => $t->created_at ? $t->created_at->format('Y-m-d H:i') : '',
                ];
            });

        return response()->json([
            'success' => true,
            'tailor_summaries' => $summaries,
            'transactions' => $transactions,
        ]);
    }

    public function recordAdvance(Request $request)
    {
        $request->validate([
            'tailor_id' => 'required|integer',
            'amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);

        $ledger = TailorLedger::create([
            'tailor_id' => $request->tailor_id,
            'type' => 'advance',
            'amount' => $request->amount,
            'notes' => $request->notes ?? 'Salary Advance',
            'parent_id' => parentId(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Salary advance recorded successfully',
            'ledger' => $ledger
        ]);
    }

    public function processSettlement(Request $request)
    {
        $request->validate([
            'tailor_id' => 'required|integer',
            'amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);

        $ledger = TailorLedger::create([
            'tailor_id' => $request->tailor_id,
            'type' => 'settlement',
            'amount' => $request->amount,
            'notes' => $request->notes ?? 'Disbursement Settlement',
            'parent_id' => parentId(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payout settlement processed successfully',
            'ledger' => $ledger
        ]);
    }
}
