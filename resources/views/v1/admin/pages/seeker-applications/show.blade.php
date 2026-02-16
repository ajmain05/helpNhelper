@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Show Seeker Application</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.seeker-applications.index') }}">Seeker
                                    Applications</a>
                            </li>
                            <li class="breadcrumb-item active">Show</li>
                        </ol>
                    </div><!-- /.col -->
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
                                {{-- <div class="row"> --}}
                                {{-- <div class="col">
                    <label for="seeker_id">Seeker</label>
                    <p>{{$seekerApplication->seeker->user->name}}
                      ({{$seekerApplication->seeker->user->email ?? $seekerApplication->seeker->user->mobile}})</p>
                  </div> --}}
                                {{-- </div> --}}
                                <div class="row">
                                    <div class="col">
                                        <label for="title">Title</label>
                                        <p>{{ $seekerApplication->title }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="description">Description</label>
                                        <p>{{ $seekerApplication->description }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="requested_amount">Requested Amount</label>
                                        <p>{{ $seekerApplication->requested_amount }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="completion_date">Completion Date</label>
                                        <p>{{ $seekerApplication->completion_date }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="created_for">Created For</label>
                                        <p>{{ $seekerApplication->created_for_self ? 'Self' : 'Other' }}</p>
                                    </div>
                                </div>
                                @if (count($seekerApplication->volunteers) > 0)
                                    <div class="row">
                                        <div class="col">
                                            <label for="created_for">Volunteer</label>
                                            <p>{{ $seekerApplication?->volunteers[0]?->name . ' (' . $seekerApplication?->volunteers[0]?->email . ') ' . $seekerApplication?->volunteers[0]?->upazila->name ?? 'No volunteer assigned.' }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col mb-2">
                                        <p class="m-0">
                                            <label for="">Investigating Document Status</label>
                                        </p>
                                        @if ($seekerApplication->volunteer_document_status == 'pending')
                                            <span
                                                class="p-1 bg-warning rounded ">{{ $seekerApplication->volunteer_document_status }}</span>
                                        @elseif ($seekerApplication->volunteer_document_status == 'approved')
                                            <span
                                                class="p-1 bg-primary rounded">{{ $seekerApplication->volunteer_document_status }}</span>
                                        @elseif ($seekerApplication->volunteer_document_status == 'declined')
                                            <span
                                                class="p-1 bg-danger rounded">{{ $seekerApplication->volunteer_document_status }}</span>
                                        @else
                                            <span class="p-1">N/A</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p class="m-0">
                                            <label for="">Investigating Document</label>
                                        </p>
                                        @if ($seekerApplication->volunteer_document == null)
                                            <p>No document submitted.</p>
                                        @else
                                            <a type="button" target="_blank"
                                                href="/{{ $seekerApplication->volunteer_document }}"
                                                class="btn btn-primary">View</a>

                                            @if ($seekerApplication->volunteer_document_status == 'pending')
                                                <a class="btn btn-primary ml-4"
                                                    onclick="confirmVolunteerDocumentSubmitAction('approved')">Approve</a>
                                                <a class="btn btn-danger"
                                                    onclick="confirmVolunteerDocumentSubmitAction('declined')">Decline</a>
                                            @endif


                                            <div class="row mt-1">
                                                <div class="col">
                                                    <label for="completion_date">Comment</label>
                                                    <p class="m-0">{{ $seekerApplication->comment ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <p class="m-0">
                                            <label for="">Document</label>
                                        </p>
                                        @if ($seekerApplication->document == null)
                                            <p>No document submitted.</p>
                                        @else
                                            <a type="button" target="_blank" href="/{{ $seekerApplication->document }}"
                                                class="btn btn-primary">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="m-0">
                                            <label for="">Image</label>
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        @if ($seekerApplication->image)
                                            <img src="{{ asset($seekerApplication->image) }}" alt=""
                                                style="margin: 5px; width:100%; max-width:300px">
                                        @else
                                            <p>N/A</p>
                                        @endif
                                    </div>
                                </div>

                                @if ($seekerApplication->status != \App\Enums\Seeker\SeekerApplicationStatus::PENDING->value)
                                    <div class="row mt-2">
                                        <div class="col">
                                            <label for="status">Status</label>
                                            <p>
                                                <span
                                                    class="badge badge-{{ $seekerApplication->status == \App\Enums\Seeker\SeekerApplicationStatus::APPROVED->value ? 'success' : 'danger' }}">
                                                    {{ $seekerApplication->status }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            {{-- @if (!$seekerApplication->created_for_self)
                  <div class="row">
                    <div class="col">
                      <label class="form-label" for="files">Files</label>
                      <p class="">
                        <a href="{{$seekerApplication->getFirstMediaUrl(\App\Enums\Seeker\SeekerApplicationFile::AUTH_FILE->value ?? '#')}}" >1.NID/Birth Certificate/Passport</a>
                      </p>
                    </div>
                  </div>
                @endif --}}
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.seeker-application.edit', $seekerApplication->id) }}"
                                class="btn btn-primary">Edit</a>
                            @if ($seekerApplication->status == \App\Enums\Seeker\SeekerApplicationStatus::PENDING->value)
                                <a href="{{ route('admin.seeker-application.update.status', [
                                    \App\Enums\Seeker\SeekerApplicationStatus::APPROVED->value,
                                    $seekerApplication->id,
                                ]) }}"
                                    class="btn btn-success mx-2">Approve</a>
                                <a href="{{ route('admin.seeker-application.update.status', [
                                    \App\Enums\Seeker\SeekerApplicationStatus::REJECTED->value,
                                    $seekerApplication->id,
                                ]) }}"
                                    class="btn btn-danger mx-2">Reject</a>
                            @endif

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
        function confirmVolunteerDocumentSubmitAction(action) {
            Swal.fire({
                title: `Are you sure you want to ${action} this?`,
                text: "You won't be able to revert this! " + (action === 'declined' ?
                    "You will no longer be able to see the document." :
                    ""),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.seeker-application.update.volunteer-document-status') }}",
                        type: 'post',
                        data: {
                            id: '{{ $seekerApplication->id }}',
                            status: action,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            Swal.fire(
                                'Success!',
                                data.message,
                                'success'
                            ).then(() => {
                                window.location.reload()
                            });
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error!',
                                "Failed to update status, please try again later.",
                                'error'
                            )
                        }
                    });
                } else {
                    // Swal.fire('Cancelled', 'Operation Cancelled', 'error');
                }
            });
        }
    </script>
@endsection
