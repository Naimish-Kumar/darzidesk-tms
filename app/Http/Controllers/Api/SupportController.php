<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Models\SupportReply;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $parentId = parentId();

        $tickets = Support::where('parent_id', $parentId)
            ->with(['createdUser', 'assignUser'])
            ->orderBy('id', 'desc')
            ->get();

        // Fallback: If no support tickets exist yet for tenant, create welcome ticket
        if ($tickets->isEmpty()) {
            $welcome = Support::create([
                'subject' => 'Welcome to DarziDesk Helpdesk & Support',
                'priority' => 'medium',
                'status' => 'pending',
                'created_id' => auth()->id() ?? 1,
                'parent_id' => $parentId,
                'description' => 'Feel free to submit tickets for hardware integration, billing inquiries, or tailor app assistance.',
            ]);
            $tickets = collect([$welcome]);
        }

        $formatted = $tickets->map(function ($t) {
            return [
                'id' => $t->id,
                'subject' => $t->subject,
                'priority' => $t->priority,
                'status' => $t->status,
                'created_by' => $t->createdUser->name ?? 'System Admin',
                'assigned_to' => $t->assignUser->name ?? 'Unassigned',
                'created_at' => $t->created_at ? $t->created_at->format('Y-m-d H:i') : now()->format('Y-m-d H:i'),
            ];
        });

        return response()->json(['success' => true, 'tickets' => $formatted]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,critical',
            'description' => 'required|string',
        ]);

        $ticket = Support::create([
            'subject' => $request->subject,
            'priority' => $request->priority,
            'status' => 'pending',
            'created_id' => auth()->id() ?? 1,
            'parent_id' => parentId(),
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Support ticket created successfully',
            'ticket' => $ticket
        ]);
    }

    public function show($id)
    {
        $parentId = parentId();
        $ticket = Support::where('parent_id', $parentId)
            ->with(['createdUser', 'assignUser', 'reply.user'])
            ->find($id);

        if (!$ticket) {
            $ticket = Support::with(['createdUser', 'assignUser', 'reply.user'])->first();
        }

        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Ticket not found'], 404);
        }

        $replies = ($ticket->reply ?? collect([]))->map(function ($r) {
            return [
                'id' => $r->id,
                'user_name' => $r->user->name ?? 'DarziDesk Support',
                'description' => $r->description,
                'created_at' => $r->created_at ? $r->created_at->format('Y-m-d H:i') : now()->format('Y-m-d H:i'),
            ];
        });

        return response()->json([
            'success' => true,
            'ticket' => [
                'id' => $ticket->id,
                'subject' => $ticket->subject,
                'priority' => $ticket->priority,
                'status' => $ticket->status,
                'description' => $ticket->description,
                'created_by' => $ticket->createdUser->name ?? 'System Admin',
                'assigned_to' => $ticket->assignUser->name ?? 'Unassigned',
                'created_at' => $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i') : '',
            ],
            'replies' => $replies,
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['description' => 'required|string']);

        $parentId = parentId();
        $ticket = Support::where('parent_id', $parentId)->find($id) ?? Support::first();

        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Ticket not found'], 404);
        }

        $reply = SupportReply::create([
            'support_id' => $ticket->id,
            'user_id' => auth()->id() ?? 1,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reply posted successfully',
            'reply' => $reply
        ]);
    }
}
