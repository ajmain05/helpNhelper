@extends('v1.admin.layouts.master')
@section('title', 'Dashboard')
@section('header', 'Dashboard')

@php
    use App\Models\User;
    use App\Models\CorporateWallet;
    use App\Models\CorporateDeposit;
    use App\Models\CorporateAllocation;
    use App\Models\Campaign\Campaign;

    $totalDonors          = User::where('type', 'donor')->count();
    $totalCorporateDonors = User::where('type', 'corporate-donor')->count();
    $totalVolunteers      = User::where('type', 'volunteer')->count();
    $totalSeekers         = User::where('type', 'seeker')->count();

    $corpBalance    = CorporateWallet::sum('balance');
    $corpDeposited  = CorporateWallet::sum('total_deposited');
    $corpAllocated  = CorporateAllocation::sum('amount');
    $pendingCheques = CorporateDeposit::where('method','offline')->where('status','under_review')->count();

    $totalCampaigns  = Campaign::count();
    $activeCampaigns = Campaign::where('status','approved')->count();

    $topDonors = User::where('type', 'corporate-donor')
        ->with('corporateWallet')
        ->get()
        ->sortByDesc(fn($u) => $u->corporateWallet?->balance ?? 0)
        ->take(5);

    $recentAllocations = CorporateAllocation::with(['user','campaign'])->latest()->take(5)->get();
    $recentCheques     = CorporateDeposit::with('user')->where('method','offline')->latest()->take(5)->get();

    $pendingDonors    = User::where('type','donor')->where('status','pending')->count();
    $pendingCorporate = User::where('type','corporate-donor')->where('status','pending')->count();
@endphp

@section('content')
<section class="content">
<div class="container-fluid">

{{-- ══ Row 1: Key Metrics (2×2 grid on small, 4-col on large) ══ --}}
<div class="row mt-3">

    {{-- Corporate Balance --}}
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="info-box shadow-sm mb-0">
            <span class="info-box-icon" style="background:#667eea;color:#fff;">
                <i class="fas fa-building"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Corporate Balance</span>
                <span class="info-box-number">৳{{ number_format($corpBalance, 0) }}</span>
                <a href="{{ route('admin.corporate-donors.index') }}" class="small text-muted">View Donors →</a>
            </div>
        </div>
    </div>

    {{-- Total Deposited --}}
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="info-box shadow-sm mb-0">
            <span class="info-box-icon" style="background:#11998e;color:#fff;">
                <i class="fas fa-wallet"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Deposited</span>
                <span class="info-box-number">৳{{ number_format($corpDeposited, 0) }}</span>
                <a href="{{ route('admin.cheque-deposits.index') }}" class="small text-muted">Deposit History →</a>
            </div>
        </div>
    </div>

    {{-- Allocated --}}
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="info-box shadow-sm mb-0">
            <span class="info-box-icon" style="background:#e91e8c;color:#fff;">
                <i class="fas fa-hand-holding-usd"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Allocated to Campaigns</span>
                <span class="info-box-number">৳{{ number_format($corpAllocated, 0) }}</span>
                <a href="{{ route('admin.corporate-donors.index') }}" class="small text-muted">View Allocations →</a>
            </div>
        </div>
    </div>

    {{-- Pending Cheques --}}
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="info-box shadow-sm mb-0 {{ $pendingCheques > 0 ? 'bg-warning' : '' }}">
            <span class="info-box-icon" style="background:#f7971e;color:#fff;">
                <i class="fas fa-file-invoice-dollar"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Cheques Pending</span>
                <span class="info-box-number">{{ $pendingCheques }}</span>
                <a href="{{ route('admin.cheque-deposits.index', ['status'=>'under_review']) }}"
                   class="small {{ $pendingCheques > 0 ? 'font-weight-bold' : 'text-muted' }}">
                    Review Now →
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ══ Row 2: People Stats (responsive wrap) ══ --}}
<div class="row">
    @foreach([
        ['label'=>'Donors',           'count'=> $totalDonors,          'pending'=>$pendingDonors,    'icon'=>'fa-hand-holding-usd','color'=>'#4CAF50','route'=>route('admin.donors.index')],
        ['label'=>'Corporate Donors', 'count'=> $totalCorporateDonors, 'pending'=>$pendingCorporate, 'icon'=>'fa-building',        'color'=>'#673ab7','route'=>route('admin.corporate-donors.index')],
        ['label'=>'Volunteers',       'count'=> $totalVolunteers,       'pending'=>0,                 'icon'=>'fa-user-nurse',      'color'=>'#2196F3','route'=>route('admin.volunteers.index')],
        ['label'=>'Seekers',          'count'=> $totalSeekers,          'pending'=>0,                 'icon'=>'fa-heart',           'color'=>'#ff5722','route'=>route('admin.seekers.index')],
        ['label'=>'Campaigns',        'count'=> $totalCampaigns,        'pending'=>0,                 'icon'=>'fa-bullhorn',        'color'=>'#009688','route'=>route('admin.campaigns.index')],
        ['label'=>'Active Campaigns', 'count'=> $activeCampaigns,       'pending'=>0,                 'icon'=>'fa-fire',            'color'=>'#ff9800','route'=>route('admin.campaigns.index')],
    ] as $stat)
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <a href="{{ $stat['route'] }}" class="text-decoration-none">
            <div class="card text-center py-3 px-2 h-100 border-0 shadow-sm" style="border-radius:14px;">
                <div class="mx-auto mb-2 d-flex align-items-center justify-content-center"
                     style="width:44px;height:44px;border-radius:12px;background:{{ $stat['color'] }}22;">
                    <i class="fas {{ $stat['icon'] }}" style="color:{{ $stat['color'] }};font-size:18px;"></i>
                </div>
                <h5 class="mb-0 font-weight-bold">{{ $stat['count'] }}</h5>
                <small class="text-muted" style="font-size:11px;">{{ $stat['label'] }}</small>
                @if($stat['pending'] > 0)
                    <span class="badge badge-warning mt-1">{{ $stat['pending'] }} pending</span>
                @endif
            </div>
        </a>
    </div>
    @endforeach
</div>

{{-- ══ Row 3: Tables ══ --}}
<div class="row">

    {{-- Top Corporate Donors --}}
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
            <div class="card-header border-0" style="border-radius:14px 14px 0 0;background:#667eea;color:#fff;">
                <h6 class="mb-0"><i class="fas fa-trophy mr-2"></i>Top Corporate Donors</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($topDonors as $i => $donor)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                        <div class="d-flex align-items-center" style="min-width:0;">
                            <span class="badge badge-pill mr-2 flex-shrink-0"
                                  style="background:{{ ['#667eea','#764ba2','#11998e','#e91e8c','#f7971e'][$i]??'#aaa' }};color:#fff;">
                                {{ $i+1 }}
                            </span>
                            <div style="min-width:0;">
                                <div class="font-weight-bold text-truncate" style="font-size:13px;max-width:130px;">
                                    {{ $donor->name }}</div>
                                <small class="text-muted text-truncate d-block" style="max-width:130px;">
                                    {{ $donor->email }}</small>
                            </div>
                        </div>
                        <span class="badge badge-success badge-pill flex-shrink-0">
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

    {{-- Recent Campaign Allocations --}}
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
            <div class="card-header border-0" style="border-radius:14px 14px 0 0;background:#11998e;color:#fff;">
                <h6 class="mb-0"><i class="fas fa-exchange-alt mr-2"></i>Recent Allocations</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentAllocations as $alloc)
                    <li class="list-group-item py-2 px-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div style="min-width:0;">
                                <div class="font-weight-bold text-truncate" style="font-size:13px;max-width:150px;">
                                    {{ $alloc->user?->name ?? 'N/A' }}</div>
                                <small class="text-muted text-truncate d-block" style="max-width:150px;">
                                    {{ Str::limit($alloc->campaign?->title ?? 'Campaign', 28) }}</small>
                            </div>
                            <div class="text-right flex-shrink-0 ml-2">
                                <span class="text-danger font-weight-bold" style="font-size:13px;">
                                    − ৳{{ number_format($alloc->amount, 0) }}
                                </span><br>
                                <small class="text-muted">{{ $alloc->allocated_at?->format('d M') }}</small>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted py-4">No allocations yet.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer bg-transparent border-0 p-2">
                <a href="{{ route('admin.corporate-donors.index') }}"
                   class="btn btn-sm btn-outline-success btn-block" style="border-radius:8px;">
                    Manage Allocations
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Cheque Requests --}}
    <div class="col-lg-4 col-md-12 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
            <div class="card-header border-0" style="border-radius:14px 14px 0 0;background:#555d6b;color:#fff;">
                <h6 class="mb-0"><i class="fas fa-file-invoice-dollar mr-2"></i>Cheque Requests</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentCheques as $chq)
                    <li class="list-group-item py-2 px-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div style="min-width:0;">
                                <div class="font-weight-bold text-truncate" style="font-size:13px;max-width:140px;">
                                    {{ $chq->user?->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $chq->bank_name ?? '—' }}</small>
                            </div>
                            <div class="text-right flex-shrink-0 ml-2">
                                <div class="font-weight-bold" style="font-size:13px;">
                                    ৳{{ number_format($chq->amount, 0) }}
                                </div>
                                @php
                                    $badge = match($chq->status) {
                                        'under_review' => 'warning',
                                        'completed'    => 'success',
                                        'rejected'     => 'danger',
                                        default        => 'secondary',
                                    };
                                @endphp
                                <span class="badge badge-{{ $badge }}">
                                    {{ ucfirst(str_replace('_',' ',$chq->status)) }}
                                </span>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted py-4">No cheque requests.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer bg-transparent border-0 p-2">
                <a href="{{ route('admin.cheque-deposits.index') }}"
                   class="btn btn-sm btn-outline-secondary btn-block" style="border-radius:8px;">
                    Review All Cheques
                </a>
            </div>
        </div>
    </div>

</div>{{-- / Row 3 --}}

</div>{{-- / container-fluid --}}
</section>
@endsection
