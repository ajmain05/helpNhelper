@extends('v1.web.layouts.master')

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/homepage.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="hero-section row">
            <div class="col-12 col-lg-8">
                <h1 class="text-left hero-title">{{ $heroSection?->title }}</h1>
                <p class="hero-text">
                    {{ $heroSection->description }}
                </p>
                <div class="hero_btn_div">
                    <a class="btn btn-lg hero-btn" href="{{ url('/current-campaigns') }}">Donate Now</a>
                    {{-- <a class="btn btn-lg hero-btn ml-4" type="button" href="{{route('fund-request')}}" id="post-fund">Post A Fund Request</a> --}}
                    @if (Auth::user()?->type == 'volunteer' || Auth::user()?->type == 'donar')
                    @else
                        <a class="btn btn-lg hero-btn ml-4" type="button" id="post-fund">Post A Fund Request</a>
                    @endif
                </div>
                <div class="d-flex hero-footer">
                    <img src="{{ asset('web-assets/css/donation-group-pic.png') }}">
                    <b class="ml-2 d-flex align-items-center">2,500 people donated in last 4 months</b>
                </div>
            </div>
            <div class="col-12 col-lg-4 hero_img">
                <img src="{{ asset('web-assets/css/hero-img.png') }}">
            </div>
        </div>
        <div class="campaign-section">
            <div class="campaign-header">
                <h3 class="section-title d-flex justify-content-center">
                    Discover helpNhelper inspired by what you care about
                </h3>
                {{-- <p class="section-subtitle d-flex justify-content-center text-center">
                    Lorem ipsum dolor sit amet consectetur. Eget et ultricies cursus fusce. Non ullamcorper imperdiet
                    fringilla
                    odio sed sagittis.
                </p> --}}
            </div>
            <div class="campaign-categories d-flex">
                @foreach ($campaignCategory as $index => $category)
                    <label class="campaign-btn-container">
                        <input type="radio" name="options" id="option{{ $index }}" autocomplete="off"
                            {{-- @if ($index === 0) checked @endif --}}>
                        <a href="{{ url('/current-campaigns?category=' . $category->id) }}"
                            class="btn btn-campaign-category">
                            <i class="fas fa-plus-circle mr-1"></i> {{ $category->title }}
                        </a>
                    </label>
                @endforeach
            </div>
            <div class="campaign-content 1">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6">
                        @if (!empty($campaigns[0]))
                            <a class="card campaign-card primary-featured"
                                href="{{ url('/campaign/' . $campaigns[0]?->id) }}">
                                <img src="{{ asset($campaigns[0]?->photo) }}" class="card-img-bottom campaign-card-img"
                                    alt="image">
                                <div class="card-img-overlay campaign-card-content">
                                    <span class="badge campaign-card-badge">{{ $campaigns[0]?->total_donors }}
                                        donations</span>
                                    <h4>{{ $campaigns[0]?->title }}</h4>
                                    <p>{{ $campaigns[0]?->short_description }}</p>
                                    <div class="progress campaign-progress">
                                        <div class="progress-bar campaign-progress-bar" role="progressbar"
                                            style="width: {{ min(round(($campaigns[0]?->total_raised / $campaigns[0]?->amount) * 100), 100) }}%"
                                            aria-valuenow="{{ $campaigns[0]?->total_raised }}" aria-valuemin="0"
                                            aria-valuemax="{{ $campaigns[0]?->amount }}"></div>
                                    </div>
                                    <h6>৳ {{ round($campaigns[0]?->total_donation ?? '0.00') }} raised</h6>
                                </div>
                            </a>
                        @endif
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            @foreach ($campaigns as $key => $campaign)
                                @if ($key > 0)
                                    <div class="col-12 col-md-{{ $key == 1 ? '12' : '6' }}">
                                        <a class="card campaign-card{{ $key == 1 ? ' secondary-featured' : '' }}"
                                            href="{{ url('/campaign/' . $campaign->id) }}">
                                            <img src="{{ asset($campaign->photo) }}"
                                                class="card-img-bottom campaign-card-img" alt="...">
                                            <div class="card-img-overlay campaign-card-content">
                                                <span class="badge campaign-card-badge">{{ $campaign->total_donors }}
                                                    donations</span>
                                                <h4>{{ $campaign->title }}</h4>
                                                <div class="progress campaign-progress">
                                                    <div class="progress-bar campaign-progress-bar" role="progressbar"
                                                        style="width: {{ min(round(($campaign->total_raised / $campaign->amount) * 100), 100) }}%"
                                                        aria-valuenow="{{ $campaign->total_raised }}" aria-valuemin="0"
                                                        aria-valuemax="{{ $campaign->amount }}"></div>
                                                </div>
                                                <h6>৳ {{ round($campaign->total_donation ?? '0.00') }} raised</h6>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center justify-content-md-end">
                <div class="p-4">
                    <a href="{{ url('/current-campaigns') }}" class="learn-more-link text-lg"><b>Explore More . .
                            .</b></a>
                </div>
            </div>
        </div>
        <div class="current-campaign-section">
            <div class="current-campaign-header">
                <h3 class="section-title d-flex justify-content-center">
                    Current Campaigns
                </h3>
                {{-- <p class="section-subtitle d-flex justify-content-center text-center">
                    Don’t let complicated, expensive software get in the way of your mission. Givebutter’s tools are easy,
                    free,
                    and fun to use.
                </p> --}}
            </div>
            <div class="current-campaign-content">
                <div class="owl-carousel owl-theme current-campaigns-carousel">
                    @foreach ($campaigns as $campaign)
                        <div class="card current-campaign-card" data-url="{{ url('/campaign/' . $campaign->id) }}">
                            <div class="card-img">
                                <img src="{{ asset($campaign->photo) }}" class="current-campaign-card-img" alt="...">
                                <h5>{{ $campaign->category->title }}</h5>
                            </div>
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
                                            round(($campaign->total_raised / $campaign->amount) * 100),
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="stats-section">
        <div class="state-section-row">
            <div class="col state-content">
                <div class="fund-content">
                    <p class="stat-title">25M</p>
                    <p class="stat-subtitle">Fund raised</p>
                </div>
            </div>
            <div class="col state-content">
                <div class="seeker-content">
                    <p class="stat-title">1230+</p>
                    <p class="stat-subtitle">Seekers</p>
                </div>
            </div>
            <div class="col state-content">
                <div class="volunteer-content">
                    <p class="stat-title">{{ $volunteerNumber }}+</p>
                    <p class="stat-subtitle">Volunteers</p>
                </div>
            </div>
            <div class="col state-content">
                <div class="donate-content">
                    <p class="stat-title">6000+</p>
                    <p class="stat-subtitle">People donated</p>
                </div>
            </div>
            <div class="col state-content">
                <div class="visitor-content">
                    <p class="stat-title">600+</p>
                    <p class="stat-subtitle">Unique visitors daily</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="featured-campaigns-section">
            <div class="featured-campaigns-header">
                <h3 class="section-title d-flex justify-content-center">
                    helpNhelper Featured Campaigns
                </h3>
                {{-- <p class="section-subtitle d-flex justify-content-center text-center">
                    Don’t let complicated, expensive software get in the way of your mission. Givebutter’s tools are easy,
                    free,
                    and fun to use.
                </p> --}}
            </div>
            <div class="featured-campaigns-content">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <div class="nav flex-column nav-tabs featured-campaign-tabs h-100" id="vert-tabs-tab"
                            role="tablist" aria-orientation="vertical">
                            @foreach ($featuredCampaign as $key => $campaign)
                                <a class="nav-link featured-campaign-tab-link @if ($key === 0) active @endif"
                                    id="vert-tabs-{{ $campaign->id }}-tab" data-toggle="pill"
                                    href="#vert-tabs-{{ $campaign->id }}" role="tab"
                                    aria-controls="vert-tabs-{{ $campaign->id }}"
                                    aria-selected="{{ $key === 0 ? 'true' : 'false' }}">
                                    <div class="featured-campaign-menu d-flex align-items-center">
                                        <div
                                            class="featured-campaign-icon-content d-flex justify-content-center align-items-center">
                                            <i class="fas fa-bullhorn featured-campaign-title-icon"></i>
                                        </div>
                                        <div
                                            class="featured-campaign-title d-flex justify-content-center align-items-center">
                                            {{ $campaign->title }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="tab-content" id="vert-tabs-tabContent">
                            @foreach ($featuredCampaign as $key => $campaign)
                                <div class="tab-pane text-left fade @if ($key === 0) show active @endif"
                                    id="vert-tabs-{{ $campaign->id }}" role="tabpanel"
                                    aria-labelledby="vert-tabs-{{ $campaign->id }}-tab">
                                    <div class="row featured-campaign-content">
                                        <div class="col-12  col-lg-7 featured-campaign-content-text">
                                            <h3 class="featured-campaign-content-title">
                                                {{ $campaign->title }}
                                            </h3>
                                            <p class="featured-campaign-content-desc">
                                                {{ $campaign->short_description }}
                                            </p>
                                            <p class="featured-campaign-content-subtitle"><b>Description</b></p>
                                            <p class="featured-campaign-content-desc">
                                                {{ $campaign->long_description }}
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-5">
                                            <img class="featured-campaign-content-img"
                                                src="{{ asset($campaign->photo) }}">
                                        </div>
                                    </div>
                                    <div class="featured_campaign_content_btn row featured-campaign-content">
                                        <div class="col mb-5">
                                            <div class="button-new">
                                                <a href="{{ url('/campaign/' . $campaign->id) }}"
                                                    class="learn-more-link">Explore More . . .</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="stories-section">
        <div class="container">
            <div class="stories-header">
                <h3 class="section-title d-flex justify-content-center">
                    Success Stories
                </h3>
                {{-- <p class="section-subtitle d-flex justify-content-center text-center">
                    Lorem ipsum dolor sit amet consectetur. Enim viverra praesent habitant vitae porta bibendum sem odio
                    massa.
                </p> --}}
            </div>
            <div class="stories-content">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <div class="nav flex-column nav-tabs story-tabs h-100" id="vert-tabs-tab" role="tablist"
                            aria-orientation="vertical">
                            @foreach ($successStories as $index => $successStory)
                                <a class="nav-link story-tab-link {{ $index == 0 ? 'active' : '' }}"
                                    id="vert-tabs-story-tab{{ $index }}" data-toggle="pill"
                                    href="#vert-tabs-story{{ $index }}" role="tab"
                                    aria-controls="vert-tabs-story{{ $index }}"
                                    aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                    {{ $successStory->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-sm-9">
                        <div class="tab-content" id="vert-tabs-tabContent">
                            @foreach ($successStories as $index => $successStory)
                                <div class="tab-pane text-left fade {{ $index == 0 ? 'active show' : '' }}"
                                    id="vert-tabs-story{{ $index }}" role="tabpanel"
                                    aria-labelledby="vert-tabs-story-tab{{ $index }}">
                                    <div class="story-content">
                                        <p class="story-content-title">
                                            {{ $successStory->title }}
                                        </p>
                                        <p class="story-content-desc">
                                            {{ $successStory->short_description }}
                                        </p>
                                        <div class="button-new">
                                            <a href="{{ url('/success-story/' . $successStory->id) }}"
                                                class="learn-more-link"><b>Learn More</b></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="testimonial-section">
            <div class="testimonial-header">
                <h3 class="section-title d-flex justify-content-center">
                    What our donor/Seeker say
                </h3>
                <p class="section-subtitle d-flex justify-content-center text-center">
                    We love to hear from donor/seeker so please leave a comment or say hello in an email.
                </p>
            </div>
            <div class="testimonial-content">
                <div class="swiper testimonial_swiper">
                    <div class="swiper-wrapper">
                        <div class="testimonial-item swiper-slide">
                            <div class="testimonial-item-header d-flex">
                                <img class="testimonial-img" src="{{ asset('web-assets/css/testimonial-user.png') }}">
                                <div class="testimonial-item-header-content">
                                    <h4 class="testimonial-item-header-title">
                                        Hafizul Islam
                                    </h4>
                                    <p class="testimonial-item-header-subtitle">
                                        Bangladesh
                                    </p>
                                </div>
                            </div>
                            <div class="testimonial-divider"></div>
                            <p class="testimonial-item-content">
                                "It is professional, considers everyone's time, can think about the
                                There are many variations of passages whole probls small niche, friendly.
                            </p>
                        </div>
                        <div class="testimonial-item swiper-slide">
                            <div class="testimonial-item-header d-flex">
                                <img class="testimonial-img" src="{{ asset('web-assets/css/testimonial-user.png') }}">
                                <div class="testimonial-item-header-content">
                                    <h4 class="testimonial-item-header-title">
                                        Saddam Hossen
                                    </h4>
                                    <p class="testimonial-item-header-subtitle">
                                        Bangladesh
                                    </p>
                                </div>
                            </div>
                            <div class="testimonial-divider"></div>
                            <p class="testimonial-item-content">
                                "It is professional, considers everyone's time, can think about the
                                There are many variations of passages whole probls small niche, friendly.
                            </p>
                        </div>
                        <div class="testimonial-item swiper-slide">
                            <div class="testimonial-item-header d-flex">
                                <img class="testimonial-img" src="{{ asset('web-assets/css/testimonial-user.png') }}">
                                <div class="testimonial-item-header-content">
                                    <h4 class="testimonial-item-header-title">
                                        Sraban Barua
                                    </h4>
                                    <p class="testimonial-item-header-subtitle">
                                        Bangladesh
                                    </p>
                                </div>
                            </div>
                            <div class="testimonial-divider"></div>
                            <p class="testimonial-item-content">
                                "It is professional, considers everyone's time, can think about the
                                There are many variations of passages whole probls small niche, friendly.
                            </p>
                        </div>
                        <div class="testimonial-item swiper-slide">
                            <div class="testimonial-item-header d-flex">
                                <img class="testimonial-img" src="{{ asset('web-assets/css/testimonial-user.png') }}">
                                <div class="testimonial-item-header-content">
                                    <h4 class="testimonial-item-header-title">
                                        Fahad Hossain
                                    </h4>
                                    <p class="testimonial-item-header-subtitle">
                                        Bangladesh
                                    </p>
                                </div>
                            </div>
                            <div class="testimonial-divider"></div>
                            <p class="testimonial-item-content">
                                "It is professional, considers everyone's time, can think about the
                                There are many variations of passages whole probls small niche, friendly.
                            </p>
                        </div>
                        <div class="testimonial-item swiper-slide">
                            <div class="testimonial-item-header d-flex">
                                <img class="testimonial-img" src="{{ asset('web-assets/css/testimonial-user.png') }}">
                                <div class="testimonial-item-header-content">
                                    <h4 class="testimonial-item-header-title">
                                        Nur Muhammad
                                    </h4>
                                    <p class="testimonial-item-header-subtitle">
                                        Bangladesh
                                    </p>
                                </div>
                            </div>
                            <div class="testimonial-divider"></div>
                            <p class="testimonial-item-content">
                                "It is professional, considers everyone's time, can think about the
                                There are many variations of passages whole probls small niche, friendly.
                            </p>
                        </div>
                    </div>
                    <div class="swiper-button-next custom_swiper_button_next"></div>
                    <div class="swiper-button-prev custom_swiper_button_prev"></div>
                </div>
            </div>

        </div>
    </div>
    <div class="banner-section">
        <img width="100%" src="{{ asset('web-assets/css/banner.png') }}">
    </div>
@endsection
@section('additional_scripts')
    <script>
        $(document).ready(function() {
            // var swiperTestimonial = new Swiper(".testimonial_swiper", {

            //     centeredSlides: true,
            //     slidesPerView: 1,
            //     spaceBetween: 15,
            //     loop: true,
            //     initialSlide: 2,
            //     navigation: {
            //         nextEl: ".swiper-button-next",
            //         prevEl: ".swiper-button-prev",
            //     },
            //     breakpoints: {
            //         768: {
            //             slidesPerView: 2,
            //             spaceBetween: 30,
            //         },
            //         1024: {
            //             slidesPerView: 3.3,
            //             spaceBetween: 30,
            //         },
            //     },
            // });
            $('.current-campaigns-carousel').owlCarousel({
                loop: true,
                margin: 16,
                nav: false,
                dots: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            })

            $('#post-fund').click(function() {
                @if (Auth::user() && Auth::user()->type === 'seeker')
                    window.location.href = "{{ route('fund-request') }}";
                @else
                    $('#signupModal').modal('show');
                    $('#seekers').prop('checked', true);
                    $('.secondary-info').show();
                    Toast.fire({
                        icon: "info",
                        title: "Please Sign in or Sign up as a Seeker to post fund request.",
                    });
                @endif
            });
        })
    </script>
@endsection
