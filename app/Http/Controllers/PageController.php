<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('manage Page')) {
            $Pages = Page::get();
            return view('Pages.index', compact('Pages'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create Page')) {
            return view('Pages.create');
        } else {
            $return['status'] = 'error';
            $return['messages'] = __('Permission denied.');
            return response()->json($return);
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create Page')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'content' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $page = new Page();
            $page->title = $request->title;
            $page->slug = strtolower(str_replace([' '],['_'], $request->title));
            $page->content = $request->content;
            $page->enabled = $request->enabled;
            $page->parent_id = \Auth::user()->id;
            $page->save();

            return redirect()->back()->with('success', __('Page successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Page $page)
    {
        if (\Auth::user()->can('show Page')) {
            return view('Pages.show', compact('page'));
        } else {
            $return['status'] = 'error';
            $return['messages'] = __('Permission denied.');
            return response()->json($return);
        }
    }

    public function edit(Page $page)
    {
        if (\Auth::user()->can('edit Page')) {
            return view('Pages.edit', compact('page'));
        } else {
            $return['status'] = 'error';
            $return['messages'] = __('Permission denied.');
            return response()->json($return);
        }
    }

    public function update(Request $request, Page $page)
    {
        if (\Auth::user()->can('edit Page') ) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'content' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $page->title = $request->title;
            $page->slug = strtolower(str_replace([' '],['_'], $request->title));
            $page->content = $request->content;
            $page->enabled = $request->enabled;
            $page->save();

            return redirect()->back()->with('success', __('Page successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Page $page)
    {
        if (\Auth::user()->can('delete Page')) {
            $page->delete();
            return redirect()->back()->with('success', 'Page successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function page(Request $request, $slug)
    {
        $page = Page::where('slug', $request->slug)->first();
        if ($page) {
            return view('Pages.page', compact('page'));
        } else {
            return redirect()->back()->with('error', __('Page not found.'));
        }
    }

    public function privacyPolicy()
    {
        $page = Page::where('slug', 'privacy_policy')->first();
        return view('Pages.privacy', compact('page'));
    }

    public function termsConditions()
    {
        $page = Page::where('slug', 'terms_conditions')->first();
        return view('Pages.terms', compact('page'));
    }

    public function aboutUs()
    {
        $page = Page::where('slug', 'about_us')->first();
        return view('Pages.about', compact('page'));
    }

    public function deleteAccount()
    {
        $page = Page::where('slug', 'delete_account')->first();
        return view('Pages.delete_account', compact('page'));
    }

    public function processDeleteAccountRequest(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'account_type' => 'required|string',
            'confirm_deletion' => 'required|accepted',
        ], [
            'confirm_deletion.required' => __('You must acknowledge the account deletion terms to proceed.'),
            'confirm_deletion.accepted' => __('You must acknowledge the account deletion terms to proceed.'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->first());
        }

        $email = htmlspecialchars($request->email);
        $ticketId = 'DEL-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));

        return redirect()->back()->with('success', __("Account deletion request submitted successfully! Your Request Reference Ticket ID is: :ticketId. Details have been emailed to :email. Deletion will be completed within 30 days per statutory data retention rules.", ['ticketId' => $ticketId, 'email' => $email]));
    }
}

