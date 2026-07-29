<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductionAssignment;
use App\Models\ProductionStage;
use App\Models\User;
use Illuminate\Http\Request;

class WorkerAssignmentController extends Controller
{
    public function index()
    {
        $assignments = ProductionAssignment::with(['order.customers', 'worker', 'stage'])
            ->orderBy('created_at', 'desc')
            ->get();

        $workers = User::whereIn('type', ['staff', 'employee', 'worker', 'owner'])->get();
        if ($workers->isEmpty()) {
            $workers = User::all();
        }

        $orders = Order::with('customers')->get();
        $stages = ProductionStage::orderBy('order_index', 'asc')->get();

        // Calculate piece-rate earnings summary per worker
        $workerEarnings = $assignments->groupBy('worker_id')->map(function ($items, $workerId) {
            $worker = User::find($workerId);
            $totalEarned = $items->where('status', 'completed')->sum('piece_rate_pay');
            $pendingEarned = $items->where('status', '!=', 'completed')->sum('piece_rate_pay');
            return [
                'worker' => $worker,
                'total_earned' => $totalEarned,
                'pending_earned' => $pendingEarned,
                'total_tasks' => $items->count(),
                'completed_tasks' => $items->where('status', 'completed')->count(),
            ];
        });

        return view('workers.assignments', compact('assignments', 'workers', 'orders', 'stages', 'workerEarnings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'worker_id' => 'required|exists:users,id',
            'stage_id' => 'nullable|exists:production_stages,id',
            'piece_rate_pay' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        ProductionAssignment::create([
            'order_id' => $request->order_id,
            'worker_id' => $request->worker_id,
            'stage_id' => $request->stage_id,
            'piece_rate_pay' => $request->piece_rate_pay,
            'status' => 'pending',
            'notes' => $request->notes,
            'assigned_at' => now(),
        ]);

        return redirect()->back()->with('success', __('Task assigned to tailor successfully.'));
    }

    public function updateStatus(Request $request, $id)
    {
        $assignment = ProductionAssignment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $assignment->status = $request->status;
        if ($request->status === 'completed') {
            $assignment->completed_at = now();
        }
        $assignment->save();

        return redirect()->back()->with('success', __('Task status updated successfully.'));
    }

    public function destroy($id)
    {
        $assignment = ProductionAssignment::findOrFail($id);
        $assignment->delete();

        return redirect()->back()->with('success', __('Assignment removed successfully.'));
    }
}
