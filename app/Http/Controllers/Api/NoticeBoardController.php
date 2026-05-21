<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NoticeBoard;
use Illuminate\Http\Request;

class NoticeBoardController extends Controller
{
    public function index()
    {
        $notes = NoticeBoard::where('parent_id', parentId())->orderBy('id', 'desc')->get();
        return response()->json(['success' => true, 'data' => $notes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $note = new NoticeBoard();
        $note->title = $request->title;
        $note->description = $request->description;
        $note->parent_id = parentId();
        
        // Handling file upload if needed (ignoring for simplified API unless passed as multipart)
        if ($request->hasFile('attachment')) {
            $noteFilenameWithExt = $request->file('attachment')->getClientOriginalName();
            $noteFilename = pathinfo($noteFilenameWithExt, PATHINFO_FILENAME);
            $noteExtension = $request->file('attachment')->getClientOriginalExtension();
            $noteFileName = $noteFilename . '_' . time() . '.' . $noteExtension;
            $request->file('attachment')->storeAs('upload/applicant/attachment/', $noteFileName);
            $note->attachment = $noteFileName;
        }

        $note->save();

        return response()->json([
            'success' => true,
            'message' => 'Note created successfully',
            'data' => $note
        ]);
    }

    public function update(Request $request, $id)
    {
        $note = NoticeBoard::where('id', $id)->where('parent_id', parentId())->first();
        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Note not found'], 404);
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $note->title = $request->title;
        $note->description = $request->description;

        if ($request->hasFile('attachment')) {
            $directory = storage_path('upload/applicant/attachment');
            if (!empty($note->attachment) && file_exists($directory . '/' . $note->attachment)) {
                unlink($directory . '/' . $note->attachment);
            }

            $noteFilenameWithExt = $request->file('attachment')->getClientOriginalName();
            $noteFilename = pathinfo($noteFilenameWithExt, PATHINFO_FILENAME);
            $noteExtension = $request->file('attachment')->getClientOriginalExtension();
            $noteFileName = $noteFilename . '_' . time() . '.' . $noteExtension;
            $request->file('attachment')->storeAs('upload/applicant/attachment/', $noteFileName);
            $note->attachment = $noteFileName;
        }

        $note->save();

        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully',
            'data' => $note
        ]);
    }

    public function destroy($id)
    {
        $note = NoticeBoard::where('id', $id)->where('parent_id', parentId())->first();
        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Note not found'], 404);
        }

        $directory = storage_path('upload/applicant/attachment');
        if ($note->attachment && file_exists($directory . '/' . $note->attachment)) {
            unlink($directory . '/' . $note->attachment);
        }
        
        $note->delete();

        return response()->json(['success' => true, 'message' => 'Note deleted successfully']);
    }
}
