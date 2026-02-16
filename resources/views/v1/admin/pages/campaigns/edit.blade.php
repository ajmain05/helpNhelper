@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Campaign</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.campaigns.index') }}">Campaigns</a>
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
                                <form enctype="multipart/form-data" action="{{ route('admin.campaign.update') }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $campaign->id }}">

                                    <div class="form-group">
                                        <label for="seeker_application_id">Seeker Application <span
                                                class="text-red">*</span></label>
                                        <select
                                            class="form-control select2 @error('seeker_application_id') is-invalid @enderror"
                                            id="seeker_application_id" name="seeker_application_id">
                                            @foreach ($applications as $application)
                                                <option value="{{ $application->id }}"
                                                    {{ $application->id == $campaign->seeker_application_id ? 'selected' : '' }}>
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
                                                    {{ $category->id == $campaign->category_id ? 'selected' : '' }}>
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
                                            id="title" value="{{ $campaign->title }}" name="title"
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
                                            id="title_bn" value="{{ $campaign->title_bn }}" name="title_bn"
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
                                            id="title_ar" value="{{ $campaign->title_ar }}" name="title_ar"
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
                                            name="short_description" placeholder="Enter short description">{{ $campaign->short_description }}</textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description_bn">Short Description (Bangla)</label>
                                        <textarea class="form-control @error('short_description_bn') is-invalid @enderror" id="short_description_bn"
                                            name="short_description_bn" placeholder="Enter short description (Bangla)">{{ $campaign->short_description_bn }}</textarea>
                                        @error('short_description_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description_ar">Short Description (Arabic)</label>
                                        <textarea class="form-control @error('short_description_ar') is-invalid @enderror" id="short_description_ar"
                                            name="short_description_ar" placeholder="Enter short description (Arabic)">{{ $campaign->short_description_ar }}</textarea>
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
                                            name="long_description" placeholder="Enter long description">{{ $campaign->long_description }}</textarea>
                                        @error('long_description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="long_description_bn">Long Description (Bangla)</label>
                                        <textarea class="form-control @error('long_description_bn') is-invalid @enderror" id="long_description_bn"
                                            name="long_description_bn" placeholder="Enter long description (Bangla)">{{ $campaign->long_description_bn }}</textarea>
                                        @error('long_description_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="long_description_ar">Long Description (Arabic)</label>
                                        <textarea class="form-control @error('long_description_ar') is-invalid @enderror" id="long_description_ar"
                                            name="long_description_ar" placeholder="Enter long description (Arabic)">{{ $campaign->long_description_ar }}</textarea>
                                        @error('long_description_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount (English) <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('amount') is-invalid @enderror"
                                            id="amount" value="{{ $campaign->amount }}" name="amount"
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
                                            id="amount_bn" value="{{ $campaign->amount_bn }}" name="amount_bn"
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
                                            id="amount_ar" value="{{ $campaign->amount_ar }}" name="amount_ar"
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
                                            placeholder="Enter terms">{{ $campaign->terms }}</textarea>
                                        @error('terms')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="terms_bn">Terms (Bangla)</label>
                                        <textarea class="form-control @error('terms_bn') is-invalid @enderror" id="terms_bn" name="terms_bn"
                                            placeholder="Enter terms (Bangla)">{{ $campaign->terms_bn }}</textarea>
                                        @error('terms_bn')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="terms_ar">Terms (Arabic)</label>
                                        <textarea class="form-control @error('terms_ar') is-invalid @enderror" id="terms_ar" name="terms_ar"
                                            placeholder="Enter terms (Arabic)">{{ $campaign->terms_ar }}</textarea>
                                        @error('terms_ar')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Thumbnail
                                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                                id="photo" name="photo" accept="image/*">
                                            @error('photo')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        @if ($campaign->photo)
                                            <span class="text-sm text-info">Thumbnail preview</span>
                                            <div class="d-flex flex-wrap p-2 rounded" style="gap:20px;">
                                                <div class="d-flex" style="max-width: 150px; position: relative;">
                                                    <img style="object-fit: contain;" src="{{ asset($campaign->photo) }}"
                                                        alt="Campaign Photo">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- <div class="form-group">
                                        <label class="form-label" for="images">Images</label>
                                        <input type="file" multiple
                                            class="form-control-file @error('images') is-invalid @enderror" id="images"
                                            name="images[]">
                                        @error('images')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}
                                    {{-- <div class="form-group">
                                        <label class="form-label" for="images">Images</label>
                                        <input type="file" multiple
                                            class="form-control-file @error('images') is-invalid @enderror" id="images"
                                            name="images[]">
                                        @error('images')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group">
                                        <label class="form-label" for="images">
                                            Gallery <span class="text-sm text-info">(Select photos and click "Submit" to
                                                add to the gallery)</span>
                                        </label>

                                        <input type="file" class="form-control-file" id="images" name="images[]"
                                            multiple>
                                        @error('images')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <span class="text-sm text-info">Galleries</span>
                                        @if (!$campaign->images->isEmpty())
                                            <div class="d-flex flex-wrap border border-secondary p-2 rounded"
                                                style="gap:20px;">
                                                @foreach ($campaign->images as $image)
                                                    <div class="d-flex" style="max-width: 150px; position: relative;">
                                                        <img style="object-fit: contain;"
                                                            src="{{ asset($image->image) }}" alt="Campaign Image">
                                                        <a href="{{ route('admin.campaign.delete-image', $image->id) }}"
                                                            style="outline:0;border:none;font-size: 24px;font-weight:800;#FF0000background-color: #;background-color: #FF0000;line-height: 1;color: #fff;padding: 1px 8px;border-radius: 50%;cursor: pointer;position: absolute;right: 0;">-</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                name="is_featured" value="1"
                                                @if ($campaign->is_featured) checked @endif>
                                            <label class="form-check-label" for="inlineCheckbox3">Featured
                                                Campaign</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-red">*</span></label>
                                        <select class="form-control select2 @error('status') is-invalid @enderror"
                                            id="status" name="status">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}"
                                                    @if ($status == $campaign->status) selected @endif>
                                                    {{ $status }} </option>
                                            @endforeach
                                        </select>
                                        @error('status')
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
