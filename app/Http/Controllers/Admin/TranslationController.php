<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    private function getLangPath(string $locale): string
    {
        return base_path("lang/{$locale}.json");
    }

    private function readTranslations(string $path): array
    {
        if (!file_exists($path)) {
            return [];
        }
        $decoded = json_decode(file_get_contents($path), true);
        return is_array($decoded) ? $decoded : [];
    }

    private function writeTranslations(string $path, array $translations): bool
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $result = file_put_contents(
            $path,
            json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return $result !== false;
    }

    public function index(Request $request)
    {
        $languages = \App\Models\Language::all();
        $locale = $request->get('locale', 'en');

        $path = $this->getLangPath($locale);

        if (!file_exists($path)) {
            // Try to copy English keys as template
            $enPath = $this->getLangPath('en');
            if (file_exists($enPath)) {
                copy($enPath, $path);
            } else {
                $this->writeTranslations($path, []);
            }
        }

        $translations = $this->readTranslations($path);

        return view('admin.pages.translation.index', compact('languages', 'locale', 'translations'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'locale' => 'required',
            'key'    => 'required',
            'value'  => 'required',
        ]);

        $locale = $request->locale;
        $key    = $request->key;
        $value  = $request->value;

        $path = $this->getLangPath($locale);
        $translations = $this->readTranslations($path);
        $translations[$key] = $value;

        if (!$this->writeTranslations($path, $translations)) {
            return response()->json([
                'success' => false,
                'message' => 'Could not write to file. Check server file permissions for the lang/ directory.',
            ], 500);
        }

        return response()->json(['success' => true, 'message' => 'Translation saved.']);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'locale' => 'required',
            'key'    => 'required',
        ]);

        $locale = $request->locale;
        $key    = $request->key;

        $path = $this->getLangPath($locale);
        $translations = $this->readTranslations($path);

        if (!array_key_exists($key, $translations)) {
            return response()->json(['success' => false, 'message' => 'Key not found.'], 404);
        }

        unset($translations[$key]);

        if (!$this->writeTranslations($path, $translations)) {
            return response()->json([
                'success' => false,
                'message' => 'Could not write to file. Check server file permissions for the lang/ directory.',
            ], 500);
        }

        return response()->json(['success' => true, 'message' => 'Translation key deleted.']);
    }
}
