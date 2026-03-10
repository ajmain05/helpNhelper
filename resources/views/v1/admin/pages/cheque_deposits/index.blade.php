@extends('v1.admin.layouts.master')
@section('title', 'Cheque Deposits')
@section('header', 'Cheque Deposit Requests')
@section('content')

<section class="content">
<div class="container-fluid">

    <div id="ajax-alert" class="mb-3"></div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Summary Cards --}}
    <div class="row mb-3">
        <div class="col-sm-4 col-6 mb-2">
            <div class="card border-0 shadow-sm text-center py-3" style="border-radius:12px;">
                <div class="h4 mb-0 font-weight-bold text-warning">{{ $pendingCount }}</div>
                <small class="text-muted">Under Review</small>
            </div>
        </div>
        <div class="col-sm-4 col-6 mb-2">
            <div class="card border-0 shadow-sm text-center py-3" style="border-radius:12px;">
                @php $approvedCount = \App\Models\CorporateDeposit::where('method','offline')->where('status','completed')->count(); @endphp
                <div class="h4 mb-0 font-weight-bold text-success">{{ $approvedCount }}</div>
                <small class="text-muted">Approved</small>
            </div>
        </div>
        <div class="col-sm-4 col-6 mb-2">
            <div class="card border-0 shadow-sm text-center py-3" style="border-radius:12px;">
                @php $rejectedCount = \App\Models\CorporateDeposit::where('method','offline')->where('status','rejected')->count(); @endphp
                <div class="h4 mb-0 font-weight-bold text-danger">{{ $rejectedCount }}</div>
                <small class="text-muted">Rejected</small>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:14px;">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2"
             style="border-radius:14px 14px 0 0;border-bottom:1px solid #f0f0f0;">
            <h6 class="mb-0 font-weight-bold">Cheque Deposits</h6>
            <div class="d-flex flex-wrap gap-1 align-items-center">
                {{-- Status Filter --}}
                <a href="{{ route('admin.cheque-deposits.index', ['status'=>'under_review']) }}"
                   class="btn btn-sm {{ $status==='under_review' ? 'btn-warning' : 'btn-outline-secondary' }}">
                    Under Review
                </a>
                <a href="{{ route('admin.cheque-deposits.index', ['status'=>'completed']) }}"
                   class="btn btn-sm {{ $status==='completed' ? 'btn-success' : 'btn-outline-secondary' }}">
                    Approved
                </a>
                <a href="{{ route('admin.cheque-deposits.index', ['status'=>'rejected']) }}"
                   class="btn btn-sm {{ $status==='rejected' ? 'btn-danger' : 'btn-outline-secondary' }}">
                    Rejected
                </a>
                <a href="{{ route('admin.cheque-deposits.index', ['status'=>'all']) }}"
                   class="btn btn-sm {{ $status==='all' ? 'btn-dark' : 'btn-outline-secondary' }}">
                    All
                </a>

                <button class="btn btn-sm btn-primary ml-1" data-toggle="modal" data-target="#addChequeModal">
                    <i class="fas fa-plus mr-1"></i>Add Deposit
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="min-width:700px;">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Donor</th>
                            <th>Amount</th>
                            <th>Cheque No</th>
                            <th>Bank</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deposits as $dep)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                <strong>{{ $dep->user->name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $dep->user->email ?? '' }}</small>
                            </td>
                            <td class="align-middle font-weight-bold">৳{{ number_format($dep->amount, 2) }}</td>
                            <td class="align-middle">{{ $dep->cheque_no ?? '—' }}</td>
                            <td class="align-middle">{{ $dep->bank_name ?? '—' }}</td>
                            <td class="align-middle">
                                @if($dep->cheque_image)
                                    <a href="{{ Storage::url($dep->cheque_image) }}" target="_blank">
                                        <img src="{{ Storage::url($dep->cheque_image) }}"
                                             width="52" class="rounded border" alt="cheque">
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @php
                                    $bc = match($dep->status) {
                                        'under_review' => 'warning',
                                        'completed'    => 'success',
                                        'rejected'     => 'danger',
                                        default        => 'secondary',
                                    };
                                @endphp
                                <span class="badge badge-{{ $bc }}">
                                    {{ ucfirst(str_replace('_',' ',$dep->status)) }}
                                </span>
                                @if($dep->admin_note)
                                    <br><small class="text-muted">{{ $dep->admin_note }}</small>
                                @endif
                            </td>
                            <td class="align-middle">
                                <small>{{ $dep->created_at->format('d M Y') }}<br>{{ $dep->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="align-middle">
                                @if($dep->status === 'under_review')
                                    <button class="btn btn-xs btn-success btn-approve mb-1" data-id="{{ $dep->id }}">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-xs btn-danger btn-reject" data-id="{{ $dep->id }}">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">
                                <i class="fas fa-file-invoice fa-2x mb-2 d-block text-light"></i>
                                No cheque deposits found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($deposits->hasPages())
        <div class="card-footer bg-white">
            {{ $deposits->appends(['status' => $status])->links() }}
        </div>
        @endif
    </div>

</div>
</section>

{{-- Add Cheque Modal --}}
<div class="modal fade" id="addChequeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.cheque-deposits.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-money-check-alt mr-2 text-primary"></i>Add Cheque Deposit</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Corporate Donor <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control select2" required>
                            <option value="">Select donor…</option>
                            @foreach(\App\Models\User::where('type','corporate-donor')->where('status','approved')->orderBy('name')->get() as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" name="amount" class="form-control" min="1" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Cheque Number <span class="text-danger">*</span></label>
                        <input type="text" name="cheque_no" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Bank Name <span class="text-danger">*</span></label>
                        <input type="text" name="bank_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Cheque Image</label>
                        <input type="file" name="cheque_image" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Admin Note</label>
                        <textarea name="admin_note" class="form-control" rows="2"
                                  placeholder="Internal reference…"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-check mr-1"></i>Credit Wallet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-times-circle mr-2 text-danger"></i>Reject Cheque Deposit</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="reject_deposit_id">
                <div class="form-group">
                    <label>Reason for Rejection <span class="text-danger">*</span></label>
                    <textarea id="reject_note" class="form-control" rows="3"
                              placeholder="Explain the reason to the donor…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button id="confirmRejectBtn" class="btn btn-danger btn-sm">Confirm Reject</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    if ($.fn.select2) { $('.select2').select2({ dropdownParent: $('#addChequeModal') }); }

    function flash(type, msg) {
        $('#ajax-alert').html('<div class="alert alert-' + type + ' alert-dismissible fade show">' + msg +
            '<button class="close" data-dismiss="alert"><span>&times;</span></button></div>');
        setTimeout(function(){ $('#ajax-alert .alert').alert('close'); }, 4000);
    }

    $('body').on('click', '.btn-approve', function () {
        var id = $(this).data('id');
        if (!confirm('Approve this deposit? Wallet will be credited immediately.')) return;
        $.post("{{ url('admin/cheque-deposits') }}/" + id + "/approve", { _token: "{{ csrf_token() }}" },
            function (res) {
                if (res.success) {
                    flash('success', res.message + ' New balance: ৳' + parseFloat(res.new_balance).toLocaleString());
                    setTimeout(() => location.reload(), 2200);
                } else { flash('danger', res.message); }
            }).fail(function(){ flash('danger', 'Server error. Please try again.'); });
    });

    $('body').on('click', '.btn-reject', function () {
        $('#reject_deposit_id').val($(this).data('id'));
        $('#reject_note').val('');
        $('#rejectModal').modal('show');
    });

    $('#confirmRejectBtn').on('click', function () {
        var note = $('#reject_note').val().trim();
        if (!note) { alert('Please provide a rejection reason.'); return; }
        var id = $('#reject_deposit_id').val();
        $(this).prop('disabled', true).text('Processing…');
        $.post("{{ url('admin/cheque-deposits') }}/" + id + "/reject",
               { _token: "{{ csrf_token() }}", admin_note: note },
               function (res) {
                   $('#rejectModal').modal('hide');
                   flash(res.success ? 'success' : 'danger',
                         res.success ? 'Deposit rejected and donor notified.' : res.message);
                   if (res.success) setTimeout(() => location.reload(), 2200);
               }).fail(function(){ flash('danger', 'Server error.'); })
               .always(function(){ $('#confirmRejectBtn').prop('disabled', false).text('Confirm Reject'); });
    });
});
</script>
@endpush
