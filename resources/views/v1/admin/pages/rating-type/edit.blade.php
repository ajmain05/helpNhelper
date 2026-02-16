@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Rating Type</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.rating-types') }}">Rating Type</a>
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
                                    action="{{ route('admin.rating-types.update', ['id' => $ratingType->id]) }}"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" value="{{ old('title', $ratingType->title) }}" name="title"
                                            placeholder="Enter title">
                                        @error('title')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="highest_score">Highest score<span class="text-red">*</span></label>
                                        <input type="number"
                                            class="form-control @error('highest_score') is-invalid @enderror"
                                            id="highest_score"
                                            value="{{ old('highest_score', $ratingType->highest_score) }}"
                                            name="highest_score" placeholder="Enter highest score" step="0.1">
                                        @error('highest_score')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="remarks">Remarks</label>
                                        <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks"
                                            placeholder="Enter remarks">{{ old('remarks', $ratingType->remarks) }}</textarea>
                                        @error('remarks')
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
