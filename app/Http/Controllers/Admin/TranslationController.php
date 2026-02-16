<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $languages = \App\Models\Language::all();
        $locale = $request->get('locale', 'en');
        
        $path = base_path("lang/{$locale}.json");
        
        if (!file_exists($path)) {
            // authentic try to create if implies en
            if ($locale === 'en') {
                file_put_contents($path, '{}');
            } else {
                // copy from en if exists
                if (file_exists(base_path('lang/en.json'))) {
                    copy(base_path('lang/en.json'), $path);
                } else {
                    file_put_contents($path, '{}');
                }
            }
        }

        $translations = json_decode(file_get_contents($path), true);
        
        // Ensure it is an array
        if (!is_array($translations)) {
            $translations = [];
        }

        return view('admin.pages.translation.index', compact('languages', 'locale', 'translations'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'locale' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);

        $locale = $request->locale;
        $key = $request->key;
        $value = $request->value;

        $path = base_path("lang/{$locale}.json");
        
        $translations = json_decode(file_get_contents($path), true);
        if (!is_array($translations)) {
            $translations = [];
        }

        $translations[$key] = $value;

        file_put_contents($path, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json(['success' => true]);
    }
}
