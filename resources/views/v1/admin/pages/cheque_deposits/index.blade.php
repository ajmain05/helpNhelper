@extends('v1.admin.layouts.master')
@section('title', 'Cheque Deposits')
@section('header', 'Cheque Deposit Requests')
@section('content')

<section class="content">
    <div class="container-fluid">

        {{-- Stats Row --}}
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $pendingCount }}</h3>
                        <p>Under Review</p>
                    </div>
                    <div class="icon"><i class="fas fa-clock"></i></div>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div id="ajax-alert"></div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-info">
                    <div class="card-header bg-olive d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Cheque Deposits</h3>
                        <div>
                            {{-- Status Filter --}}
                            <a href="{{ route('admin.cheque-deposits.index', ['status' => 'under_review']) }}"
                               class="btn btn-sm {{ $status === 'under_review' ? 'btn-warning' : 'btn-outline-warning' }}">Under Review</a>
                            <a href="{{ route('admin.cheque-deposits.index', ['status' => 'completed']) }}"
                               class="btn btn-sm {{ $status === 'completed' ? 'btn-success' : 'btn-outline-success' }}">Approved</a>
                            <a href="{{ route('admin.cheque-deposits.index', ['status' => 'rejected']) }}"
                               class="btn btn-sm {{ $status === 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">Rejected</a>
                            <a href="{{ route('admin.cheque-deposits.index', ['status' => 'all']) }}"
                               class="btn btn-sm {{ $status === 'all' ? 'btn-secondary' : 'btn-outline-secondary' }}">All</a>

                            {{-- Add Cheque Button --}}
                            <button class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#addChequeModal">
                                <i class="fas fa-plus"></i> Add Cheque Deposit
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-striped table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Donor</th>
                                    <th>Amount</th>
                                    <th>Cheque No</th>
                                    <th>Bank</th>
                                    <th>Cheque Image</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deposits as $dep)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $dep->user->name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $dep->user->email ?? '' }}</small>
                                    </td>
                                    <td><strong>৳{{ number_format($dep->amount, 2) }}</strong></td>
                                    <td>{{ $dep->cheque_no ?? '—' }}</td>
                                    <td>{{ $dep->bank_name ?? '—' }}</td>
                                    <td>
                                        @if($dep->cheque_image)
                                            <a href="{{ Storage::url($dep->cheque_image) }}" target="_blank">
                                                <img src="{{ Storage::url($dep->cheque_image) }}" width="60" class="rounded border">
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $badge = match($dep->status) {
                                                'under_review' => 'warning',
                                                'completed'    => 'success',
                                                'rejected'     => 'danger',
                                                default        => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $badge }}">{{ ucfirst(str_replace('_',' ',$dep->status)) }}</span>
                                        @if($dep->admin_note)
                                            <br><small class="text-muted">{{ $dep->admin_note }}</small>
                                        @endif
                                    </td>
                                    <td><small>{{ $dep->created_at->format('d M Y, h:i A') }}</small></td>
                                    <td>
                                        @if($dep->status === 'under_review')
                                            <button class="btn btn-xs btn-success btn-approve" data-id="{{ $dep->id }}">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-xs btn-danger btn-reject" data-id="{{ $dep->id }}">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        @else
                                            <span class="text-muted small">No action</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No cheque deposits found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $deposits->appends(['status' => $status])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ Add Cheque Modal (Admin Direct Credit) ══ --}}
<div class="modal fade" id="addChequeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.cheque-deposits.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-money-check-alt mr-2"></i>Add Cheque Deposit</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Corporate Donor <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control select2" required>
                            <option value="">Select Donor...</option>
                            @foreach(\App\Models\User::where('type','corporate-donor')->where('status','approved')->orderBy('name')->get() as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" name="amount" class="form-control" min="1" step="0.01" required placeholder="e.g. 500000">
                    </div>
                    <div class="form-group">
                        <label>Cheque Number <span class="text-danger">*</span></label>
                        <input type="text" name="cheque_no" class="form-control" required placeholder="e.g. 001234567">
                    </div>
                    <div class="form-group">
                        <label>Bank Name <span class="text-danger">*</span></label>
                        <input type="text" name="bank_name" class="form-control" required placeholder="e.g. Dutch Bangla Bank">
                    </div>
                    <div class="form-group">
                        <label>Cheque Image (optional)</label>
                        <input type="file" name="cheque_image" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Admin Note (optional)</label>
                        <textarea name="admin_note" class="form-control" rows="2" placeholder="Internal note or reference..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check mr-1"></i>Credit Wallet</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══ Reject Modal ══ --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Reject Cheque Deposit</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="reject_deposit_id">
                <div class="form-group">
                    <label>Reason for Rejection <span class="text-danger">*</span></label>
                    <textarea id="reject_note" class="form-control" rows="3" placeholder="Explain the reason to the donor..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="confirmRejectBtn" class="btn btn-danger">Confirm Reject</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize select2 if available
    if ($.fn.select2) { $('.select2').select2({ dropdownParent: $('#addChequeModal') }); }

    // ── Approve
    $('body').on('click', '.btn-approve', function() {
        var id = $(this).data('id');
        if (!confirm('Approve this deposit? Wallet will be credited immediately.')) return;

        $.post("{{ url('admin/cheque-deposits') }}/" + id + "/approve", {
            _token: "{{ csrf_token() }}",
        }, function(res) {
            if (res.success) {
                showAjaxAlert('success', res.message + ' New balance: ৳' + parseFloat(res.new_balance).toLocaleString('en-BD'));
                setTimeout(() => location.reload(), 2500);
            } else {
                showAjaxAlert('danger', res.message);
            }
        }).fail(function(){ showAjaxAlert('danger', 'Server error. Please try again.'); });
    });

    // ── Reject (open modal)
    $('body').on('click', '.btn-reject', function() {
        $('#reject_deposit_id').val($(this).data('id'));
        $('#reject_note').val('');
        $('#rejectModal').modal('show');
    });

    // ── Reject (confirm)
    $('#confirmRejectBtn').on('click', function() {
        var id   = $('#reject_deposit_id').val();
        var note = $('#reject_note').val().trim();
        if (!note) { alert('Please provide a rejection reason.'); return; }

        $(this).attr('disabled', true).text('Processing...');

        $.post("{{ url('admin/cheque-deposits') }}/" + id + "/reject", {
            _token: "{{ csrf_token() }}",
            admin_note: note,
        }, function(res) {
            $('#rejectModal').modal('hide');
            if (res.success) {
                showAjaxAlert('success', 'Deposit rejected and donor notified.');
                setTimeout(() => location.reload(), 2500);
            } else {
                showAjaxAlert('danger', res.message);
            }
        }).fail(function(){ showAjaxAlert('danger', 'Server error.'); })
          .always(function(){ $('#confirmRejectBtn').attr('disabled', false).text('Confirm Reject'); });
    });

    function showAjaxAlert(type, msg) {
        $('#ajax-alert').html('<div class="alert alert-' + type + ' alert-dismissible fade show">' + msg +
            '<button class="close" data-dismiss="alert"><span>&times;</span></button></div>');
    }
});
</script>
@endpush
