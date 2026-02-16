@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')

                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0">{{ ucfirst($userRequestType) }} Requests</h1>
                    </div>
                    {{-- <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">{{ $userRequestType }} Requests</li>
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
                                    <table class="table table-bordered table-hover" id="userRequestDatatable"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Tracking Id</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                @if ($userRequestType == 'donor')
                                                    <th>Type</th>
                                                @endif
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                @if ($userRequestType != 'donor')
                                                    <th>Present Address</th>
                                                @endif
                                                <th>Status</th>
                                                <th>Creation Date & Time</th>
                                                @if ($userRequestType == 'volunteer')
                                                    <th>Facebook Profile Link</th>
                                                @endif
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
        $('#userRequestDatatable').DataTable({
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
            ajax: '{{ route('admin.user-requests.ajax', $userRequestType) }}',
            columns: [{
                    data: 'sid',
                    name: 'sid'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'photo',
                    name: 'photo',
                    orderable: false,
                    searchable: false
                },
                @if ($userRequestType == 'donor')
                    {
                        data: 'type',
                        name: 'type'
                    },
                @endif {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'mobile',
                    name: 'mobile'
                },
                @if ($userRequestType != 'donor')
                    {
                        data: 'present_address',
                        name: 'present_address'
                    },
                @endif {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                @if ($userRequestType == 'volunteer')
                    {
                        data: 'fb_link',
                        name: 'fb_link'
                    },
                @endif {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function deleteUserRequest(id) {
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
                        url: "{{ route('admin.user-request.delete') }}",
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
                            $('#userRequestDatatable').DataTable().ajax.reload();
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
