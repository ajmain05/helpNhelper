@extends('v1.web.layouts.master')

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/fund-request.css') }}" />
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title d-flex justify-content-center text-white">Fund Request
                <div class="page-title-special">
                    <p>Form</p>
                </div>
            </h1>
        </div>
        <div>
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
        <div class="page-content">
            <div class="fund-request-content table-responsive-lg" style="background-color: rgb(235 241 238 / 92%);">
                <form action={{ url('/fund-request') }} method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- <div class="col form-group">
              <label for="fund-request-app-id">Application Id</label>
              <input type="text" class="form-control" id="fund-request-app-id" placeholder="Enter Application Id">
            </div> --}}
                    </div>
                    <div class="row">
                        {{-- <div class="col-6 form-group">
              <label for="fund-request-first-name">First Name</label>
              <input type="text" class="form-control" id="fund-request-first-name" placeholder="Enter First Name">
            </div> --}}
                        <input class="form-check-input" type="hidden" name="type" id="seekers" value="seekers">


                        <div class="col-12 form-group">
                            <label for="fund-request-last-name">Name</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name ?? null }}"
                                id="fund-request-last-name" name="name" placeholder="Enter Name" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="fund-request-email">Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email ?? null }}"
                                id="fund-request-email" placeholder="Enter Email" name="email" disabled>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="fund-request-phone">Phone</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->mobile ?? null }}"
                                id="fund-request-phone" placeholder="Enter Phone" name="mobile" disabled>
                        </div>
                    </div>
                    @if (Auth::user()->type == 'seeker' || Auth::user()->type == 'volunteer')
                        <div class="row">
                            <div class="col form-group">
                                <label for="fund-request-permanent-address">Permanent Address</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->permanent_address ?? null }}"
                                    id="fund-request-permanent-address" name="permanent_address" disabled
                                    placeholder="Enter Permanent Address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label for="fund-request-present-address">Present Address</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->present_address ?? null }}" id="fund-request-present-address"
                                    name="present_address" disabled placeholder="Enter Present Address">
                            </div>
                        </div>
                    @endif
                    @if (Auth::user()->type == 'organization')
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="office_address">Office Address</label>
                                    <textarea type="text" class="form-control @error('office_address') is-invalid @enderror" id="office_address"
                                        name="office_address" placeholder="Enter your permanent address" disabled>{{ Auth::user()->office_address }}</textarea>
                                    @error('office_address')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message ?? '' }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col form-group">
                            <label for="fund-request-amount">Title</label>
                            <input type="text" class="form-control" placeholder="Enter Title" name="title"
                                value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="fund-request-amount">Description</label>
                            <textarea rows="6" type="text" class="form-control" placeholder="Enter Description" name="description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category">
                                <option>Select Category</option>
                                @foreach ($categories as $key => $category)
                                    <option value="{{ $category }}" @if (old('category') == $category) selected @endif>
                                        {{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="fund-request-amount">Amount</label>
                            <input type="number" class="form-control" id="fund-request-amount"
                                placeholder="Enter Amount" name="requested_amount"
                                value="{{ old('requested_amount') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="fund-request-amount">Ending Date</label>
                            <input type="date" class="form-control" id="completion_date" placeholder="Enter Amount"
                                name="completion_date" value="{{ old('completion_date') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="document">Document (Image/PDF)</label>
                                <input type="file" class="form-control-file" id="document" name="document">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control-file" id="image" name="image">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
            <div class="form-group">
              <label class="form-label" for="auth_file">NID/Birth Certificate/Passport</label>
              <input type="file" class="form-control-file" id="auth_file" name="auth_file">
            </div>
            <div class="form-group">
              <label class="form-label" for="profile_image">Profile Image</label>
              <input type="file" class="form-control-file" id="profile_image" name="profile_image">
            </div>
          </div> --}}
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="terms"
                                name="terms">
                            <label class="form-check-label" for="terms">
                                By creating an account, you agree to the <a href="#" class="signup-form-link">Terms
                                    of
                                    Service</a> and <a href="#" class="signup-form-link">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <button type="submit" class="btn submit-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('additional_scripts')
    <script>
        $(document).ready(function() {
            $('#fund-request-country').select2();
        });
    </script>
@endsection
