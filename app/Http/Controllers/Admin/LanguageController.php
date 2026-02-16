<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = \App\Models\Language::all();
        return view('admin.pages.language.index', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:languages',
            'icon' => 'nullable',
        ]);

        \App\Models\Language::create($request->all());

        return redirect()->back()->with('success', 'Language added successfully');
    }

    public function update(Request $request, $id)
    {
        $language = \App\Models\Language::findOrFail($id);
        $language->update($request->all());

        return redirect()->back()->with('success', 'Language updated successfully');
    }

    public function destroy($id)
    {
        $language = \App\Models\Language::findOrFail($id);
        $language->delete();

        return redirect()->back()->with('success', 'Language deleted successfully');
    }

    public function changeStatus($id)
    {
        $language = \App\Models\Language::findOrFail($id);
        $language->status = !$language->status;
        $language->save();

        return redirect()->back()->with('success', 'Status changed successfully');
    }
}
