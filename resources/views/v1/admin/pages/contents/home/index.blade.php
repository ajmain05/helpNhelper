@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <form action="{{ route('admin.contents.home.hero-section') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex justify-content-between px-4 pt-4">
                                    <div>
                                        <h1>Hero Section</h1>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-sm float-right">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <div class="px-4">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="Enter title"
                                            value="{{ $heroSection['home-hero']->title ?? null }}">
                                    </div>
                                    <div class="form-group d-flex gap-3">
                                        <div>
                                            <label for="background_image">Background Image(16:9)</label>
                                            <input type="file" class="form-control" accept="image/*"
                                                id="background_image" name="background_image">
                                        </div>
                                        <div class="ml-3">
                                            <img src="{{ asset($heroSection['home-hero']?->background_image ?? 'web-assets/v2-images/home/1st home page cover.jpg') }}"
                                                alt="help N helper" class="img-fluid"
                                                style="height: 80px; width: auto; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea name="description" placeholder="Enter Description" rows="3" class="form-control">{{ $heroSection['home-hero']->description ?? null }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Hero Section Footer One</label>
                                        <div class="d-flex">
                                            <input type="text" name="footer_one_title" placeholder="Enter Title"
                                                class="form-control mr-3"
                                                value="{{ $heroSection['home-hero-footer-one']->title ?? null }}">
                                            <input type="text" name="footer_one_description"
                                                placeholder="Enter Description" class="form-control"
                                                value="{{ $heroSection['home-hero-footer-one']->description ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Hero Section Footer Two</label>
                                        <div class="d-flex">
                                            <input type="text" name="footer_two_title" placeholder="Enter Title"
                                                class="form-control mr-3"
                                                value="{{ $heroSection['home-hero-footer-two']->title ?? null }}">
                                            <input type="text" name="footer_two_description"
                                                placeholder="Enter Description" class="form-control"
                                                value="{{ $heroSection['home-hero-footer-two']->description ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Hero Section Footer Three</label>
                                        <div class="d-flex">
                                            <input type="text" name="footer_three_title" placeholder="Enter Title"
                                                class="form-control mr-3"
                                                value="{{ $heroSection['home-hero-footer-three']->title ?? null }}">
                                            <input type="text" name="footer_three_description"
                                                placeholder="Enter Description" class="form-control"
                                                value="{{ $heroSection['home-hero-footer-three']->description ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Hero Section Footer Four</label>
                                        <div class="d-flex">
                                            <input type="text" name="footer_four_title" placeholder="Enter Title"
                                                class="form-control mr-3"
                                                value="{{ $heroSection['home-hero-footer-four']->title ?? null }}">
                                            <input type="text" name="footer_four_description"
                                                placeholder="Enter Description" class="form-control"
                                                value="{{ $heroSection['home-hero-footer-four']->description ?? null }}">
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    <script></script>
@endsection
