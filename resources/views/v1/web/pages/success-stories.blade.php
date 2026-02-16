@extends('v1.web.layouts.master')

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/success-stories.css') }}">
    <link rel="stylesheet" href="{{ asset('web-assets/css/homepage.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title d-flex justify-content-center">Success
                <div class="page-title-special">
                    <p>Stories</p>
                </div>
            </h1>
            <p class="page-subtitle d-flex justify-content-center text-center ">
                Lorem ipsum dolor sit amet consectetur. Nisl amet neque molestie non ut elementum enim aenean vitae. Turpis
                sit sed non eget id diam. Tortor aliquam aenean in enim. </p>
        </div>
        <div class="page-content">
            <div class="success-story-header">
                <h3 class="section-title d-flex justify-content-center">
                    Discover helpNhelper inspired by what you care about
                </h3>
                <p class="section-subtitle d-flex justify-content-center text-center">
                    Lorem ipsum dolor sit amet consectetur. Eget et ultricies cursus fusce. Non ullamcorper imperdiet
                    fringilla
                    odio sed sagittis.
                </p>
            </div>
            <div class="success-stories-content">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <div class="nav flex-column nav-tabs featured-campaign-tabs h-100" id="vert-tabs-tab" role="tablist"
                            aria-orientation="vertical">
                            @foreach ($successStories as $key => $successStory)
                                <a class="nav-link featured-campaign-tab-link @if ($key === 0) active @endif"
                                    id="vert-tabs-{{ $successStory->id }}-tab" data-toggle="pill"
                                    href="#vert-tabs-{{ $successStory->id }}" role="tab"
                                    aria-controls="vert-tabs-{{ $successStory->id }}"
                                    aria-selected="{{ $key === 0 ? 'true' : 'false' }}">
                                    <div class="featured-campaign-menu d-flex align-items-center">
                                        <div
                                            class="featured-campaign-icon-content d-flex justify-content-center align-items-center">
                                            <i class="fas fa-bullhorn featured-campaign-title-icon"></i>
                                        </div>
                                        <div
                                            class="featured-campaign-title d-flex justify-content-center align-items-center">
                                            {{ $successStory->title }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="tab-content" id="vert-tabs-tabContent">
                            @foreach ($successStories as $key => $successStory)
                                <div class="tab-pane text-left fade @if ($key === 0) show active @endif"
                                    id="vert-tabs-{{ $successStory->id }}" role="tabpanel"
                                    aria-labelledby="vert-tabs-{{ $successStory->id }}-tab">
                                    <div class="row featured-campaign-content">
                                        <div class="col-12 col-lg-7 featured-campaign-content-text">
                                            <h3 class="featured-campaign-content-title">
                                                {{ $successStory->title }}
                                            </h3>
                                            <p class="featured-campaign-content-desc">
                                                {{ $successStory->short_description }}
                                            </p>
                                            <p class="featured-campaign-content-subtitle"><b>Description</b></p>
                                            <p class="featured-campaign-content-desc">
                                                {{ $successStory->long_description }}
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-5">
                                            <img class="featured-campaign-content-img"
                                                src="{{ asset($successStory->photo) }}">

                                        </div>
                                    </div>
                                    <div class="featured_campaign_content_btn row featured-campaign-content">
                                        <div class="col">
                                            <div class="button-new">
                                                <a href="{{ url('/success-story/' . $successStory->id) }}"
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
@endsection


@section('additional_scripts')
@endsection
