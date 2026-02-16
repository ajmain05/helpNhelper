@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Campaign</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.campaigns.index') }}">Campaigns</a></li>
                            <li class="breadcrumb-item active">Create</li>
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
                                <form enctype="multipart/form-data" action="{{ route('admin.campaign.store') }}"
                                    method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label for="seeker_application_id">Seeker Application <span
                                                class="text-red">*</span></label>
                                        <select
                                            class="form-control select2 @error('seeker_application_id') is-invalid @enderror"
                                            id="seeker_application_id" name="seeker_application_id">
                                            @foreach ($applications as $application)
                                                <option value="{{ $application->id }}"
                                                    @if ($application->id == old('seeker_application_id')) selected @endif>
                                                    {{ $application->title }} </option>
                                            @endforeach
                                        </select>
                                        @error('seeker_application_id')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="category_id">Campaign Category <span class="text-red">*</span></label>
                                        <select class="form-control select2 @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if ($category->id == old('category_id')) selected @endif>
                                                    {{ $category->title }} </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title (English) <span class="text-red">*</span></label>
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
                                        <label for="title_bn">Title (Bangla)</label>
                                        <input type="text" class="form-control @error('title_bn') is-invalid @enderror"
                                            id="title_bn" value="{{ old('title_bn') }}" name="title_bn"
                                            placeholder="Enter title (Bangla)">
                                        @error('title_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title_ar">Title (Arabic)</label>
                                        <input type="text" class="form-control @error('title_ar') is-invalid @enderror"
                                            id="title_ar" value="{{ old('title_ar') }}" name="title_ar"
                                            placeholder="Enter title (Arabic)">
                                        @error('title_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description">Short Description (English) <span
                                                class="text-red">*</span></label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                            name="short_description" placeholder="Enter short description">{{ old('short_description') }}</textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description_bn">Short Description (Bangla)</label>
                                        <textarea class="form-control @error('short_description_bn') is-invalid @enderror" id="short_description_bn"
                                            name="short_description_bn" placeholder="Enter short description (Bangla)">{{ old('short_description_bn') }}</textarea>
                                        @error('short_description_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description_ar">Short Description (Arabic)</label>
                                        <textarea class="form-control @error('short_description_ar') is-invalid @enderror" id="short_description_ar"
                                            name="short_description_ar" placeholder="Enter short description (Arabic)">{{ old('short_description_ar') }}</textarea>
                                        @error('short_description_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="long_description">Long Description (English) <span
                                                class="text-red">*</span></label>
                                        <textarea class="form-control @error('long_description') is-invalid @enderror" id="long_description"
                                            name="long_description" placeholder="Enter long description">{{ old('long_description') }}</textarea>
                                        @error('long_description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="long_description_bn">Long Description (Bangla)</label>
                                        <textarea class="form-control @error('long_description_bn') is-invalid @enderror" id="long_description_bn"
                                            name="long_description_bn" placeholder="Enter long description (Bangla)">{{ old('long_description_bn') }}</textarea>
                                        @error('long_description_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="long_description_ar">Long Description (Arabic)</label>
                                        <textarea class="form-control @error('long_description_ar') is-invalid @enderror" id="long_description_ar"
                                            name="long_description_ar" placeholder="Enter long description (Arabic)">{{ old('long_description_ar') }}</textarea>
                                        @error('long_description_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount (English) <span class="text-red">*</span></label>
                                        <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                            id="amount" value="{{ old('amount') }}" name="amount"
                                            placeholder="Enter amount">
                                        @error('amount')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="amount_bn">Amount (Bangla)</label>
                                        <input type="text" class="form-control @error('amount_bn') is-invalid @enderror"
                                            id="amount_bn" value="{{ old('amount_bn') }}" name="amount_bn"
                                            placeholder="Enter amount (Bangla)">
                                        @error('amount_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="amount_ar">Amount (Arabic)</label>
                                        <input type="text" class="form-control @error('amount_ar') is-invalid @enderror"
                                            id="amount_ar" value="{{ old('amount_ar') }}" name="amount_ar"
                                            placeholder="Enter amount (Arabic)">
                                        @error('amount_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="terms">Terms (English) <span class="text-red">*</span></label>
                                        <textarea class="form-control @error('terms') is-invalid @enderror" id="terms" name="terms"
                                            placeholder="Enter terms">{{ old('terms') }}</textarea>
                                        @error('terms')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="terms_bn">Terms (Bangla)</label>
                                        <textarea class="form-control @error('terms_bn') is-invalid @enderror" id="terms_bn" name="terms_bn"
                                            placeholder="Enter terms (Bangla)">{{ old('terms_bn') }}</textarea>
                                        @error('terms_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="terms_ar">Terms (Arabic)</label>
                                        <textarea class="form-control @error('terms_ar') is-invalid @enderror" id="terms_ar" name="terms_ar"
                                            placeholder="Enter terms (Arabic)">{{ old('terms_ar') }}</textarea>
                                        @error('terms_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label class="form-label" for="photo">Photo</label>
                                            <input type="file"
                                                class="form-control-file @error('photos') is-invalid @enderror"
                                                id="photos" name="photos[]" accept="image/*" multiple>
                                            @error('photos')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                name="is_featured" value="1">
                                            <label class="form-check-label" for="inlineCheckbox3">Featured Campaign</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-red">*</span></label>
                                        <select class="form-control select2 @error('status') is-invalid @enderror"
                                            id="status" name="status">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}"
                                                    @if ($status == old('status')) selected @endif>
                                                    {{ $status }} </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
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
