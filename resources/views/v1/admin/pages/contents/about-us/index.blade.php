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

                {{-- <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">About Us</h1>
                    </div>
                </div><!-- /.row --> --}}
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <form action="{{ url('admin/contents/about-us') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex justify-content-between px-4 pt-4">
                                    <div>
                                        <h3>About Us</h3>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-sm float-right">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <div class="px-4">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="Enter title" value="{{ $about?->title }}">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group d-flex">
                                            <div>
                                                <label for="image_1">Left Image(1:1)</label>
                                                <input type="file" class="form-control" accept="image/*" id="image_1"
                                                    name="image_1">
                                            </div>
                                            <div class="ml-3">
                                                @if ($about?->image_1)
                                                    <img src="{{ asset($about->image_1) }}" alt="team-photo"
                                                        class="img-fluid rounded"
                                                        style="width: auto; height: 80px; object-fit: cover;">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group d-flex gap-3">
                                            <div>
                                                <label for="image_2">Right Image(1:1)</label>
                                                <input type="file" class="form-control" accept="image/*" id="image_2"
                                                    name="image_2">
                                            </div>
                                            <div class="ml-3">
                                                @if ($about?->image_2)
                                                    <img src="{{ asset($about->image_2) }}" alt="team-photo"
                                                        class="img-fluid rounded"
                                                        style="width: auto; height: 80px; object-fit: cover;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea name="description" rows="3" class="form-control">{{ $about?->description }}</textarea>
                                        <small class="form-text text-muted">Press Enter to separate each section (maximum 3
                                            sections).</small>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.card -->
                    </div>
                </div>

                <!-- Meet Our Team Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3>Meet Our Team</h3>
                                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                        data-target="#create-team">
                                        Add New Team Member
                                    </button>
                                </div>
                                <div class="modal fade" id="create-team" tabindex="-1" role="dialog"
                                    aria-labelledby="createTeamLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="createTeamLabel">Create Team Member</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('admin/contents/about-us/team') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="type" value="team">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Name <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" placeholder="Enter name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="sequence">Sequence <span
                                                                class="text-red">*</span></label>
                                                        <input type="number" class="form-control" id="sequence"
                                                            name="sequence" placeholder="Enter sequence">
                                                        <small class="form-text text-muted">Lower values indicate higher
                                                            priority (e.g., 1 shows first).</small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="designation">Designation <span
                                                                class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="designation"
                                                            name="designation" placeholder="Enter designation">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="institution">Institution <span
                                                                class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="institution"
                                                            name="institution" placeholder="Enter institution name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="image">Image(1:1) <span
                                                                class="text-red">*</span></label>
                                                        <input type="file" class="form-control" id="image"
                                                            name="image" accept="image/*">
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
                                    <table class="table table-bordered table-hover" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Designation</th>
                                                <th>Institution</th>
                                                <th>Image</th>
                                                <th>Sequence</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($teams as $team)
                                                <tr>
                                                    <td>{{ $team->name }}</td>
                                                    <td>{{ $team->designation }}</td>
                                                    <td>{{ $team->institution }}</td>
                                                    <td>
                                                        <img src="{{ asset($team->image) }}" alt="team-photo"
                                                            class="img-fluid rounded"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    </td>
                                                    <td>{{ $team->sequence }}</td>
                                                    <td>
                                                        <button class="btn btn-primary m-1" data-toggle="modal"
                                                            data-target="#edit-team-{{ $loop->index }}">Edit</button>
                                                        <button class="btn btn-danger m-1"
                                                            onclick="deleteSuccess({{ $team->id }})">Delete</button>
                                                    </td>
                                                    <div class="modal fade" id="edit-team-{{ $loop->index }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="editTeamLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editTeamLabel">Edit
                                                                        Team Member</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{ url('admin/contents/about-us/team/update') }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $team->id }}">
                                                                        <input type="hidden" name="type" value="team">
                                                                        <div class="form-group">
                                                                            <label for="name">Name <span
                                                                                    class="text-red">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="name" name="name"
                                                                                value="{{ $team->name }}"
                                                                                placeholder="Enter name">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="sequence">Sequence <span
                                                                                    class="text-red">*</span></label>
                                                                            <input type="number" class="form-control"
                                                                                id="sequence" name="sequence"
                                                                                value="{{ $team->sequence }}"
                                                                                placeholder="Enter sequence">
                                                                            <small class="form-text text-muted">Lower
                                                                                values indicate higher
                                                                                priority (e.g., 1 shows first).</small>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="designation">Designation <span
                                                                                    class="text-red">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="designation" name="designation"
                                                                                value="{{ $team->designation }}"
                                                                                placeholder="Enter designation">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="institution">Institution <span
                                                                                    class="text-red">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="institution" name="institution"
                                                                                value="{{ $team->institution }}"
                                                                                placeholder="Enter institution name">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="image">Image(1:1)</label>
                                                                            <input type="file" class="form-control"
                                                                                id="image" name="image"
                                                                                accept="image/*">
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

                <!-- Shariah Advisory Board Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3>Shariah Advisory Board</h3>
                                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                        data-target="#create-shariah">
                                        Add New Board Member
                                    </button>
                                </div>
                                <div class="modal fade" id="create-shariah" tabindex="-1" role="dialog"
                                    aria-labelledby="createShariahLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="createShariahLabel">Create Shariah Member</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('admin/contents/about-us/team') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="type" value="shariah">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Name <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" placeholder="Enter name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="sequence">Sequence <span
                                                                class="text-red">*</span></label>
                                                        <input type="number" class="form-control" id="sequence"
                                                            name="sequence" placeholder="Enter sequence">
                                                        <small class="form-text text-muted">Lower values indicate higher
                                                            priority (e.g., 1 shows first).</small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="designation">Designation <span
                                                                class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="designation"
                                                            name="designation" placeholder="Enter designation">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="institution">Institution <span
                                                                class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="institution"
                                                            name="institution" placeholder="Enter institution name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="image">Image(1:1) <span
                                                                class="text-red">*</span></label>
                                                        <input type="file" class="form-control" id="image"
                                                            name="image" accept="image/*">
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
                                    <table class="table table-bordered table-hover" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Designation</th>
                                                <th>Institution</th>
                                                <th>Image</th>
                                                <th>Sequence</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shariah as $member)
                                                <tr>
                                                    <td>{{ $member->name }}</td>
                                                    <td>{{ $member->designation }}</td>
                                                    <td>{{ $member->institution }}</td>
                                                    <td>
                                                        <img src="{{ asset($member->image) }}" alt="team-photo"
                                                            class="img-fluid rounded"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    </td>
                                                    <td>{{ $member->sequence }}</td>
                                                    <td>
                                                        <button class="btn btn-primary m-1" data-toggle="modal"
                                                            data-target="#edit-shariah-{{ $loop->index }}">Edit</button>
                                                        <button class="btn btn-danger m-1"
                                                            onclick="deleteSuccess({{ $member->id }})">Delete</button>
                                                    </td>
                                                    <div class="modal fade" id="edit-shariah-{{ $loop->index }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="editShariahLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editShariahLabel">Edit
                                                                        Member</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{ url('admin/contents/about-us/team/update') }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $member->id }}">
                                                                        <input type="hidden" name="type" value="shariah">
                                                                        <div class="form-group">
                                                                            <label for="name">Name <span
                                                                                    class="text-red">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="name" name="name"
                                                                                value="{{ $member->name }}"
                                                                                placeholder="Enter name">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="sequence">Sequence <span
                                                                                    class="text-red">*</span></label>
                                                                            <input type="number" class="form-control"
                                                                                id="sequence" name="sequence"
                                                                                value="{{ $member->sequence }}"
                                                                                placeholder="Enter sequence">
                                                                            <small class="form-text text-muted">Lower
                                                                                values indicate higher
                                                                                priority (e.g., 1 shows first).</small>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="designation">Designation <span
                                                                                    class="text-red">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="designation" name="designation"
                                                                                value="{{ $member->designation }}"
                                                                                placeholder="Enter designation">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="institution">Institution <span
                                                                                    class="text-red">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="institution" name="institution"
                                                                                value="{{ $member->institution }}"
                                                                                placeholder="Enter institution name">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="image">Image(1:1)</label>
                                                                            <input type="file" class="form-control"
                                                                                id="image" name="image"
                                                                                accept="image/*">
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
                        url: "{{ route('admin.contents.about-us.team.delete') }}",
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
