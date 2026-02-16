@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Seeker</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.seekers.index') }}">Seeker</a></li>
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
                                <form enctype="multipart/form-data" action="{{ route('admin.seeker.update') }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $userRequest->id }}">
                                    <input type="hidden" name="type" value="{{ $userRequest->type }}">

                                    <div class="form-group">
                                        <label for="name">Name <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ $userRequest->name }}"
                                            placeholder="Enter name">
                                        @error('name')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            id="email" value="{{ $userRequest->email }}" name="email"
                                            placeholder="Enter Email">
                                        @error('email')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                            id="mobile" value="{{ $userRequest->mobile }}" name="mobile"
                                            placeholder="Enter Mobile">
                                        @error('mobile')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    @if ($userRequest->type != 'donor')
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="division">Division <span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control signup-form-select2-division-new"
                                                        id="division" name="division">
                                                        @foreach ($divisions as $division)
                                                            <option value="{{ $division->id }}"
                                                                {{ $userRequest->upazila->district->division->id == $division->id ? 'selected' : null }}>
                                                                {{ $division->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('division')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12  col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="district">District <span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control signup-form-select2-district-new"
                                                        name="district" id="district">
                                                        <option value="{{ $userRequest->upazila->district->id ?? null }}">
                                                            {{ $userRequest->upazila->district->name }}</option>
                                                    </select>
                                                </div>
                                                @error('district')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="upazila">Upazila <span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control signup-form-select2-upazila-new"
                                                        name="upazila" id="upazila">
                                                        <option value="{{ $userRequest->upazila->id ?? null }}">
                                                            {{ $userRequest->upazila->name }}</option>
                                                    </select>
                                                </div>
                                                @error('upazila')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-6 form-group">
                                                <div class="form-group">
                                                    <label class="form-label" for="country">Country</label>
                                                    <select class="form-control signup-form-select2" id="country"
                                                        name="country">
                                                        @foreach ($countries as $country)
                                                            <option value={{ $country->id }}>{{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('country')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex flex-column">
                                            <label class="form-label" for="auth_file">NID/Birth
                                                Certificate/Passport</label>
                                            <span>Previous file: </span>
                                            <a href="{{ asset($userRequest->auth_file) }}" target="_blank"
                                                class="mb-2">NID/Birth
                                                Certificate/Passport</a>
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
                                            <label class="form-label" for="permanent_address">Permanent Address</label>
                                            <textarea type="text" class="form-control @error('permanent_address') is-invalid @enderror" id="permanent_address"
                                                name="permanent_address" placeholder="Enter your permanent address">{{ $userRequest->permanent_address }}</textarea>
                                            @error('permanent_address')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="same_present">
                                            <label class="form-check-label" for="same_present">
                                                Same as Permanent Address
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="present_address">Present Address</label>
                                            <textarea type="text" class="form-control @error('present_address') is-invalid @enderror" id="present_address"
                                                name="present_address" placeholder="Enter your present address">{{ $userRequest->present_address }}</textarea>
                                            @error('present_address')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif
                                    <div class="form-group d-flex flex-column g-3">
                                        <label class="form-label" for="profile_image">Profile Image</label>
                                        <a href="{{ asset($userRequest->photo) }}" target="_blank"
                                            class="mb-2">Previous Profile Image</a>
                                        <input type="file"
                                            class="form-control-file @error('profile_image') is-invalid @enderror"
                                            id="profile_image" name="profile_image">
                                        @error('profile_image')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="status">Status</label>
                                        <select class="form-control select2 @error('status') is-invalid @enderror"
                                            id="status" name="status">
                                            <option value="approved"
                                                {{ $userRequest->status == 'approved' ? 'selected' : '' }}>Approved
                                            </option>
                                            <option value="pending"
                                                {{ $userRequest->status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @if ($userRequest->type != 'donor')
                                        <div class="form-group">
                                            {{-- <div class="">
                      <a href="{{$userRequest->getFirstMediaUrl(\App\Enums\User\UserRequestFile::AUTH_FILE->value)}}" >1.NID/Birth Certificate/Passport</a>
                      <br>
                      <a href="{{$userRequest->getFirstMediaUrl(\App\Enums\User\UserRequestFile::PROFILE_IMG->value)}}" >2.Profile Image</a>
                    </div> --}}

                                        </div>
                                    @endif
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
        $('#same_present').change(function() {
            if (this.checked) {
                $('#present_address').val($('#permanent_address').val());
            }
        });
        // $(document).ready(function() {
        //     $('.select2').select2();
        // });
    </script>
@endsection
