<?php

namespace App\Http\Controllers\Admin\Campaign;

use App\Enums\Campaign\CampaignFile;
use App\Enums\Campaign\Status;
use App\Enums\Seeker\SeekerApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccount;
use App\Models\Campaign\Campaign;
use App\Models\Campaign\CampaignCategory;
use App\Models\Invoice\Invoice;
use App\Models\Seeker\SeekerApplication;
use App\Models\Transaction\Transaction;
use App\Models\CorporateAllocation;
use App\Notifications\CampaignSuccessNotification;
use App\Traits\HasFiles;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CampaignController extends Controller
{
    use HasFiles;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('v1.admin.pages.campaigns.index');
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getCampaignsDatatableAjax(Request $request)
    {
        // $campaigns = Campaign::with(['seeker_application', 'category.parent_category'])
        //     ->orWhereHas('seeker_application', function ($query) use ($request) {
        //         $query->orWhere('title', 'like', '%'.$request->search['value'].'%');
        //     })
        //     ->orWhereHas('category', function ($query) use ($request) {
        //         $query->orWhere('title', 'like', '%'.$request->search['value'].'%');
        //     })
        //     ->orWhere('title', 'like', '%'.$request->search['value'].'%')
        //     ->orWhere('amount', 'like', '%'.$request->search['value'].'%')
        //     ->latest();

        $campaigns = Campaign::with(['seeker_application', 'category.parent_category'])
            ->when($request->search['value'] != null, function ($query) use ($request) {
                $query->where('sid', 'like', '%'.$request->search['value'].'%')
                    ->orWhereHas('seeker_application', function ($query) use ($request) {
                        $query->where('title', 'like', '%'.$request->search['value'].'%');
                    })
                    ->orWhereHas('category.parent_category', function ($query) use ($request) {
                        $query->where('title', 'like', '%'.$request->search['value'].'%');
                    })
                    ->orWhere('sid', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('amount', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
            })->latest();

        return Datatables::of($campaigns)
            ->editColumn('seeker_application.title', function ($campaign) {
                return $campaign->seeker_application->getTranslation('title') ?? 'N/A';
            })
            ->editColumn('category.title', function ($campaign) {
                return $campaign->category->parent_category ? $campaign->category->parent_category->getTranslation('title').' > '.$campaign->category->getTranslation('title') : $campaign->category->getTranslation('title');
            })
            ->editColumn('title', function ($campaign) {
                return $campaign->getTranslation('title') ?? 'N/A';
            })
            ->editColumn('amount', function ($campaign) {
                return $campaign->getTranslation('amount');
            })
            ->editColumn('created_at', function ($campaign) {
                return $campaign->created_at ?? 'N/A';
            })
            ->editColumn('photo', function ($campaign) {
                return $campaign->photo ? '<img src="'.asset($campaign->photo).'" alt="Profile Image">' : 'N/A';
            })
            ->addColumn('action', function ($campaign) {
                $markup = '';
                $markup .= '<a href="'.route('admin.campaign.edit', [$campaign->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="'.route('admin.campaign.show', [$campaign->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="#" onclick="deleteCampaign('.$campaign->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->rawColumns(['action', 'seeker_application.title', 'category.title', 'photo', 'created_at'])
            ->setFilteredRecords($campaigns->count())
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $applications = SeekerApplication::where('status', SeekerApplicationStatus::APPROVED->value)->get();
        $campaignCategories = CampaignCategory::with('parent_category')->get();
        $categories = [];
        foreach ($campaignCategories as $category) {
            $newCategory = new \stdClass();
            $newCategory->id = $category->id;
            $newCategory->title = $category->parent_category ? $category->parent_category->title.' > '.$category->title : $category->title;
            $categories[] = $newCategory;
        }
        $statuses = Status::array();

        return view('v1.admin.pages.campaigns.create', compact('applications', 'categories', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'short_description' => ['required', 'string'],
            'long_description' => ['required', 'string'],
            'category_id' => ['required', 'exists:campaign_categories,id'],
            'seeker_application_id' => ['required', 'exists:seeker_applications,id'],
            'amount' => ['required', 'numeric'],
            'photos' => ['required', 'array'],
            'photos.*' => ['file', 'mimes:jpeg,png,jpg'],
            'status' => ['required', Rule::in(Status::values())],
        ]);
        // return $request;
        DB::beginTransaction();
        try {
            // if ($request->file('photo')) {
            //     $photoPath = $this->storeFile('campaigns', $request->file('photo'), 'campaign');
            // }
            $campaign = new Campaign();
            $campaign->title = $request->title;
            $campaign->short_description = $request->short_description;
            $campaign->long_description = $request->long_description;
            $campaign->category_id = $request->category_id;
            $campaign->seeker_application_id = $request->seeker_application_id;
            $campaign->amount = $request->amount;
            $campaign->amount_bn = $request->amount_bn;
            $campaign->amount_ar = $request->amount_ar;
            $campaign->terms = $request->terms;
            $campaign->is_featured = $request->is_featured;
            $campaign->status = $request->status;
            $campaign->title_bn = $request->title_bn;
            $campaign->title_ar = $request->title_ar;
            $campaign->short_description_bn = $request->short_description_bn;
            $campaign->short_description_ar = $request->short_description_ar;
            $campaign->long_description_bn = $request->long_description_bn;
            $campaign->long_description_ar = $request->long_description_ar;
            $campaign->terms_bn = $request->terms_bn;
            $campaign->terms_ar = $request->terms_ar;
            $campaign->save();
            if (isset($request->photos)) {
                foreach ($request->photos as $index => $photo) {
                    $photoPath = $this->storeFile('campaigns', $photo, 'campaign');
                    $campaign->images()->create([
                        'image' => $photoPath,
                    ]);
                    if ($index == 0) {
                        $photoPath = $this->storeFile('campaigns', $photo, 'campaign');
                        $campaign->photo = $photoPath;
                        $campaign->save();
                    }
                }
            }
            // foreach ($request->file('images') as $image) {
            //     $campaign->addMedia($image)->toMediaCollection(CampaignFile::IMAGES->value);
            // }
            DB::commit();

            return redirect()->to('/admin/campaigns')->with('success', 'Campaign created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $campaign = Campaign::with([
            'media',
            'images',
            'seeker_application',
            'category',
            'invoices',
            'invoices.transaction',
            'invoices.statusInfo',
            'invoices.transaction.transactionCategory',
            'invoices.transaction.donorInfo',
            'invoices.transaction.volunteerInfo',
        ])->find($id);

        $campaign_info = Campaign::withSum('donations as total_raised', 'amount')
            ->withCount('donors as total_donors')->findOrFail($id);

        $totalDonation = Transaction::where('campaign_id', $id)->where('type', 'income')->sum('amount');

        // $invoices = Invoice::with([
        //     'transaction',
        //     'statusInfo',
        //     'transaction.transactionCategory',
        //     'transaction.donorInfo',
        //     'transaction.volunteerInfo'
        //     ])
        //     ->where('campaign_id', $campaign->id)
        //     ->latest()->get();
        // return $campaign;

        return view('v1.admin.pages.campaigns.show', compact('campaign', 'campaign_info', 'totalDonation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $applications = SeekerApplication::where('status', SeekerApplicationStatus::APPROVED->value)->get();
        $campaignCategories = CampaignCategory::all();
        $categories = [];
        foreach ($campaignCategories as $category) {
            $newCategory = new \stdClass();
            $newCategory->id = $category->id;
            $newCategory->title = $category->parent_category ? $category->parent_category->title.' > '.$category->title : $category->title;
            $categories[] = $newCategory;
        }
        $campaign = Campaign::with(['images' => function ($query) {
            $query->latest();
        }, 'media', 'seeker_application', 'category'])->find($id);
        $statuses = Status::array();

        return view('v1.admin.pages.campaigns.edit', compact('campaign', 'applications', 'categories', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'title' => ['required', 'string'],
            'short_description' => ['required', 'string'],
            'long_description' => ['required', 'string'],
            'category_id' => ['required', 'exists:campaign_categories,id'],
            'seeker_application_id' => ['required', 'exists:seeker_applications,id'],
            'amount' => ['required', 'numeric'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'file', 'mimes:jpeg,png,jpg'],
            'status' => ['required', Rule::in(Status::values())],
        ]);
        DB::beginTransaction();
        try {
            $campaign = Campaign::with([
                'invoices',
                'invoices.transaction',
            ])
                ->find($request->id);
            $campaign->title = $request->title;
            $campaign->short_description = $request->short_description;
            $campaign->long_description = $request->long_description;
            $campaign->category_id = $request->category_id;
            $campaign->seeker_application_id = $request->seeker_application_id;
            $campaign->amount = $request->amount;
            $campaign->amount_bn = $request->amount_bn;
            $campaign->amount_ar = $request->amount_ar;
            $campaign->terms = $request->terms;
            $campaign->is_featured = $request->is_featured;
            $campaign->title_bn = $request->title_bn;
            $campaign->title_ar = $request->title_ar;
            $campaign->short_description_bn = $request->short_description_bn;
            $campaign->short_description_ar = $request->short_description_ar;
            $campaign->long_description_bn = $request->long_description_bn;
            $campaign->long_description_ar = $request->long_description_ar;
            $campaign->terms_bn = $request->terms_bn;
            $campaign->terms_ar = $request->terms_ar;
            if (isset($request->photo)) {
                $thumbnail = $this->storeFile('campaigns', $request->photo, 'thumbnail');
                $campaign->photo = $thumbnail;
            }
            if (isset($request->images)) {
                foreach ($request->images as $index => $image) {
                    $photoPath = $this->storeFile('campaigns', $image, 'campaign');
                    $campaign->images()->create([
                        'image' => $photoPath,
                    ]);
                    // if ($index == 0) {
                    //     $photoPath = $this->storeFile('campaigns', $image, 'campaign');
                    //     $campaign->photo = $photoPath;
                    // }
                }
            }

            $campaign->status = $request->status;

            if ($campaign->status == Status::Finished->value) {
                $invoices = $campaign->invoices;
                $totalIncome = 0;
                foreach ($invoices as $invoice) {
                    if ($invoice->transaction->type == 'income') {
                        $totalIncome += $invoice->transaction->amount;
                    }
                }
                $cutAmount = ($totalIncome * 7.5) / 100;
                $paymentDateTime = Carbon::now();

                $invoice = Invoice::create([
                    'campaign_id' => $campaign->id,
                    'status' => 1,
                    'date' => $paymentDateTime ?? null,
                    'created_by' => Auth::id(),
                ]);

                $transaction = Transaction::create([
                    'receiver_type' => 'donor',
                    'date' => $paymentDateTime,
                    'amount' => $cutAmount,
                    'remarks' => null,
                    'status' => 1,
                    'type' => 'income',
                    'sub_type' => 'digital',
                    'campaign_id' => $campaign->id,
                    'transaction_category_id' => null,
                    'transaction_mode_id' => null,
                    'bank_id' => 1,
                    'bank_account_id' => 1,
                    'invoice_id' => $invoice->id ?? null,
                    'donor_id' => Auth::user()->id ?? null,
                    'name' => null,
                    'mobile' => null,
                    'volunteer_id' => null,
                    'created_by' => Auth::id() ?? null,
                ]);

                $bankAccount = BankAccount::findOrFail(1);
                $bankAccount->current_balance = $bankAccount->current_balance + $cutAmount;
                $bankAccount->save();

                $invoice = Invoice::create([
                    'campaign_id' => $campaign->id,
                    'status' => 1,
                    'date' => $paymentDateTime ?? null,
                    'created_by' => Auth::id(),
                ]);

                $transaction = Transaction::create([
                    'receiver_type' => 'donor',
                    'date' => $paymentDateTime,
                    'amount' => $cutAmount,
                    'remarks' => null,
                    'status' => 1,
                    'type' => 'expense',
                    'sub_type' => 'campaign',
                    'campaign_id' => $campaign->id,
                    'transaction_category_id' => null,
                    'transaction_mode_id' => null,
                    'bank_id' => 1,
                    'bank_account_id' => 1,
                    'invoice_id' => $invoice->id ?? null,
                    'donor_id' => null,
                    'name' => null,
                    'mobile' => null,
                    'volunteer_id' => null,
                    'created_by' => Auth::id() ?? null,
                ]);

                $bankAccount = BankAccount::findOrFail(2);
                $bankAccount->current_balance = $bankAccount->current_balance - $cutAmount;
                $bankAccount->save();

                // Notify Corporate Donors who allocated funds to this campaign
                $corporateAllocations = CorporateAllocation::with('user')
                                            ->where('campaign_id', $campaign->id)
                                            ->get()
                                            ->groupBy('user_id');
                
                foreach ($corporateAllocations as $userId => $allocations) {
                    $totalAllocatedAmount = $allocations->sum('amount');
                    $user = $allocations->first()->user;
                    
                    if ($user) {
                        $user->notify(new CampaignSuccessNotification($campaign->title, $totalAllocatedAmount));
                    }
                }
            }
            $campaign->save();
            // if ($request->hasFile('images')) {
            //     foreach ($request->file('images') as $image) {
            //         $campaign->addMedia($image)->toMediaCollection(CampaignFile::IMAGES->value);
            //     }
            // }

            DB::commit();

            return back()->withInput()->with('success', 'Campaign updated successfully');

        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $campaign = Campaign::find($request->id);
            $campaign->delete();
            DB::commit();

            return new JsonResponse(['message' => 'Campaign Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteImage(int $id)
    {
        try {
            $image = CampaignImage::find($id);
            $this->removeFile($image->image);
            $image->delete();

            return redirect()->back()->with('success', 'Campaign gallery image deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
