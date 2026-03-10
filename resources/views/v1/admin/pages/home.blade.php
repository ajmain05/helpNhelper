@extends('v1.admin.layouts.master')
@section('title', 'Dashboard')
@section('header', 'Dashboard')

@php
    use App\Models\User;
    use App\Models\CorporateWallet;
    use App\Models\CorporateDeposit;
    use App\Models\CorporateAllocation;
    use App\Models\Campaign\Campaign;
    use App\Models\Donation;

    // User counts
    $totalDonors          = User::where('type', 'donor')->count();
    $totalCorporateDonors = User::where('type', 'corporate-donor')->count();
    $totalVolunteers      = User::where('type', 'volunteer')->count();
    $totalSeekers         = User::where('type', 'seeker')->count();

    // Corporate wallet totals
    $corpTotalDeposited  = CorporateWallet::sum('total_deposited');
    $corpTotalBalance    = CorporateWallet::sum('balance');
    $corpTotalAllocated  = CorporateAllocation::sum('amount');

    // Cheque deposits
    $pendingCheques = CorporateDeposit::where('method', 'offline')->where('status', 'under_review')->count();

    // Campaigns
    $totalCampaigns    = Campaign::count();
    $activeCampaigns   = Campaign::where('status', 'approved')->count();

    // Top 5 corporate donors by wallet balance
    $topCorporateDonors = User::where('type', 'corporate-donor')
        ->with('corporateWallet')
        ->get()
        ->sortByDesc(fn($u) => $u->corporateWallet?->balance ?? 0)
        ->take(5);

    // Latest allocations
    $recentAllocations = CorporateAllocation::with(['user', 'campaign'])
        ->latest()
        ->take(5)
        ->get();

    // Recent cheque requests
    $recentCheques = CorporateDeposit::with('user')
        ->where('method', 'offline')
        ->latest()
        ->take(5)
        ->get();
@endphp

@section('content')
<section class="content">
    <div class="container-fluid">

        {{-- ══ Row 1: Quick Stats ══ --}}
        <div class="row mt-3">

            {{-- Corporate Balance --}}
            <div class="col-lg-3 col-6">
                <div class="small-box" style="background: linear-gradient(135deg,#667eea,#764ba2); color:#fff;">
                    <div class="inner">
                        <h3>৳{{ number_format($corpTotalBalance, 0) }}</h3>
                        <p>Corporate Wallet Balance</p>
                    </div>
                    <div class="icon"><i class="fas fa-building"></i></div>
                    <a href="{{ route('admin.corporate-donors.index') }}" class="small-box-footer" style="color:rgba(255,255,255,0.8)">
                        View Donors <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Total Deposited --}}
            <div class="col-lg-3 col-6">
                <div class="small-box" style="background: linear-gradient(135deg,#11998e,#38ef7d); color:#fff;">
                    <div class="inner">
                        <h3>৳{{ number_format($corpTotalDeposited, 0) }}</h3>
                        <p>Total Corporate Deposits</p>
                    </div>
                    <div class="icon"><i class="fas fa-wallet"></i></div>
                    <a href="{{ route('admin.cheque-deposits.index') }}" class="small-box-footer" style="color:rgba(255,255,255,0.8)">
                        Deposit History <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Total Allocated --}}
            <div class="col-lg-3 col-6">
                <div class="small-box" style="background: linear-gradient(135deg,#f093fb,#f5576c); color:#fff;">
                    <div class="inner">
                        <h3>৳{{ number_format($corpTotalAllocated, 0) }}</h3>
                        <p>Allocated to Campaigns</p>
                    </div>
                    <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
                    <a href="{{ route('admin.corporate-donors.index') }}" class="small-box-footer" style="color:rgba(255,255,255,0.8)">
                        View Allocations <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Pending Cheques --}}
            <div class="col-lg-3 col-6">
                <div class="small-box {{ $pendingCheques > 0 ? 'bg-warning' : 'bg-secondary' }}">
                    <div class="inner">
                        <h3>{{ $pendingCheques }}</h3>
                        <p>Cheques Awaiting Review</p>
                    </div>
                    <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <a href="{{ route('admin.cheque-deposits.index', ['status' => 'under_review']) }}" class="small-box-footer">
                        Review Now <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- ══ Row 2: People Stats ══ --}}
        <div class="row">
            @foreach([
                ['label' => 'Donors',           'count' => $totalDonors,          'icon' => 'fa-hand-holding-usd', 'color' => '#4CAF50', 'route' => route('admin.donors.index')],
                ['label' => 'Corporate Donors', 'count' => $totalCorporateDonors, 'icon' => 'fa-building',         'color' => '#673ab7', 'route' => route('admin.corporate-donors.index')],
                ['label' => 'Volunteers',       'count' => $totalVolunteers,       'icon' => 'fa-user-nurse',       'color' => '#2196F3', 'route' => route('admin.volunteers.index')],
                ['label' => 'Seekers',          'count' => $totalSeekers,          'icon' => 'fa-heart',            'color' => '#ff5722', 'route' => route('admin.seekers.index')],
                ['label' => 'Campaigns',        'count' => $totalCampaigns,        'icon' => 'fa-bullhorn',         'color' => '#009688', 'route' => route('admin.campaigns.index')],
                ['label' => 'Active Campaigns', 'count' => $activeCampaigns,       'icon' => 'fa-fire',             'color' => '#ff9800', 'route' => route('admin.campaigns.index')],
            ] as $stat)
            <div class="col-lg-2 col-md-4 col-6 mb-3">
                <a href="{{ $stat['route'] }}" class="text-decoration-none">
                    <div class="card text-center py-3 px-2 h-100 border-0 shadow-sm" style="border-radius:16px;">
                        <div class="mx-auto mb-2 d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;border-radius:14px;background:{{ $stat['color'] }}22;">
                            <i class="fas {{ $stat['icon'] }}" style="color:{{ $stat['color'] }};font-size:20px;"></i>
                        </div>
                        <h4 class="mb-0 font-weight-bold">{{ $stat['count'] }}</h4>
                        <small class="text-muted">{{ $stat['label'] }}</small>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{-- ══ Row 3: Tables ══ --}}
        <div class="row">

            {{-- Top Corporate Donors --}}
            <div class="col-md-4">
                <div class="card card-outline card-purple" style="border-radius:16px;">
                    <div class="card-header" style="border-radius:16px 16px 0 0; background:linear-gradient(135deg,#667eea,#764ba2);">
                        <h3 class="card-title text-white"><i class="fas fa-trophy mr-2"></i>Top Corporate Donors</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($topCorporateDonors as $i => $donor)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-pill mr-2"
                                          style="background:{{ ['#667eea','#764ba2','#11998e','#f5576c','#f093fb'][$i] ?? '#ccc' }};color:#fff;">
                                        {{ $i + 1 }}
                                    </span>
                                    <div>
                                        <div class="font-weight-bold" style="font-size:13px;">{{ $donor->name }}</div>
                                        <small class="text-muted">{{ $donor->email }}</small>
                                    </div>
                                </div>
                                <span class="badge badge-success badge-pill">
                                    ৳{{ number_format($donor->corporateWallet?->balance ?? 0, 0) }}
                                </span>
                            </li>
                            @empty
                            <li class="list-group-item text-center text-muted py-4">No corporate donors yet.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Recent Allocations --}}
            <div class="col-md-4">
                <div class="card card-outline card-success" style="border-radius:16px;">
                    <div class="card-header" style="border-radius:16px 16px 0 0; background:linear-gradient(135deg,#11998e,#38ef7d);">
                        <h3 class="card-title text-white"><i class="fas fa-exchange-alt mr-2"></i>Recent Allocations</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($recentAllocations as $alloc)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div style="font-size:13px;font-weight:600;">{{ $alloc->user?->name ?? 'N/A' }}</div>
                                        <small class="text-muted">{{ Str::limit($alloc->campaign?->title ?? 'Campaign', 30) }}</small>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-danger font-weight-bold">− ৳{{ number_format($alloc->amount, 0) }}</span><br>
                                        <small class="text-muted">{{ $alloc->allocated_at?->format('d M') }}</small>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center text-muted py-4">No allocations yet.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center p-2">
                        <a href="{{ route('admin.corporate-donors.index') }}" class="btn btn-sm btn-success btn-block" style="border-radius:10px;">
                            Manage Allocations
                        </a>
                    </div>
                </div>
            </div>

            {{-- Recent Cheque Requests --}}
            <div class="col-md-4">
                <div class="card card-outline card-warning" style="border-radius:16px;">
                    <div class="card-header" style="border-radius:16px 16px 0 0; background:linear-gradient(135deg,#f7971e,#ffd200);">
                        <h3 class="card-title text-dark"><i class="fas fa-file-invoice-dollar mr-2"></i>Cheque Requests</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($recentCheques as $chq)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div style="font-size:13px;font-weight:600;">{{ $chq->user?->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $chq->bank_name ?? '—' }} · {{ $chq->cheque_no ?? '—' }}</small>
                                </div>
                                <div class="text-right">
                                    <div class="font-weight-bold">৳{{ number_format($chq->amount, 0) }}</div>
                                    @php
                                        $badge = match($chq->status) {
                                            'under_review' => 'warning',
                                            'completed'    => 'success',
                                            'rejected'     => 'danger',
                                            default        => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $badge }}">{{ ucfirst(str_replace('_',' ',$chq->status)) }}</span>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center text-muted py-4">No cheque requests.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center p-2">
                        <a href="{{ route('admin.cheque-deposits.index') }}" class="btn btn-sm btn-warning btn-block" style="border-radius:10px;">
                            Review All Cheques
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
