<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    public function index($type)
    {
        $content = Content::firstOrCreate(['type' => $type]);
        $pageTitle = ucfirst(str_replace('-', ' ', $type));

        return view('v1.admin.pages.contents.page_content', compact('content', 'type', 'pageTitle'));
    }

    public function update(Request $request, $type)
    {
        $request->validate([
            'description' => ['required', 'string'],
        ]);

        $content = Content::firstOrCreate(['type' => $type]);
        $content->description = $request->description;
        $content->save();

        return back()->with('success', ucfirst(str_replace('-', ' ', $type)) . ' updated successfully.');
    }
}
