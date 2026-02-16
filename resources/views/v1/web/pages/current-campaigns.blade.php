@extends('v1.web.layouts.master')

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/current-campaigns.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title d-flex justify-content-center">
                <div>Current</div>
                <div class="page-title-special">
                    <p>Campaigns</p>
                </div>
            </h1>
        </div>
        <div class="page-content">
            <div class="campaign-categories d-flex">
                @php
                    $selectedCategory = request()->input('category');
                @endphp
                <label class="campaign-btn-container">
                    <input type="radio" name="options" id="option" autocomplete="off"
                        @if (!$selectedCategory) checked @endif>
                    <a href="{{ url('/current-campaigns') }}" class="btn btn-campaign-category">
                        <i class="fas fa-plus-circle mr-1"></i> All Campaign
                    </a>
                </label>
                @foreach ($campaignCategory as $index => $category)
                    <label class="campaign-btn-container">
                        <input type="radio" name="options" id="option{{ $index }}" autocomplete="off"
                            @if ($category->id == $selectedCategory) checked @endif>
                        <a href="{{ url('/current-campaigns?category=' . $category->id) }}"
                            class="btn btn-campaign-category">
                            <i class="fas fa-plus-circle mr-1"></i> {{ $category->title }}
                        </a>
                    </label>
                @endforeach
            </div>
            <div class="row mb-5">
                @foreach ($campaigns as $campaign)
                    <div class="col-12 col-sm-6 col-lg-4 mt-4">
                        <div class="card current-campaign-card" data-url="{{ url('/campaign/' . $campaign->id) }}">
                            <img src="{{ asset($campaign->photo) }}" class="current-campaign-card-img" alt="...">

                            <div class="card-body">
                                <h4>
                                    <b>{{ $campaign->title }}</b>
                                </h4>
                                <p>{{ $campaign->short_description }}</p>
                            </div>
                            <div class="card-footer current-campaign-card-footer">
                                <div style="width: 89%; position: relative;">
                                    @php
                                        $progressPercentage = min(
                                            round(($campaign->total_donation / $campaign->amount) * 100),
                                            100,
                                        );
                                    @endphp
                                    <span style="position: absolute; left: {{ $progressPercentage }}%;"
                                        class="percentage">{{ $progressPercentage }}%</span>
                                </div>
                                <div class="progress campaign-progress">
                                    <div class="progress-bar current-campaign-progress-bar" role="progressbar"
                                        style="width: {{ $progressPercentage }}%"
                                        aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1 mb-2">
                                    <h6><b>৳ {{ $campaign->total_donation ?? '0.00' }} raised</b></h6>
                                    <h6><b>goal ৳ {{ $campaign->amount }}</b></h6>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ url('/campaign/' . $campaign->id) }}" class="learn-more-link">
                                        <h6><b>Learn More <i class="fas fa-arrow-right"></i></b></h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('additional_scripts')
@endsection
