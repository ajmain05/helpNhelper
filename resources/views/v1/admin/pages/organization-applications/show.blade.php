@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Show Organization Application</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.organization-applications.index') }}">Organization
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
                                <div class="row">
                                    {{-- <div class="col">
                    <label for="seeker_id">Organization</label>
                    <p>{{$organizationApplication->Organization->user->name}}
                      ({{$organizationApplication->Organization->user->email ?? $organizationApplication->Organization->user->mobile}})</p>
                  </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="title">Title</label>
                                        <p>{{ $organizationApplication->title }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="description">Description</label>
                                        <p>{{ $organizationApplication->description }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="requested_amount">Requested Amount</label>
                                        <p>{{ $organizationApplication->requested_amount }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="completion_date">Completion Date</label>
                                        <p>{{ $organizationApplication->completion_date }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="created_for">Created for</label>
                                        <p>{{ $organizationApplication->created_for_self ? 'Self' : 'Other' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="created_for">Volunteer</label>
                                        <p>{{ $organizationApplication?->volunteers[0]?->name ?? 'No volunteer assigned.' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p class="m-0">
                                            <label for="">Investigating Document</label>
                                        </p>
                                        @if ($organizationApplication->volunteer_document == null)
                                            <p>No document submitted.</p>
                                        @else
                                            <a type="button" target="_blank"
                                                href="/{{ $organizationApplication->volunteer_document }}"
                                                class="btn btn-primary">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p class="m-0">
                                            <label for="">Document</label>
                                        </p>
                                        @if ($organizationApplication->document == null)
                                            <p>No document submitted.</p>
                                        @else
                                            <a type="button" target="_blank"
                                                href="/{{ $organizationApplication->document }}"
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
                                        @if ($organizationApplication->image)
                                            <img src="{{ asset($organizationApplication->image) }}" alt=""
                                                style="margin: 5px; width:100%; max-width:300px">
                                        @else
                                            <p>N/A</p>
                                        @endif
                                    </div>
                                </div>
                                @if ($organizationApplication->status != \App\Enums\Organization\OrganizationApplicationStatus::PENDING->value)
                                    <div class="row">
                                        <div class="col">
                                            <label for="status">Status</label>
                                            <p>
                                                <span
                                                    class="badge badge-{{ $organizationApplication->status == \App\Enums\Organization\OrganizationApplicationStatus::APPROVED->value ? 'success' : 'danger' }}">
                                                    {{ $organizationApplication->status }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            {{-- @if (!$organizationApplication->created_for_self)
                  <div class="row">
                    <div class="col">
                      <label class="form-label" for="files">Files</label>
                      <p class="">
                        <a href="{{$organizationApplication->getFirstMediaUrl(\App\Enums\Organization\OrganizationApplicationFile::AUTH_FILE->value ?? '#')}}" >1.NID/Birth Certificate/Passport</a>
                      </p>
                    </div>
                  </div>
                @endif --}}
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.organization-application.edit', $organizationApplication->id) }}"
                                class="btn btn-primary">Edit</a>
                            @if ($organizationApplication->status == \App\Enums\Organization\OrganizationApplicationStatus::PENDING->value)
                                <a href="{{ route('admin.organization-application.update.status', [
                                    \App\Enums\Organization\OrganizationApplicationStatus::APPROVED->value,
                                    $organizationApplication->id,
                                ]) }}"
                                    class="btn btn-success mx-2">Approve</a>
                                <a href="{{ route('admin.organization-application.update.status', [
                                    \App\Enums\Organization\OrganizationApplicationStatus::REJECTED->value,
                                    $organizationApplication->id,
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
