@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Organization Application</h1>
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
                                    action="{{ route('admin.organization-application.update') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $organizationApplication->id }}">

                                    {{-- <div class="form-group">
                    <label for="organization_id">Seeker <span class="text-red">*</span></label>
                    <select class="form-control select2 @error('organization_id') is-invalid @enderror" id="organization_id"
                            name="organization_id">
                      @foreach ($seekers as $seeker)
                        <option
                          value="{{$seeker->id}}" {{$seeker->id == $organizationApplication->organization_id ? 'selected' : ''}}>{{$seeker->user->name}}
                          ({{$seeker->user->email ?? $seeker->user->mobile}})
                        </option>
                      @endforeach
                    </select>
                    @error('organization_id')
                    <span class="invalid-feedback">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div> --}}
                                    <div class="form-group">
                                        <label for="title">Organization <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" value="{{ $organizationApplication->user->name }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" value="{{ $organizationApplication->title }}" name="title"
                                            placeholder="Enter title">
                                        @error('title')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description <span class="text-red">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            placeholder="Enter description">{{ $organizationApplication->description }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="requested_amount">Requested Amount <span
                                                class="text-red">*</span></label>
                                        <input type="number"
                                            class="form-control @error('requested_amount') is-invalid @enderror"
                                            id="requested_amount" value="{{ $organizationApplication->requested_amount }}"
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
                                            id="completion_date" value="{{ $organizationApplication->completion_date }}"
                                            name="completion_date" placeholder="Enter completion date">
                                        @error('completion_date')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group">
                    <label >Created For</label>
                    <div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="created_for_self" {{$organizationApplication->created_for_self ? 'checked' : ''}} id="created_for_self" value="1">
                        <label class="form-check-label" for="created_for_self">Self</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="created_for_self" {{!$organizationApplication->created_for_self ? 'checked' : ''}} id="created_for_other" value="0">
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
                    <input type="file"  class="form-control-file @error('auth_file') is-invalid @enderror"
                           id="auth_file" name="auth_file">
                    @error('auth_file')
                    <span class="invalid-feedback">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div> --}}
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control select2 @error('status') is-invalid @enderror"
                                            id="status" name="status">
                                            @foreach (\App\Enums\Organization\OrganizationApplicationStatus::cases() as $status)
                                                <option value="{{ $status->value }}"
                                                    {{ $status->value == $organizationApplication->status ? 'selected' : '' }}>
                                                    {{ $status->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="row col-12">
                                        <div class="form-group">
                                            <label for="status">Search Volunteer based on location</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="division">Division <span
                                                        class="text-red">*</span></label>
                                                <select class="form-control signup-form-select2-division-new" id="division"
                                                    name="division">
                                                    @foreach ($divisions as $division)
                                                        <option value="{{ $division->id }}">
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
                                                    @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}">
                                                            {{ $district->name }}</option>
                                                    @endforeach
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
                                                    @foreach ($upazilas as $upazila)
                                                        <option value="{{ $upazila->id }}">
                                                            {{ $upazila->name }}</option>
                                                    @endforeach
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
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label for="document">Document</label>
                                                <input type="file"
                                                    class="form-control-file @error('document') is-invalid @enderror""
                                                    id="document" name="document">
                                                @error('document')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label for="image">Image</label>
                                                <input type="file"
                                                    class="form-control-file @error('image') is-invalid @enderror"
                                                    id="image" name="image">
                                                @error('image')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="volunteer_id">Volunteer <span class="text-red">*</span></label>
                                        <select
                                            class="form-control volunteer-select2 @error('volunteer_id') is-invalid @enderror"
                                            id="volunteer_id" name="volunteer_id"
                                            @if ($organizationApplication->user_id != null && $organizationApplication->status == 'approved') disabled @endif>
                                            @forelse ($volunteers as $volunteer)
                                                @if ($loop->first)
                                                    <option value="">--Select--</option>
                                                @endif
                                                <option value="{{ $volunteer->id }}"
                                                    @if (
                                                        $organizationApplication->volunteers != null &&
                                                            sizeof($organizationApplication->volunteers) &&
                                                            $volunteer->id == $organizationApplication->volunteers[0]->id) selected @endif>
                                                    {{ $volunteer->name }} ({{ $volunteer->email ?? $volunteer->mobile }})
                                                    {{ $volunteer->upazila->name }}
                                                </option>
                                            @empty
                                                <option value="">No volunteers found</option>
                                            @endforelse
                                        </select>
                                        @error('volunteer_id')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- @if ($organizationApplication->getMedia())
                    <div class="form-group">
                      <label class="form-label" for="files">Previous Files</label>
                      <div class="">
                        <a href="{{$organizationApplication->getFirstMediaUrl(\App\Enums\Seeker\SeekerApplicationFile::AUTH_FILE->value ?? '#')}}" >1.NID/Birth Certificate/Passport</a>
                      </div>
                    </div>
                  @endif --}}
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
