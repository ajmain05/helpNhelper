<?php

namespace App\Http\Controllers\Admin\Bank;

use App\Http\Controllers\Controller;
use App\Models\Bank\Bank;
use App\Traits\HasFiles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class BankController extends Controller
{
    use HasFiles;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('v1.admin.pages.bank.index');
    }

    public function getbankDatatableAjax(Request $request)
    {
        $bank = Bank::where('name', 'like', '%'.$request->search['value'].'%')
            ->latest()->get();

        return Datatables::of($bank)
            ->editColumn('name', function ($bank) {
                return $bank?->name;
            })
            ->editColumn('logo', function ($bank) {
                return $bank?->logo == null ? 'N/A' : '<img src='.asset($bank?->logo).' alt="Bank Logo">';
            })
            ->addColumn('action', function ($bank) {
                $markup = '';
                // $markup .= '<a href="'.route('admin.bank.show', [$campaign->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="'.route('admin.bank.edit', [$bank->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteBank('.$bank->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->rawColumns(['action', 'name', 'logo'])
            ->setFilteredRecords($bank->count())
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('v1.admin.pages.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'logo' => ['nullable', 'file', 'max:2048'],
        ]);
        try {
            if ($request->file('logo')) {
                $photoPath = $this->storeFile('bank', $request->file('logo'), 'bank-name');
            }
            $bank = Bank::create([
                'name' => $request->name,
                'logo' => $photoPath ?? null,
            ]);

            return redirect()->to('/admin/bank')->with('success', 'Bank created successfully.');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bank = Bank::find($id);

        return view('v1.admin.pages.bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:banks,id'],
            'name' => ['required', 'string'],
            'logo' => ['nullable', 'file', 'max:2048'],
        ]);
        try {
            $bank = Bank::findOrFail($request->id);
            $bank->name = $request->name;
            if ($request->file('logo')) {
                $photoPath = $this->storeFile('bank', $request->file('logo'), 'bank-name');
                $bank->logo = $photoPath;
            }
            $bank->save();

            return redirect()->to('/admin/bank')->with('success', 'Bank updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $bank = Bank::findOrFail($request->id);
            $bank->delete();

            return new JsonResponse(['message' => 'Bank Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
