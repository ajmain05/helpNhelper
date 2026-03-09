@extends('v1.admin.layouts.master')
@section('title', 'Corporate Donors')
@section('header', 'Corporate Donors')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <!-- Alert Section -->
            <div id="alert-container"></div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header bg-olive">
                            <h3 class="card-title">Corporate Donors List</h3>
                        </div>
                        <div class="card-body">
                            <table id="corporateDonorTable" class="table table-bordered table-striped custom-table"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Wallet Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Allocate Modal -->
    <div class="modal fade" id="allocateModal" tabindex="-1" role="dialog" aria-labelledby="allocateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="allocateForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="allocateModalLabel">Allocate Funds (<span id="donorNameDisplay"></span>)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="allocate_user_id" name="user_id">
                        
                        <div class="form-group">
                            <label for="campaign_id">Select Campaign</label>
                            <select class="form-control" id="campaign_id" name="campaign_id" required>
                                <option value="" disabled selected>Select a mapped campaign...</option>
                                @foreach($campaigns as $campaign)
                                    <option value="{{ $campaign->id }}">{{ $campaign->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="amount">Deduction Amount (Tk)</label>
                            <input type="number" class="form-control" id="amount" name="amount" min="1" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="btnAllocateSubmit">Allocate & Notify</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#corporateDonorTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.corporate-donors.datatable') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'wallet', name: 'wallet', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Handle Allocation Button Click
            $('body').on('click', '.btn-allocate', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                
                $('#allocate_user_id').val(id);
                $('#donorNameDisplay').text(name);
                $('#allocateForm').trigger("reset");
                $('#allocateModal').modal('show');
            });

            // Submit Allocation Form
            $('#allocateForm').on('submit', function (e) {
                e.preventDefault();
                $('#btnAllocateSubmit').attr('disabled', true).text('Processing...');
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.corporate-donors.allocate') }}",
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#btnAllocateSubmit').attr('disabled', false).text('Allocate & Notify');
                        if (response.success) {
                            $('#allocateModal').modal('hide');
                            showAlert('success', response.message);
                            table.ajax.reload();
                        } else {
                            showAlert('danger', response.message);
                        }
                    },
                    error: function (error) {
                        $('#btnAllocateSubmit').attr('disabled', false).text('Allocate & Notify');
                        showAlert('danger', 'An error occurred while allocating funds.');
                    }
                });
            });

            function showAlert(type, message) {
                var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                    message +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span></button></div>';
                $('#alert-container').html(alertHtml);
                setTimeout(function() {
                    $('#alert-container .alert').alert('close');
                }, 5000);
            }
        });
    </script>
@endpush
