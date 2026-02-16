@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Organization Application</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.organization-applications.index') }}">Organization Applications</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
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
                                <form enctype="multipart/form-data"
                                    action="{{ route('admin.organization-application.store') }}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label for="organization_id">Organization <span class="text-red">*</span></label>
                                        <select class="form-control select2 @error('organization_id') is-invalid @enderror"
                                            id="organization_id" name="organization_id">
                                            @foreach ($organizations as $organization)
                                                <option value="{{ $organization->id }}"
                                                    {{ $organization->id == old('organization_id') ? 'selected' : '' }}>
                                                    {{ $organization->name }}
                                                    ({{ $organization->email ?? $organization->mobile }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('organization_id')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" value="{{ old('title') }}" name="title"
                                            placeholder="Enter title">
                                        @error('title')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            placeholder="Enter description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="requested_amount">Requested Amount <span
                                                class="text-red">*</span></label>
                                        <input type="text"
                                            class="form-control @error('requested_amount') is-invalid @enderror"
                                            id="requested_amount" value="{{ old('requested_amount') }}"
                                            name="requested_amount" placeholder="Enter requested amount">
                                        @error('requested_amount')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="completion_date">Completion Date</label>
                                        <input type="date"
                                            class="form-control @error('completion_date') is-invalid @enderror"
                                            id="completion_date" value="{{ old('completion_date') }}"
                                            name="completion_date" placeholder="Enter completion date">
                                        @error('completion_date')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Created For</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="created_for_self"
                                                    {{ old('created_for_self') == '1' ? 'checked' : '' }}
                                                    id="created_for_self" value="1">
                                                <label class="form-check-label" for="created_for_self">Self</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="created_for_self"
                                                    {{ old('created_for_self') == '0' ? 'checked' : '' }}
                                                    id="created_for_other" value="0">
                                                <label class="form-check-label" for="created_for_other">Other</label>
                                            </div>
                                        </div>
                                        @error('created_for_self')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group auth-file">
                                        <label class="form-label" for="auth_file">NID/Birth Certificate/Passport</label>
                                        <input type="file"
                                            class="form-control-file @error('auth_file') is-invalid @enderror"
                                            id="auth_file" name="auth_file">
                                        @error('auth_file')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control select2 @error('status') is-invalid @enderror"
                                            id="status" name="status">
                                            @foreach (\App\Enums\Organization\OrganizationApplicationStatus::cases() as $status)
                                                <option value="{{ $status->value }}"
                                                    {{ $status->value == old('status') ? 'selected' : '' }}>
                                                    {{ $status->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
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
        $(document).ready(function() {
            $('.auth-file').hide();
            $("input[name='created_for_self']").each(function() {
                if (this.checked && this.value === '1') {
                    $('.auth-file').hide();
                }
                if (this.checked && this.value === '0') {
                    $('.auth-file').show();
                }
            });
        });
        $("input[name='created_for_self']").on('change', function() {
            if (this.checked && this.value === '1') {
                $('.auth-file').hide();
            }
            if (this.checked && this.value === '0') {
                $('.auth-file').show();
            }
        });
    </script>
@endsection
