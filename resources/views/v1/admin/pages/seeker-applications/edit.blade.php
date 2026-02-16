@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Seeker Application</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.seeker-applications.index') }}">Seeker
                                    Applications</a>
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
                                <form enctype="multipart/form-data" action="{{ route('admin.seeker-application.update') }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $seekerApplication->id }}">

                                    {{-- <div class="form-group">
                    <label for="seeker_id">Seeker <span class="text-red">*</span></label>
                    <select class="form-control select2 @error('seeker_id') is-invalid @enderror" id="seeker_id"
                            name="seeker_id">
                      @foreach ($seekers as $seeker)
                        <option
                          value="{{$seeker->id}}" {{$seeker->id == $seekerApplication->seeker_id ? 'selected' : ''}}>{{$seeker->user->name}}
                          ({{$seeker->user->email ?? $seeker->user->mobile}})
                        </option>
                      @endforeach
                    </select>
                    @error('seeker_id')
                    <span class="invalid-feedback">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div> --}}
                                    <div class="form-group">
                                        <label for="title">Seeker <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title"
                                            value="{{ $seekerApplication->user->name }} ({{ $seekerApplication->user->email }}) {{ $seekerApplication->user->upazila->name }}"
                                            disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" value="{{ $seekerApplication->title }}" name="title"
                                            placeholder="Enter title">
                                        @error('title')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title_bn">Title (Bangla)</label>
                                        <input type="text" class="form-control @error('title_bn') is-invalid @enderror"
                                            id="title_bn" value="{{ $seekerApplication->title_bn }}" name="title_bn"
                                            placeholder="Enter title in Bangla">
                                        @error('title_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title_ar">Title (Arabic)</label>
                                        <input type="text" class="form-control @error('title_ar') is-invalid @enderror"
                                            id="title_ar" value="{{ $seekerApplication->title_ar }}" name="title_ar"
                                            placeholder="Enter title in Arabic">
                                        @error('title_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description <span class="text-red">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            placeholder="Enter description">{{ $seekerApplication->description }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description_bn">Description (Bangla)</label>
                                        <textarea class="form-control @error('description_bn') is-invalid @enderror" id="description_bn" name="description_bn"
                                            placeholder="Enter description in Bangla">{{ $seekerApplication->description_bn }}</textarea>
                                        @error('description_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description_ar">Description (Arabic)</label>
                                        <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar"
                                            placeholder="Enter description in Arabic">{{ $seekerApplication->description_ar }}</textarea>
                                        @error('description_ar')
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
                                            id="requested_amount" value="{{ $seekerApplication->requested_amount }}"
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
                                            id="completion_date" value="{{ $seekerApplication->completion_date }}"
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
                        <input class="form-check-input" type="radio" name="created_for_self" {{$seekerApplication->created_for_self ? 'checked' : ''}} id="created_for_self" value="1">
                        <label class="form-check-label" for="created_for_self">Self</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="created_for_self" {{!$seekerApplication->created_for_self ? 'checked' : ''}} id="created_for_other" value="0">
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
                                            @foreach (\App\Enums\Seeker\SeekerApplicationStatus::cases() as $status)
                                                <option value="{{ $status->value }}"
                                                    {{ $status->value == $seekerApplication->status ? 'selected' : '' }}>
                                                    {{ $status->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
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
                                    <div class="w-100">
                                        <label for="">Comment</label>
                                        <textarea name="comment" placeholder="Add your comment here..." class="w-100 mt-1 w-full p-2 border rounded">{{ $seekerApplication->comment }}</textarea>
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
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="volunteer_id" class="text-dark">Volunteer <span
                                                    class="text-danger">*</span>
                                                @php
                                                    $volunteer = $seekerApplication->volunteers[0] ?? null;
                                                    $volunteerInfo = $volunteer
                                                        ? "{$volunteer->name} ({$volunteer->email}) " .
                                                            ($volunteer->upazila->name ?? '')
                                                        : '(No volunteer assigned)';
                                                @endphp
                                                {{ $volunteerInfo }}
                                            </label>
                                            <label for="all_volunteer"
                                                class="d-flex align-items-center gap-2 cursor-pointer">
                                                <span>All Volunteer</span>
                                                <input type="checkbox" id="all_volunteer" class="form-check-input">
                                            </label>
                                        </div>
                                        <select
                                            class="form-control volunteer-select2 @error('volunteer_id') is-invalid @enderror"
                                            id="volunteer_id" name="volunteer_id"
                                            @if ($seekerApplication->user_id != null && $seekerApplication->status == 'approved') disabled @endif>
                                            @forelse ($volunteers as $volunteer)
                                                @if ($loop->first)
                                                    <option value="">--Select--</option>
                                                @endif
                                                <option value="{{ $volunteer->id }}"
                                                    @if (
                                                        $seekerApplication->volunteers != null &&
                                                            sizeof($seekerApplication->volunteers) &&
                                                            $volunteer->id == $seekerApplication->volunteers[0]->id) selected @endif>
                                                    {{ $volunteer->name }} ({{ $volunteer->email ?? $volunteer->mobile }})
                                                    {{ $volunteer->upazila->name }} (Total Ratings:
                                                    {{ $volunteer->total_score ?? 0 }})
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
                                    {{-- @if ($seekerApplication->getMedia())
                    <div class="form-group">
                      <label class="form-label" for="files">Previous Files</label>
                      <div class="">
                        <a href="{{$seekerApplication->getFirstMediaUrl(\App\Enums\Seeker\SeekerApplicationFile::AUTH_FILE->value ?? '#')}}" >1.NID/Birth Certificate/Passport</a>
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
            $('#all_volunteer').change(function() {
                if ($(this).is(':checked')) {
                    $.ajax({
                        url: "{{ url('admin/users/dropdown?type=volunteer') }}",
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            if (response.data.length > 0) {
                                let options = '<option value="">--Select--</option>';
                                response.data.forEach(function(user) {
                                    let label = `${user.name} (${user.email})`;
                                    if (user.upazila_name) {
                                        label += `-${user.upazila_name}`;
                                    }
                                    label +=
                                        `-(Total Ratings: ${user.total_score || 0})`;

                                    options +=
                                        `<option value="${user.id}">${label}</option>`;
                                });
                                $('#volunteer_id').html(options);
                            }
                        }
                    });
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
