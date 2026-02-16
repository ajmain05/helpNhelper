<?php

namespace App\Http\Controllers\Admin\Faq;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();

        return view('v1.admin.pages.faq.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $faq = Faq::create($data);

        return redirect()->to('admin/faq')->with('success', 'Faq has been created.');
    }

    public function update(Request $request)
    {
        // return $request;
        $request->validate([
            'id' => ['required', 'exists:faqs,id'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        try {
            $faq = Faq::find($request->id);
            $faq->title = $request->title;
            $faq->description = $request->description;
            $faq->save();

            return redirect()->to('/admin/faq')->with('success', 'FAQ updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $faq = faq::find($request->id);
            $faq->delete();

            return new JsonResponse(['message' => 'FAQ Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
