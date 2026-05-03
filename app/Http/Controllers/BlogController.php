<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // Frontend Methods
    public function index()
    {
        $blogs = Blog::where('is_active', 1)->latest()->get();
        return view('blog.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        return view('blog.show', compact('blog'));
    }

    // Backend (Admin) Methods
    public function adminIndex()
    {
        if (\Auth::user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $blogs = Blog::latest()->get();
        return view('blog.admin.index', compact('blogs'));
    }

    public function create()
    {
        if (\Auth::user()->type != 'super admin') {
            return response()->json(['status' => 'error', 'messages' => __('Permission denied.')]);
        }
        return view('blog.admin.create');
    }

    public function store(Request $request)
    {
        if (\Auth::user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
        ]);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->short_description = $request->short_description;
        $blog->content = $request->content;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/blogs', $imageName);
            $blog->image = 'blogs/' . $imageName;
        }

        $blog->save();

        return redirect()->route('blog.admin.index')->with('success', __('Blog created successfully.'));
    }

    public function edit($id)
    {
        if (\Auth::user()->type != 'super admin') {
            return response()->json(['status' => 'error', 'messages' => __('Permission denied.')]);
        }
        $blog = Blog::findOrFail($id);
        return view('blog.admin.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->short_description = $request->short_description;
        $blog->content = $request->content;

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::delete('public/' . $blog->image);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/blogs', $imageName);
            $blog->image = 'blogs/' . $imageName;
        }

        $blog->save();

        return redirect()->route('blog.admin.index')->with('success', __('Blog updated successfully.'));
    }

    public function destroy($id)
    {
        if (\Auth::user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $blog = Blog::findOrFail($id);
        if ($blog->image) {
            Storage::delete('public/' . $blog->image);
        }
        $blog->delete();

        return redirect()->route('blog.admin.index')->with('success', __('Blog deleted successfully.'));
    }

    public function status(Request $request, $id)
    {
        if (\Auth::user()->type != 'super admin') {
            return response()->json(['success' => false, 'message' => __('Permission denied.')]);
        }
        $blog = Blog::findOrFail($id);
        $blog->is_active = $blog->is_active == 1 ? 0 : 1;
        $blog->save();

        return response()->json(['success' => true, 'message' => __('Status updated successfully.')]);
    }
}

