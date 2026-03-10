@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')

                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="m-0">Donor List</h1>
                        <div class="d-flex">
                            <a href="{{ route('admin.users.download', ['type' => 'donor']) }}"
                                class="btn btn-primary d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mr-1"
                                    fill="currentColor" class="bi bi-filetype-xlsx" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM7.86 14.841a1.13 1.13 0 0 0 .401.823q.195.162.479.252.284.091.665.091.507 0 .858-.158.355-.158.54-.44a1.17 1.17 0 0 0 .187-.656q0-.336-.135-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.565-.21l-.621-.144a1 1 0 0 1-.405-.176.37.37 0 0 1-.143-.299q0-.234.184-.384.188-.152.513-.152.214 0 .37.068a.6.6 0 0 1 .245.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.199-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.44 0-.777.15-.336.149-.527.421-.19.273-.19.639 0 .302.123.524t.351.367q.229.143.54.213l.618.144q.31.073.462.193a.39.39 0 0 1 .153.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.168.07-.413.07-.176 0-.32-.04a.8.8 0 0 1-.249-.115.58.58 0 0 1-.255-.384zm-3.726-2.909h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415H1.5l1.24-2.016-1.228-1.983h.931l.832 1.438h.036zm1.923 3.325h1.697v.674H5.266v-3.999h.791zm7.636-3.325h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415h-.861l1.24-2.016-1.228-1.983h.931l.832 1.438h.036z" />
                                </svg>
                                Donor Download
                            </a>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Donor List</li>
                        </ol>
                    </div> --}}
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="donorsDatatable"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Tracking No</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Type</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Wallet Balance</th>
                                                <th>Status</th>
                                                <th>Creation Date & Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->

        <!-- Deposit Modal -->
        <div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.donor.deposit') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title text-white">Deposit Cheque for <span id="depositDonorName"></span></h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="user_id" id="depositUserId">
                            
                            <div class="form-group">
                                <label>Amount (৳) <span class="text-danger">*</span></label>
                                <input type="number" name="amount" class="form-control" required min="1" placeholder="e.g. 50000">
                            </div>

                            <div class="form-group">
                                <label>Cheque Number / Reference</label>
                                <input type="text" name="cheque_number" class="form-control" placeholder="Optional. e.g. CHQ-987654321">
                                <small class="text-muted">Will autogenerate if left blank.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Confirm Deposit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.Deposit Modal -->

    </div>
@endsection

@section('additional_scripts')
    <script>
        $('#donorsDatatable').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
                url: '{{ route('admin.donors.ajax') }}'
            },
            pagingType: 'full_numbers',
            language: {
                paginate: {
                    first: '<<',
                    last: '>>',
                    next: '>',
                    previous: '<'
                }
            },
            columns: [{
                    data: 'users.sid',
                    name: 'users.sid'
                },
                {
                    data: 'users.name',
                    name: 'users.name'
                },
                {
                    data: 'users.photo',
                    name: 'users.photo',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'users.type',
                    name: 'users.type'
                },
                {
                    data: 'users.email',
                    name: 'users.email'
                },
                {
                    data: 'users.mobile',
                    name: 'users.mobile'
                },
                {
                    data: 'wallet',
                    name: 'wallet',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function deleteDonor(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.donor.delete') }}",
                        type: 'post',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            Swal.fire(
                                'Deleted!',
                                data.message,
                                'success'
                            )
                            $('#donorsDatatable').DataTable().ajax.reload();
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error!',
                                data.statusText,
                                'error'
                            )
                        }
                    });
                } else {
                    Swal.fire('Cancelled', 'Operation Cancelled', 'error');
                }
            });
        }

        function openDepositModal(id, name) {
            $('#depositUserId').val(id);
            $('#depositDonorName').text(name);
            $('#depositModal').modal('show');
        }
    </script>
@endsection
