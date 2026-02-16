@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Faq</h1>
                    </div>
                    {{-- <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Faq</li>
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
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                    data-target="#create">
                                    Add New
                                </button>
                                <div class="modal fade" id="create" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Create FAQ</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('admin/faq') }}" method="post">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="title">Title <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="title"
                                                            name="title" placeholder="Enter title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Description <span
                                                                class="text-red">*</span></label>
                                                        <textarea rows="3" class="form-control" id="description" name="description" placeholder="Enter description"></textarea>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Create</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="seekerApplicationsDatatable"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($faqs as $faq)
                                                <tr>
                                                    <td>{{ $faq->title }}</td>
                                                    <td>{{ $faq->description }}</td>
                                                    <td>
                                                        <button class="btn btn-primary m-1" data-toggle="modal"
                                                            data-target="#create-{{ $loop->index }}">Edit</button>
                                                        <button class="btn btn-danger m-1"
                                                            onclick="deleteSuccess({{ $faq->id }})">Delete</button>
                                                    </td>
                                                    <div class="modal fade" id="create-{{ $loop->index }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                        FAQ</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ url('admin/faq/update') }}" method="post">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $faq->id }}">
                                                                        <div class="form-group">
                                                                            <label for="title">Title <span
                                                                                    class="text-red">*</span></label>
                                                                            <input type="text"
                                                                                value="{{ $faq->title }}"
                                                                                class="form-control" id="title"
                                                                                name="title" placeholder="Enter title">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="description">Description <span
                                                                                    class="text-red">*</span></label>
                                                                            <textarea rows="3" class="form-control" id="description" name="description" placeholder="Enter description">{{ $faq->description }}</textarea>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>
                                            @endforeach
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
        function deleteSuccess(id) {
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
                        url: "{{ route('admin.faq.delete') }}",
                        type: 'post',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: data.message,
                                icon: 'success',
                                willClose: () => {
                                    location.reload();
                                }
                            });
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
