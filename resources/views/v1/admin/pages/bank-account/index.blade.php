@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Bank Account</h1>
                    </div>
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
                            <div class="card-header">
                                <a href="{{ route('admin.bank-account.create') }}"
                                    class="btn btn-primary btn-sm float-right">Add
                                    New bank account</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="bankAccountDatatable"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Bank</th>
                                                <th>Branch</th>
                                                <th>Account Number</th>
                                                <th>Opening Balance</th>
                                                <th>Current Balance</th>
                                                <th>Creation Time & Date</th>
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
    </div>
@endsection

@section('additional_scripts')
    <script>
        $('#bankAccountDatatable').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            pagingType: 'full_numbers',
            language: {
                paginate: {
                    first: '<<',
                    last: '>>',
                    next: '>',
                    previous: '<'
                }
            },
            ajax: '{{ route('admin.bank-account.ajax') }}',
            columns: [{
                    data: 'bank.name',
                    name: 'bank.name'
                },
                {
                    data: 'branch_name',
                    name: 'branch_name'
                },
                {
                    data: 'account_number',
                    name: 'account_number'
                },
                {
                    data: 'opening_balance',
                    name: 'opening_balance'
                },
                {
                    data: 'current_balance',
                    name: 'current_balance'
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

        function deleteBankAccount(id) {
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
                        url: "{{ route('admin.bank-account.delete') }}",
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
                            $('#bankAccountDatatable').DataTable().ajax.reload();
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
    </script>
@endsection
