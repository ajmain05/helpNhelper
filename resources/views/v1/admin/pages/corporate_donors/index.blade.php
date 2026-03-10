@extends('v1.admin.layouts.master')
@section('title', 'Corporate Donors')
@section('header', 'Corporate Donors')
@section('content')

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

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    var table = $('#corporateDonorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.corporate-donors.datatable') }}",
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
            error: function () {
                $btn.prop('disabled', false).html('<i class="fas fa-coins mr-1"></i> Allocate & Notify');
                flash('danger', 'An error occurred.');
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
@endpush
