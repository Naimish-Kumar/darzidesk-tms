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
        $tickets = Support::where('parent_id', parentId())
            ->with(['createdUser', 'assignUser'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'subject' => $t->subject,
                    'priority' => $t->priority,
                    'status' => $t->status,
                    'created_by' => $t->createdUser->name ?? 'System',
                    'assigned_to' => $t->assignUser->name ?? 'Unassigned',
                    'created_at' => $t->created_at ? $t->created_at->format('Y-m-d H:i') : '',
                ];
            });

        return response()->json(['success' => true, 'tickets' => $tickets]);
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
            'created_id' => auth()->id(),
            'parent_id' => parentId(),
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Support ticket created', 'ticket' => $ticket]);
    }

    public function show($id)
    {
        $ticket = Support::where('parent_id', parentId())
            ->with(['createdUser', 'assignUser', 'reply.user'])
            ->findOrFail($id);

        $replies = $ticket->reply->map(function ($r) {
            return [
                'id' => $r->id,
                'user_name' => $r->user->name ?? 'User',
                'description' => $r->description,
                'created_at' => $r->created_at ? $r->created_at->format('Y-m-d H:i') : '',
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
                'created_by' => $ticket->createdUser->name ?? 'System',
                'assigned_to' => $ticket->assignUser->name ?? 'Unassigned',
                'created_at' => $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i') : '',
            ],
            'replies' => $replies,
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['description' => 'required|string']);

        $ticket = Support::where('parent_id', parentId())->findOrFail($id);

        $reply = SupportReply::create([
            'support_id' => $ticket->id,
            'user_id' => auth()->id(),
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Reply posted', 'reply' => $reply]);
    }
}
