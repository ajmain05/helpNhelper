@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit {{ $userRequestType }} Request</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.user-requests.index', $type . 's') }}">{{ $userRequestType }}
                                    Requests</a>
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
                                <form enctype="multipart/form-data" action="{{ route('admin.user-request.update') }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $userRequest->id }}">

                                    <div class="form-group">
                                        <label for="type">Type <span class="text-red">*</span></label>
                                        <select class="form-control select2 @error('type') is-invalid @enderror"
                                            id="type" name="type">
                                            <option value="volunteer"
                                                {{ $userRequest->type == 'volunteer' ? 'selected' : '' }}>Volunteer
                                            </option>
                                            <option value="seeker" {{ $userRequest->type == 'seeker' ? 'selected' : '' }}>
                                                Seeker</option>
                                            <option value="corporate-donor"
                                                {{ $userRequest->type == 'corporate-donor' ? 'selected' : '' }}>
                                                Corporate Donor</option>
                                            <option value="donor" {{ $userRequest->type == 'donor' ? 'selected' : '' }}>
                                                Donor</option>
                                            <option value="organization"
                                                {{ $userRequest->type == 'organization' ? 'selected' : '' }}>
                                                Organization</option>
                                        </select>
                                        @error('type')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
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
                                    @if ($userRequest->type == 'volunteer')
                                        <div class="form-group">
                                            <label for="fb_link">Facebook Profile Link</label>
                                            <input type="text"
                                                class="form-control @error('fb_link') is-invalid @enderror" id="fb_link"
                                                value="{{ $userRequest->fb_link }}" name="fb_link"
                                                placeholder="Enter Fb Link">
                                            @error('fb_link')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif
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
                                                        <option class="{{ $userRequest->upazila->district->id ?? null }}">
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
                                        @if ($userRequest->type == 'organization')
                                            <div class="form-group">
                                                <label class="form-label" for="org_reg_type">Organization Registration Type</label>
                                                <select class="form-control" id="org_reg_type" name="org_reg_type">
                                                    <option value="registered" {{ $userRequest->org_reg_type == 'registered' ? 'selected' : '' }}>Registered</option>
                                                    <option value="unregistered" {{ $userRequest->org_reg_type == 'unregistered' ? 'selected' : '' }}>Unregistered</option>
                                                </select>
                                                @error('org_reg_type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div id="registered_fields" style="display: {{ $userRequest->org_reg_type == 'registered' || !$userRequest->org_reg_type ? 'block' : 'none' }};">
                                                <div class="form-group">
                                                    <label class="form-label" for="reg_body">Registration Body</label>
                                                    <input type="text" class="form-control" id="reg_body" name="reg_body" value="{{ $userRequest->reg_body }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="reg_no">Registration Number</label>
                                                    <input type="text" class="form-control" id="reg_no" name="reg_no" value="{{ $userRequest->reg_no }}">
                                                </div>
                                                <div class="form-group d-flex flex-column">
                                                    <label class="form-label" for="cert_image">Registration Certificate Image/PDF</label>
                                                    @if($userRequest->cert_image)
                                                        <a href="{{ asset($userRequest->cert_image) }}" target="_blank" class="mb-2">View Existing Certificate</a>
                                                    @endif
                                                    <input type="file" class="form-control-file" id="cert_image" name="cert_image" accept=".jpg,.jpeg,.png,.pdf">
                                                </div>
                                            </div>

                                            <div id="unregistered_fields" style="display: {{ $userRequest->org_reg_type == 'unregistered' ? 'block' : 'none' }};">
                                                <div class="form-group">
                                                    <label class="form-label" for="years_of_op">Years of Operation</label>
                                                    <input type="text" class="form-control" id="years_of_op" name="years_of_op" value="{{ $userRequest->years_of_op }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="beneficiaries_count">Number of Beneficiaries</label>
                                                    <input type="text" class="form-control" id="beneficiaries_count" name="beneficiaries_count" value="{{ $userRequest->beneficiaries_count }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="working_sectors">Working Sectors</label>
                                                    <input type="text" class="form-control" id="working_sectors" name="working_sectors" value="{{ $userRequest->working_sectors }}" placeholder="e.g. Education, Health (comma separated)">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label" for="office_address">Office Address</label>
                                                <textarea type="text" class="form-control @error('office_address') is-invalid @enderror" id="office_address"
                                                    name="office_address" placeholder="Enter your office address">{{ $userRequest->office_address }}</textarea>
                                                @error('office_address')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label class="form-label" for="permanent_address">Permanent
                                                    Address</label>
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
                                                <label class="form-label" for="present_address">Present
                                                    Address</label>
                                                <textarea type="text" class="form-control @error('present_address') is-invalid @enderror" id="present_address"
                                                    name="present_address" placeholder="Enter your present address">{{ $userRequest->present_address }}</textarea>
                                                @error('present_address')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endif
                                    @endif
                                    @if ($userRequest->type != 'donor' && $userRequest->type != 'corporate-donor')
                                        <div class="form-group d-flex flex-column g-3">
                                            <label class="form-label" for="photo">Profile Image</label>
                                            <a href="{{ asset($userRequest->photo) }}" target="_blank"
                                                class="mb-2">Previous Profile Image</a>
                                            <input type="file"
                                                class="form-control-file @error('photo') is-invalid @enderror"
                                                id="photo" name="photo">
                                            @error('photo')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif
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
        
        $('#org_reg_type').change(function() {
            if ($(this).val() === 'registered') {
                $('#registered_fields').show();
                $('#unregistered_fields').hide();
            } else if ($(this).val() === 'unregistered') {
                $('#registered_fields').hide();
                $('#unregistered_fields').show();
            }
        });
    </script>
@endsection
