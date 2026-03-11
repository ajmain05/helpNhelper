@extends('v1.admin.layouts.master')
@section('title', 'Corporate Donors')
@section('header', 'Corporate Donors')
@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mt-3 mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ request()->get('status') == 'pending' ? 'Corporate Donor Request' : 'Corporate Donors' }}
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.users.download', ['type' => 'corporate-donor']) }}"
                        class="btn btn-primary d-inline-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mr-1"
                            fill="currentColor" class="bi bi-filetype-xlsx" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM7.86 14.841a1.13 1.13 0 0 0 .401.823q.195.162.479.252.284.091.665.091.507 0 .858-.158.355-.158.54-.44a1.17 1.17 0 0 0 .187-.656q0-.336-.135-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.565-.21l-.621-.144a1 1 0 0 1-.405-.176.37.37 0 0 1-.143-.299q0-.234.184-.384.188-.152.513-.152.214 0 .37.068a.6.6 0 0 1 .245.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.199-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.44 0-.777.15-.336.149-.527.421-.19.273-.19.639 0 .302.123.524t.351.367q.229.143.54.213l.618.144q.31.073.462.193a.39.39 0 0 1 .153.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.168.07-.413.07-.176 0-.32-.04a.8.8 0 0 1-.249-.115.58.58 0 0 1-.255-.384zm-3.726-2.909h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415H1.5l1.24-2.016-1.228-1.983h.931l.832 1.438h.036zm1.923 3.325h1.697v.674H5.266v-3.999h.791zm7.636-3.325h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415h-.861l1.24-2.016-1.228-1.983h.931l.832 1.438h.036z" />
                        </svg>
                        Corporate Donor Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

        <div id="alert-container"></div>

        {{-- Pending Alert Banner --}}
        @if(($pendingCount ?? 0) > 0)
        <div class="alert alert-warning alert-dismissible fade show mb-3">
            <i class="fas fa-clock mr-2"></i>
            <strong>{{ $pendingCount }} corporate donor request(s)</strong> are awaiting your approval.
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-info">
                    <div class="card-header bg-olive d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Corporate Donors</h3>
                        @if(($pendingCount ?? 0) > 0)
                            <span class="badge badge-warning badge-pill ml-2">{{ $pendingCount }} Pending</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <table id="corporateDonorTable"
                               class="table table-bordered table-striped custom-table"
                               style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Wallet Balance</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

{{-- Allocate Funds Modal --}}
<div class="modal fade" id="allocateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="allocateForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Allocate Funds &mdash; <span id="donorNameDisplay"></span></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="allocate_user_id" name="user_id">
                    <div class="form-group">
                        <label>Campaign</label>
                        <select class="form-control" name="campaign_id" required>
                            <option value="" disabled selected>Select a campaign…</option>
                            @foreach($campaigns as $campaign)
                                <option value="{{ $campaign->id }}">{{ $campaign->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deduction Amount (Tk)</label>
                        <input type="number" class="form-control" name="amount" min="1" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="btnAllocateSubmit">
                        <i class="fas fa-coins mr-1"></i> Allocate &amp; Notify
                    </button>
                </div>
            </form>
        </div>
</div>
    </div>
</div>

{{-- Allocations History Modal --}}
<div class="modal fade" id="allocationsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Past Allocations &mdash; <span id="historyDonorNameDisplay"></span></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="allocationsTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Campaign</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('additional_scripts')
<script>
$(document).ready(function () {

    var table = $('#corporateDonorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{!! route('admin.corporate-donors.datatable', ['status' => request('status')]) !!}",
        columns: [
            { data: 'id',           name: 'id' },
            { data: 'name',         name: 'name' },
            { data: 'email',        name: 'email' },
            { data: 'mobile',       name: 'mobile' },
            { data: 'status_badge', name: 'status', orderable: false, searchable: false },
            { data: 'wallet',       name: 'wallet',  orderable: false, searchable: false },
            { data: 'action',       name: 'action',  orderable: false, searchable: false }
        ]
    });

    // ── Open Allocate Modal
    $('body').on('click', '.btn-allocate', function () {
        $('#allocate_user_id').val($(this).data('id'));
        $('#donorNameDisplay').text($(this).data('name'));
        $('#allocateForm').trigger('reset');
        $('#allocateModal').modal('show');
    });

    // ── Submit Allocation
    $('#allocateForm').on('submit', function (e) {
        e.preventDefault();
        var $btn = $('#btnAllocateSubmit').prop('disabled', true).text('Processing…');
        $.ajax({
            type: 'POST',
            url: "{{ route('admin.corporate-donors.allocate') }}",
            data: $(this).serialize(),
            success: function (res) {
                $btn.prop('disabled', false).html('<i class="fas fa-coins mr-1"></i> Allocate & Notify');
                if (res.success) {
                    $('#allocateModal').modal('hide');
                    flash('success', res.message);
                    table.ajax.reload();
                } else {
                    flash('danger', res.message);
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="fas fa-coins mr-1"></i> Allocate & Notify');
                var msg = 'An error occurred.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    msg = xhr.responseText.substring(0, 100) + '...';
                }
                flash('danger', msg);
            }
        });
    });

    // ── Open Allocations History Modal
    $('body').on('click', '.btn-allocations', function () {
        var donorId = $(this).data('id');
        var donorName = $(this).data('name');
        
        $('#historyDonorNameDisplay').text(donorName);
        $('#allocationsTable tbody').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
        $('#allocationsModal').modal('show');

        $.ajax({
            url: "{{ url('admin/corporate-donors/allocations') }}/" + donorId,
            type: 'GET',
            success: function (res) {
                var tbody = '';
                if (res.success && res.allocations.length > 0) {
                    res.allocations.forEach(function (allocation) {
                        var date = new Date(allocation.allocated_at).toLocaleDateString();
                        var campaignTitle = allocation.campaign ? allocation.campaign.title : 'Unknown';
                        
                        tbody += '<tr>' +
                            '<td>' + date + '</td>' +
                            '<td>' + campaignTitle + '</td>' +
                            '<td>Tk ' + parseFloat(allocation.amount).toFixed(2) + '</td>' +
                            '<td>' +
                                '<button class="btn btn-sm btn-danger btn-refund" data-id="' + allocation.id + '" data-donor-id="'+ donorId +'">' +
                                    '<i class="fas fa-undo"></i> Refund' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
                    });
                } else {
                    tbody = '<tr><td colspan="4" class="text-center">No past allocations found.</td></tr>';
                }
                $('#allocationsTable tbody').html(tbody);
            },
            error: function () {
                $('#allocationsTable tbody').html('<tr><td colspan="4" class="text-center text-danger">Failed to load allocations.</td></tr>');
            }
        });
    });

    // ── Execute Refund
    $('body').on('click', '.btn-refund', function () {
        if (!confirm('Are you sure you want to refund this allocation? The dashboard and campaign totals will be updated.')) return;
        
        var btn = $(this);
        var allocationId = btn.data('id');
        var donorId = btn.data('donor-id');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Refunding...');

        $.ajax({
            url: "{{ url('admin/corporate-donors/allocation') }}/" + allocationId + "/refund",
            type: 'POST',
            data: { _token: "{{ csrf_token() }}" },
            success: function (res) {
                if (res.success) {
                    flash('success', res.message);
                    table.ajax.reload();
                    $('#allocationsModal').modal('hide');
                } else {
                    flash('danger', res.message);
                    btn.prop('disabled', false).html('<i class="fas fa-undo"></i> Refund');
                }
            },
            error: function (xhr) {
                btn.prop('disabled', false).html('<i class="fas fa-undo"></i> Refund');
                var msg = 'Failed to process refund.';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                flash('danger', msg);
            }
        });
    });

    // ── Approve Donor
    $('body').on('click', '.btn-approve-donor', function () {
        if (!confirm('Approve this corporate donor account?')) return;
        var id = $(this).data('id');
        $.post("{{ url('admin/corporate-donors') }}/" + id + "/approve",
               { _token: "{{ csrf_token() }}" },
               function (res) {
                   flash(res.success ? 'success' : 'danger', res.message);
                   if (res.success) table.ajax.reload();
               });
    });

    // ── Reject Donor
    $('body').on('click', '.btn-reject-donor', function () {
        if (!confirm('Reject this corporate donor request?')) return;
        var id = $(this).data('id');
        $.post("{{ url('admin/corporate-donors') }}/" + id + "/reject",
               { _token: "{{ csrf_token() }}" },
               function (res) {
                   flash(res.success ? 'success' : 'danger', res.message);
                   if (res.success) table.ajax.reload();
               });
    });

    function flash(type, msg) {
        $('#alert-container').html(
            '<div class="alert alert-' + type + ' alert-dismissible fade show">' + msg +
            '<button class="close" data-dismiss="alert"><span>&times;</span></button></div>'
        );
        setTimeout(function () { $('#alert-container .alert').alert('close'); }, 5000);
    }
});
</script>
@endsection
