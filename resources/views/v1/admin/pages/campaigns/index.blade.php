@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Campaigns</h1>
                    </div>
                    {{-- <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Campaigns</li>
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
                            <div class="card-header">
                                <a href="{{ route('admin.campaign.create') }}"
                                    class="btn btn-primary btn-sm float-right">Add
                                    New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="campaignsDatatable"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Tracking Id</th>
                                                <th>Application Title</th>
                                                <th>Thumbnail</th>
                                                <th>Category</th>
                                                <th>Title</th>
                                                <th>Amount</th>
                                                <th>Creation Time & Date</th>
                                                <th>Status</th>
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
        $('#campaignsDatatable').DataTable({
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
            ajax: '{{ route('admin.campaigns.ajax') }}',
            columns: [{
                    data: 'sid',
                    name: 'sid'
                },
                {
                    data: 'seeker_application.title',
                    name: 'seeker_application.title'
                },
                {
                    data: 'photo',
                    name: 'photo',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'category.title',
                    name: 'category.title'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function deleteCampaign(id) {
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
                        url: "{{ route('admin.campaign.delete') }}",
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
                            $('#campaignsDatatable').DataTable().ajax.reload();
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

        function deleteSeekerApplication(id) {
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
                        url: "{{ route('admin.campaign.delete') }}",
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
                            $('#campaignsDatatable').DataTable().ajax.reload();
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
