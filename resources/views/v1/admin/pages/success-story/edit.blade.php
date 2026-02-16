@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Success Story</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.success') }}">Success Story</a>
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
                                <form enctype="multipart/form-data" action="{{ route('admin.success.update') }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $successStory->id }}">

                                    <div class="form-group">
                                        <label for="campaign_id">Campaign<span class="text-red">*</span></label>
                                        <select class="form-control select2 @error('campaign_id') is-invalid @enderror"
                                            id="campaign_id" name="campaign_id">
                                            @foreach ($campaigns as $campaign)
                                                <option value="{{ $campaign->id }}"
                                                    {{ $campaign->id == old('campaign_id') || $successStory->campaign->id == $campaign->id ? 'selected' : '' }}>
                                                    {{ $campaign->title }} </option>
                                            @endforeach
                                        </select>
                                        @error('campaign_id')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="title">Title <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" value="{{ $successStory->title }}" name="title"
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
                                            id="title_bn" value="{{ $successStory->title_bn }}" name="title_bn"
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
                                            id="title_ar" value="{{ $successStory->title_ar }}" name="title_ar"
                                            placeholder="Enter title in Arabic">
                                        @error('title_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description">Short Description <span
                                                class="text-red">*</span></label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                            name="short_description" placeholder="Enter short description">{{ $successStory->short_description }}</textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description_bn">Short Description (Bangla)</label>
                                        <textarea class="form-control @error('short_description_bn') is-invalid @enderror" id="short_description_bn"
                                            name="short_description_bn" placeholder="Enter short description in Bangla">{{ $successStory->short_description_bn }}</textarea>
                                        @error('short_description_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description_ar">Short Description (Arabic)</label>
                                        <textarea class="form-control @error('short_description_ar') is-invalid @enderror" id="short_description_ar"
                                            name="short_description_ar" placeholder="Enter short description in Arabic">{{ $successStory->short_description_ar }}</textarea>
                                        @error('short_description_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="long_description">Long Description <span
                                                class="text-red">*</span></label>
                                        <textarea class="form-control @error('long_description') is-invalid @enderror" id="long_description"
                                            name="long_description" placeholder="Enter long description">{{ $successStory->long_description }}</textarea>
                                        @error('long_description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="long_description_bn">Long Description (Bangla)</label>
                                        <textarea class="form-control @error('long_description_bn') is-invalid @enderror" id="long_description_bn"
                                            name="long_description_bn" placeholder="Enter long description in Bangla">{{ $successStory->long_description_bn }}</textarea>
                                        @error('long_description_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="long_description_ar">Long Description (Arabic)</label>
                                        <textarea class="form-control @error('long_description_ar') is-invalid @enderror" id="long_description_ar"
                                            name="long_description_ar" placeholder="Enter long description in Arabic">{{ $successStory->long_description_ar }}</textarea>
                                        @error('long_description_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="image">Cover photo</label>
                                        <div class="">
                                            <img src="{{ $successStory->photo }}" alt="" class="rounded"
                                                style="height: 150px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="image">Update Cover photo</label>
                                        <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                                            id="image" name="photo" accept="image/*">
                                        @error('image')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="image">Previous Condition Image</label>
                                        <div class="">
                                            <img src="{{ $successStory->previous_condition }}" alt=""
                                                class="rounded" style="height: 150px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="previous_condition">Update Previous Condition
                                            Image</label>
                                        <input type="file"
                                            class="form-control-file @error('previous_condition') is-invalid @enderror"
                                            id="previous_condition" name="previous_condition" accept="image/*">
                                        @error('previous_condition')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="image">Present Condition Image</label>
                                        <div class="">
                                            <img src="{{ $successStory->present_condition }}" alt=""
                                                class="rounded" style="height: 150px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="image">Update Present Condition Image</label>
                                        <input type="file"
                                            class="form-control-file @error('present_condition') is-invalid @enderror"
                                            id="present_condition" name="present_condition" accept="image/*">
                                        @error('present_condition')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
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
            $('.select2').select2();
        });
    </script>
@endsection
