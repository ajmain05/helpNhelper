@extends('v1.web.layouts.master')

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/donation-3.css') }}" />
@endsection

@section('content')
    <div class="container">
        <div class="mt-4 mb-4 d-flex justify-content-center">
            <h1 class="page-title-special page-title d-flex justify-content-center text-center page-title-special"
                style="width: fit-content;">
                <p>Donation</p>
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
            <div class="donation">
                <div class="d-flex flex-wrap justify-content-center">
                    <label class="campaign-btn-container">
                        <input type="radio" name="options" id="anonymous" autocomplete="off" checked>
                        <div class="btn btn-campaign-category">
                            <i class="fas fa-plus-circle mr-1"></i>Anonymous
                        </div>
                    </label>
                    <label class="campaign-btn-container">
                        <input type="radio" name="options" id="account" autocomplete="off">
                        <div class="btn btn-campaign-category">
                            <i class="fas fa-plus-circle mr-1"></i> Account
                        </div>
                    </label>
                </div>
                <div class="my-4">
                    <a class="campaign-info" href="{{ url('/campaign/' . $campaign->id) }}">
                        <img src="{{ $campaign->photo }}" alt="" srcset="">
                        <div class="">
                            <p>You're supporting <b>{{ $campaign->title }}</b>
                            <p>
                                {{-- <p>{{ $campaign->short_description }}</p> --}}
                        </div>
                    </a>
                </div>
                <form action="{{ url('donation-store') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $campaign->id }}" name="campaign_id">
                    <div class="input-group mb-3 amount phone-section flex-lg-row-reverse flex-column-reverse">
                        <input type="number" class="form-control" id="" name="phone"
                            placeholder="Enter your phone number">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon2">Phone Number</span>
                        </div>
                    </div>
                    <div class="input-group mb-3 amount flex-lg-row-reverse flex-column-reverse">
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount"
                            required>
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon2">TK</span>
                        </div>
                    </div>

                    <hr>
                    <div class="payment">
                        <label>Payment Method</label>
                        <div>
                            <label>
                                <input type="radio" name="method" autocomplete="off" checked>
                                <i class="far fa-credit-card"></i> Online Payment
                            </label>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn donate-button">Donate</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('additional_scripts')
    <script>
        $(document).ready(function() {
            $('#account').click(function() {
                @if (Auth::user()?->type != 'donor')
                    Toast.fire({
                        icon: "info",
                        title: "Please sign in or sign up as a donor."
                    });
                    $(".donate-button").prop("disabled", true);
                    $('.phone-section').hide();
                @else
                    $('.phone-section').hide();
                @endif
            });
            $('#anonymous').click(function() {
                $('.phone-section').show();
                $(".donate-button").prop("disabled", false);
            });
        });
    </script>
@endsection
