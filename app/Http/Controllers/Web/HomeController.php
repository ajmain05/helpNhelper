<?php

namespace App\Http\Controllers\Web;

use App\Enums\Content\ContentType;
use App\Enums\GlobalStatus;
use App\Enums\Seeker\SeekerApplicationCategory;
use App\Enums\User\Type;
use App\Http\Controllers\Controller;
use App\Models\About\MeetOurTeam;
use App\Models\Bank\BankAccount;
use App\Models\Campaign\Campaign;
use App\Models\Campaign\CampaignCategory;
use App\Models\Content;
use App\Models\District;
use App\Models\Division;
use App\Models\Donation;
use App\Models\Faq;
use App\Models\Invoice\Invoice;
use App\Models\Organization\OrganizationApplication;
use App\Models\Seeker\SeekerApplication;
use App\Models\Seeker\SeekerApplicationVolunteer;
use App\Models\SuccessStory;
use App\Models\Transaction\Transaction;
use App\Models\Upazila;
use App\Models\User;
use App\Models\User\UserBank;
use App\Rules\SameOrUniqueEmail;
use App\Rules\SameOrUniqueMobile;
use App\Traits\HasDivisionsAndDistricts;
use App\Traits\HasFiles;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    use HasDivisionsAndDistricts,HasFiles;

    public function index()
    {

        $campaigns = Campaign::with(['images'])->withSum('donations as total_raised', 'amount')->orderBy('created_at', 'desc')->take(3)->get()->map(function ($campaign) {
            $campaign->total_donation = Transaction::where('campaign_id', $campaign->id)
                ->where('type', 'income')
                ->sum('amount');

            return $campaign;
        });
        // $campaignCategory = CampaignCategory::orderBy('title', 'asc')->get();
        // $featuredCampaign = Campaign::where('is_featured', '1')->latest()->get()->map(function ($campaign) {
        //     $campaign->total_donation = Transaction::where('campaign_id', $campaign->id)
        //         ->where('type', 'income')
        //         ->sum('amount');

        //     return $campaign;
        // });
        // $categoryWiseCampaign = Campaign::withSum('donations as total_raised', 'amount')
        //     ->withCount('donors as total_donors')
        //     ->where('category_id', $campaignCategory[0]?->id ?? null)
        //     ->latest()->get()->map(function ($campaign) {
        //         $campaign->total_donation = Transaction::where('campaign_id', $campaign->id)
        //             ->where('type', 'income')
        //             ->sum('amount');

        //         return $campaign;
        //     });
        // $successStories = SuccessStory::latest()->get();

        // $volunteerNumber = User::where('type', 'volunteer')
        //     ->where('status', 'approved')
        //     ->count();

        $heroSectionContents = Content::whereIn('type',
            [
                ContentType::HomeHero->value,
                ContentType::HomeHeroFooterOne->value,
                ContentType::HomeHeroFooterTwo->value,
                ContentType::HomeHeroFooterThree->value,
                ContentType::HomeHeroFooterFour->value,
            ]
        )->get()->keyBy('type');

        $faqs = Faq::latest()->get();

        // return view('v1.web.pages.home',
        //     compact(['campaigns', 'campaignCategory', 'featuredCampaign', 'categoryWiseCampaign', 'successStories', 'heroSection', 'volunteerNumber']),
        //     $this->getCountriesDivisionsDistrictsUpazilas());
        // return $campaigns;

        return view('v2.web.pages.index',
            compact(['campaigns', 'heroSectionContents', 'faqs'])
        );
    }

    public function currentCampaigns(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $category = $request->query('category', null);
        $perPage = $request->query('per_page', 9);
        $search = $request->query('search');

        $category = $category == 'all' ? null : $category;
        $campaigns = Campaign::when($search, function ($q) use ($search) {
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('short_description', 'LIKE', "%{$search}%");
            });
        })->when($category !== null, function ($q) use ($category) {
            $q->where('category_id', $category);
        })->withSum('donations as total_raised', 'amount')
            ->withCount('donations as total_donors')->orderBy('created_at', $sort)->paginate($perPage);

        $transactions = Transaction::select('campaign_id', DB::raw('SUM(amount) as total_donation'))->where('type', 'income')->groupBy('campaign_id')->get();

        foreach ($campaigns as $campaign) {
            $campaign->total_donation = $transactions->where('campaign_id', $campaign->id)->first()->total_donation ?? 0;
        }

        $campaignCategory = CampaignCategory::orderBy('title', 'asc')->get();

        session()->flashInput($request->input());

        return view('v2.web.pages.current-campaigns', compact(['campaigns', 'campaignCategory']), $this->getCountriesDivisionsDistrictsUpazilas());
    }

    public function campaign($id)
    {
        $campaign = Campaign::with(['images' => function ($query) {
            $query->latest();
        }])->findOrFail($id);
        $data = Transaction::where('campaign_id', $campaign->id)
            ->selectRaw('COUNT(*) as total_count, SUM(amount) as total_donation')
            ->first();
        $campaign->total_donation = $data->total_donation ?? 0;
        $campaign->total_donors = $data->total_count ?? 0;
        $setCampaign = true;
        $campaigns = Campaign::take(5)->latest()->get();

        $transactions = Transaction::select('campaign_id', DB::raw('SUM(amount) as total_donation'))->where('type', 'income')->groupBy('campaign_id')->get();
        foreach ($campaigns as $singleCampaign) {
            $singleCampaign->total_donation = $transactions->where('campaign_id', $singleCampaign->id)->first()->total_donation ?? 0;
        }

        // return view('v1.web.pages.campaign-details', compact('setCampaign', 'campaign', 'totalDonation'), $this->getCountriesDivisionsDistrictsUpazilas());
        return view('v2.web.pages.campaign', compact('setCampaign', 'campaign', 'campaigns'), $this->getCountriesDivisionsDistrictsUpazilas());
    }

    public function donation($campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);

        // return view('v1.web.pages.donation', compact(['campaign']), $this->getCountriesDivisionsDistrictsUpazilas());
        return view('v2.web.pages.donation', compact('campaign'));
    }

    public function donationStore(Request $request)
    {
        $request->validate([
            'campaign_id' => ['required'],
            'phone' => ['nullable', 'numeric'],
            'amount' => ['required', 'numeric'],
        ]);
        try {
            DB::beginTransaction();
            $donation = new Donation();
            $donation->campaign_id = $request->campaign_id;
            $donation->phone = $request->phone;
            $donation->amount = $request->amount;
            $donation->user_id = Auth::user()->id ?? null;

            $paymentDateTime = Carbon::now();

            $invoice = Invoice::create([
                'campaign_id' => $request->campaign_id ?? null,
                'status' => 'Credited',
                'date' => $paymentDateTime ?? null,
                'created_by' => Auth::id(),
            ]);

            $transaction = Transaction::create([
                'receiver_type' => $request->options == 'account' ? 'donor' : 'anonymous',
                'date' => $paymentDateTime,
                'amount' => $request->amount,
                'remarks' => null,
                'status' => 'Credited',
                'type' => 'income',
                'sub_type' => 'digital',
                'campaign_id' => $request->campaign_id ?? null,
                'transaction_category_id' => null,
                'transaction_mode_id' => null,
                'bank_id' => 1,
                'bank_account_id' => 1,
                'invoice_id' => $invoice->id ?? null,
                'donor_id' => Auth::user()->id ?? null,
                'name' => null,
                'mobile' => null,
                'volunteer_id' => null,
                'created_by' => Auth::id(),
            ]);

            $bankAccount = BankAccount::findOrFail(1);
            $bankAccount->current_balance = $bankAccount->current_balance + $request->amount;
            $bankAccount->save();

            $donation->save();
            DB::commit();

            return redirect()->to('/campaign/'.$request->campaign_id)->with('success', 'Thanks for your donation.');

        } catch (\Throwable $th) {

            return new JsonResponse(
                [
                    'message' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function about()
    {
        $about = Content::where('type', 'about')->first();
        $teams = MeetOurTeam::where('type', 'team')->oldest('sequence')->get();
        $shariah = MeetOurTeam::where('type', 'shariah')->oldest('sequence')->get();

        // return view('v1.web.pages.about', compact('about'), $this->getCountriesDivisionsDistrictsUpazilas());
        return view('v2.web.pages.about-us', compact('about', 'teams', 'shariah'), $this->getCountriesDivisionsDistrictsUpazilas());
    }

    public function faq()
    {
        $faqs = Faq::latest()->get();

        return view('v1.web.pages.faq', compact('faqs'), $this->getCountriesDivisionsDistrictsUpazilas());
    }

    public function successStories()
    {
        $successStories = SuccessStory::latest()->get();

        return view('v1.web.pages.success-stories', compact('successStories'), $this->getCountriesDivisionsDistrictsUpazilas());
    }

    public function profile()
    {
        $userBanks = UserBank::where('user_id', auth()->user()->id)->latest()->get();

        return view('v1.web.pages.profile', $this->getCountriesDivisionsDistrictsUpazilas(), compact('userBanks'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', Rule::in([Type::Donor->value, Type::Volunteer->value, Type::Seeker->value, Type::Organization->value])],
            'name' => ['required', 'string'],
            'email' => ['required_without:mobile', 'email', 'nullable', new SameOrUniqueEmail(Auth::user()->id)],
            'mobile' => ['required_without:email', 'string', 'nullable', new SameOrUniqueMobile(Auth::user()->id)],
            'auth_file' => ['file', 'mimetypes:image/jpeg,image/png,application/pdf', 'nullable'],
            'upazila' => ['required_if:type,seeker,volunteer'],
            'permanent_address' => ['required_if:type,seeker,volunteer', 'string', 'nullable'],
            'present_address' => ['required_if:type,seeker,volunteer', 'string', 'nullable'],
            'photo' => ['file', 'mimes:jpeg,png,jpg', 'nullable'],
            'password' => ['nullable', 'min:8'],
        ]);

        try {
            $userRequest = User::findOrFail(Auth::user()->id);
            $userRequest->name = $request->name;
            $userRequest->email = $request->email ?? null;
            $userRequest->mobile = $request->mobile ?? null;
            if ($request->upazila != null) {
                $userRequest->upazila_id = $request->upazila ?? null;
            }
            $userRequest->permanent_address = $request->permanent_address ?? null;
            $userRequest->present_address = $request->present_address ?? null;

            if ($request->password != null) {
                $userRequest->password = Hash::make($request->password);
            }
            if ($request->file('photo')) {
                $photoPath = $this->storeFile('user', $request->file('photo'), 'photo');
                $userRequest->photo = $photoPath ?? null;
            }
            if ($request->file('auth_file')) {
                $authPath = $this->storeFile('user', $request->file('auth_file'), 'auth');
                $userRequest->auth_file = $authPath ?? null;
            }
            $userRequest->save();

            return redirect()->back()->with('success', 'Profile updated successfully!');

        } catch (\Throwable $th) {
            return new JsonResponse(
                [
                    'message' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function acceptTransaction(Request $request, $transactionId)
    {
        $request->validate([
            'receive_status' => ['required', 'string', Rule::in(['accepted', 'declined'])],
        ]);

        $transaction = Transaction::findOrFail($transactionId);

        if ($transaction->volunteer_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'You are not authorized to accept or decline this transaction.');
        }
        $transaction->update([
            'receive_status' => $request->receive_status,
        ]);

        return redirect()->back()->with('success', "Transaction {$request->receive_status} successfully.");
    }

    public function history()
    {
        $history = new Collection();
        $transactions = new Collection();
        if (Auth::user()?->type == Type::Seeker->value) {
            $history = SeekerApplication::with('user')
                ->where('user_id', Auth::user()->id)->latest()->get();
        } elseif (Auth::user()?->type == Type::Volunteer->value) {
            $history = SeekerApplicationVolunteer::with(['application', 'user'])
                ->where('user_id', Auth::user()->id)
                ->latest()->get();
            $transactions = Transaction::with([
                'bankInfo',
                'bankAccountInfo',
                'transactionCategory',
                'transactionMode',
                'userBank',
                'campaignInfo',
            ])->where('volunteer_id', Auth::user()->id)->latest()->get();
        } elseif (Auth::user()?->type == Type::Donor->value) {
            $history = Donation::with(['user', 'campaign'])
                ->where('user_id', Auth::user()->id)
                ->latest()->get();
        } elseif (Auth::user()?->type == Type::Organization->value) {
            $history = OrganizationApplication::with('user')
                ->where('user_id', Auth::user()->id)->latest()->get();
        }

        return view('v1.web.pages.user.history', compact('history', 'transactions'), $this->getCountriesDivisionsDistrictsUpazilas());
    }

    public function historyView(Request $request, $sPid)
    {
        $history = new Collection();
        if (Auth::user()?->type == Type::Seeker->value) {
            $history = SeekerApplication::with('user')
                ->where('user_id', Auth::user()->id)->findOrFail($sPid);
        } elseif ((Auth::user()?->type == Type::Volunteer->value)) {
            $history = SeekerApplicationVolunteer::with(['application', 'user.upazila.district.division.country'])
                ->where('user_id', Auth::user()->id)
                ->where('seeker_application_id', $sPid)->firstOrFail();
        } elseif (Auth::user()?->type == Type::Donor->value) {
        } elseif (Auth::user()?->type == Type::Organization->value) {
        }

        return view('v1.web.pages.user.history-view', compact('history'), $this->getCountriesDivisionsDistrictsUpazilas());
    }

    public function fundRequest()
    {
        $categories = SeekerApplicationCategory::array();

        return view('v1.web.pages.fund-request', $this->getCountriesDivisionsDistrictsUpazilas(), compact('categories'));

    }

    public function fundRequestStore(Request $request)
    {
        if (Auth::user() && (Auth::user()->type == Type::Seeker->value || Auth::user()->type == Type::Organization->value)) {
            $request->validate([
                'title' => ['required'],
                'description' => ['required'],
                'category' => ['required', Rule::in(SeekerApplicationCategory::values())],
                'requested_amount' => ['required', 'numeric'],
                'completion_date' => ['required', 'date', 'after:today'],
                'document' => ['file', 'mimetypes:image/jpeg,image/png,application/pdf', 'nullable'],
                'image' => ['file', 'mimes:jpeg,png,jpg', 'nullable'],
                'terms' => ['required'],
            ]);
            if (Auth::user()->type == Type::Seeker->value) {
                try {
                    DB::beginTransaction();

                    $seekerApplication = new SeekerApplication();
                    $seekerApplication->user_id = Auth::user()->id;
                    // return Auth::user()->id;
                    $seekerApplication->title = $request->title;
                    $seekerApplication->description = $request->description ?? null;
                    $seekerApplication->requested_amount = $request->requested_amount;
                    $seekerApplication->completion_date = $request->completion_date;
                    $seekerApplication->category = $request->category;
                    if ($request->file('document')) {
                        $documentPath = $this->storeFile('user', $request->file('document'), 'document');
                        $seekerApplication->document = $documentPath ?? null;
                    }
                    if ($request->file('image')) {
                        $photoPath = $this->storeFile('user', $request->file('image'), 'image');
                        $seekerApplication->image = $photoPath ?? null;
                    }
                    $seekerApplication->save();
                    // return "OK1";

                    // $seekerApplication->update([
                    //     'sid' => 'SAT-'. 100_000 + $seekerApplication->id,
                    // ]);

                    DB::commit();

                    return redirect()->back()->with('success', 'Seeker Application Created Successfully');

                } catch (\Throwable $th) {

                    DB::rollBack();

                    return new JsonResponse(
                        [
                            'message' => $th->getMessage(),
                        ],
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
                }

            } else {
                try {
                    DB::beginTransaction();

                    $organizationApplication = new OrganizationApplication();
                    $organizationApplication->user_id = Auth::user()->id;
                    $organizationApplication->title = $request->title;
                    $organizationApplication->description = $request->description ?? null;
                    $organizationApplication->requested_amount = $request->requested_amount;
                    $organizationApplication->completion_date = $request->completion_date;
                    if ($request->file('document')) {
                        $documentPath = $this->storeFile('user', $request->file('document'), 'document');
                        $organizationApplication->document = $documentPath ?? null;
                    }
                    if ($request->file('image')) {
                        $photoPath = $this->storeFile('user', $request->file('image'), 'image');
                        $organizationApplication->image = $photoPath ?? null;
                    }
                    $organizationApplication->save();
                    // $organizationApplication->update([
                    //     'sid' => 'OAT-'. 100_000 + $organizationApplication->id,
                    // ]);
                    DB::commit();

                    return redirect()->back()->with('success', 'Organization Application Created Successfully');

                } catch (\Throwable $th) {

                    DB::rollBack();

                    return new JsonResponse(
                        [
                            'message' => $th->getMessage(),
                        ],
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
            }
        } else {

            return redirect()->back()->with('success', 'Please login as a organization/seeker to apply your application');

        }

    }

    public function volunteerDocumentSubmit(Request $request, $id)
    {
        $request->validate([
            'volunteer_document' => 'required',
            'comment' => 'nullable',
        ]);
        try {
            $application = SeekerApplication::findOrFail($id);

            $filePath = $this->storeFile('seeker-application', $request->file('volunteer_document'), 'Seeker-Application');
            $application->volunteer_document = $filePath;
            $application->volunteer_document_status = GlobalStatus::Pending->value;
            $application->comment = $request->comment;

            $application->save();

            return back()->with('success', 'Investigating Document submitted successfully.');

        } catch (\Throwable $th) {

            DB::rollBack();

            return new JsonResponse(
                [
                    'message' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function successStory($id)
    {
        $successStory = SuccessStory::with('campaign')->findOrFail($id);

        return view('v1.web.pages.success-story-details', compact('successStory'), $this->getCountriesDivisionsDistrictsUpazilas());
    }

    public function getDivision($country_id)
    {
        $division = Division::where('country_id', $country_id)->get();

        return response()->json(['data' => $division], Response::HTTP_OK);
    }

    public function getDistricts($division_id)
    {
        $district = District::where('division_id', $division_id)->get();

        return response()->json(['data' => $district], Response::HTTP_OK);
    }

    public function getUpazilas($district_id)
    {
        $upazilas = Upazila::where('district_id', $district_id)->get();

        return response()->json(['data' => $upazilas], Response::HTTP_OK);
    }

    public function verifyEmail()
    {
        $campaigns = Campaign::withSum('donations as total_raised', 'amount')->latest()->get();
        $campaignCategory = CampaignCategory::orderBy('title', 'asc')->get();
        $featuredCampaign = Campaign::where('is_featured', '1')->latest()->get();
        $categoryWiseCampaign = Campaign::withSum('donations as total_raised', 'amount')
            ->withCount('donors as total_donors')
            ->where('category_id', $campaignCategory[0]?->id ?? null)
            ->latest()->get();
        $successStories = SuccessStory::latest()->get();

        $volunteerNumber = User::where('type', 'volunteer')
            ->where('status', 'approved')
            ->count();

        $heroSection = Content::where('type', 'hero-section')->first();

        return view('v1.web.pages.home',
            compact(['campaigns', 'campaignCategory', 'featuredCampaign', 'categoryWiseCampaign', 'successStories', 'heroSection', 'volunteerNumber']),
            $this->getCountriesDivisionsDistrictsUpazilas());
    }

    public function showInvoiceHistory(string $id)
    {
        $invoices = Invoice::with([
            'transaction',
            'statusInfo',
            'transaction.transactionCategory',
            'transaction.donorInfo',
            'transaction.volunteerInfo',
            'transaction.campaignInfo',
            'transaction.bankInfo',
            'transaction.bankAccountInfo',
            'transaction.campaignInfo',
        ])
            ->where('campaign_id', $id)
            ->latest()
            ->get();

        $campaign = Campaign::find($id);

        return view('v1.admin.pages.invoice.history', compact('invoices', 'campaign'));
    }

    public function showLogin()
    {
        return view('v2.web.pages.login');
    }

    public function showSignup()
    {
        return view('v2.web.pages.signup', $this->getCountriesDivisionsDistrictsUpazilas());
    }

    public function registrationComplete()
    {
        return view('v2.web.pages.congrats');
    }

    public function showOurWorks(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $category = $request->query('category', null);
        $perPage = $request->query('per_page', 9);
        $search = $request->query('search');

        $works = SuccessStory::when($search, function ($q) use ($search) {
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('short_description', 'LIKE', "%{$search}%")
                    ->orWhereHas('campaign', function ($q) use ($search) {
                        $q->where('title', 'LIKE', "%{$search}%")
                            ->orWhere('short_description', 'LIKE', "%{$search}%");
                    });
            });
        })->orderBy('created_at', $sort)->paginate($perPage);

        return view('v2.web.pages.our-works', compact('works'));
    }

    public function showOurWork(int $id)
    {
        $work = SuccessStory::find($id);

        return view('v2.web.pages.our-work', compact('work'));
    }

    public function contact()
    {
        return view('v2.web.pages.contact');
    }
}
