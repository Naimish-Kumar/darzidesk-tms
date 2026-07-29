<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductionStage;
use App\Models\Order;
use App\Models\ProductionAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
{
    public function kanban()
    {
        $stages = ProductionStage::where('parent_id', parentId())
            ->orderBy('order_index')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'name' => $s->name,
                    'color_code' => $s->color_code,
                    'order_index' => $s->order_index,
                ];
            });

        $orders = Order::where('parent_id', parentId())
            ->whereNotNull('production_stage_id')
            ->with(['customers', 'clothTypes', 'productionStage'])
            ->orderBy('deadline_date')
            ->get()
            ->map(function ($o) {
                return [
                    'id' => $o->id,
                    'order_id' => $o->order_id,
                    'customer_name' => $o->customers->name ?? 'Unknown',
                    'cloth_title' => $o->clothTypes->title ?? 'Garment',
                    'deadline' => $o->deadline_date,
                    'status' => $o->status,
                    'production_stage_id' => $o->production_stage_id,
                ];
            });

        return response()->json([
            'success' => true,
            'stages' => $stages,
            'orders' => $orders,
        ]);
    }

    public function updateStage(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'stage_id' => 'required|integer',
        ]);

        $order = Order::where('parent_id', parentId())->findOrFail($request->order_id);
        $order->production_stage_id = $request->stage_id;
        $order->save();

        $stage = ProductionStage::find($request->stage_id);
        if ($stage) {
            WhatsAppWebhookController::dispatchStageNotification($order->id, $stage->name);
        }

        return response()->json(['success' => true, 'message' => 'Stage updated']);
    }

    public function assignments()
    {
        $user = Auth::user();
        $query = ProductionAssignment::where('parent_id', parentId())
            ->with(['order.customers', 'order.clothTypes', 'worker']);

        // If employee, only show their own assignments
        if ($user->type == 'employee') {
            $query->where('worker_id', $user->id);
        }

        $assignments = $query->orderBy('id', 'desc')->get()->map(function ($a) {
            return [
                'id' => $a->id,
                'order_id' => $a->order->order_id ?? '-',
                'customer_name' => $a->order->customers->name ?? 'Unknown',
                'tailor_name' => $a->worker->name ?? 'Unknown',
                'status' => $a->status,
                'piece_rate_pay' => $a->piece_rate_pay,
                'notes' => $a->notes,
            ];
        });

        return response()->json([
            'success' => true,
            'assignments' => $assignments,
        ]);
    }

    public function updateAssignmentStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,in_progress,completed']);

        $assignment = ProductionAssignment::where('parent_id', parentId())->findOrFail($id);
        $assignment->status = $request->status;
        $assignment->save();

        return response()->json(['success' => true, 'message' => 'Status updated']);
    }
}
