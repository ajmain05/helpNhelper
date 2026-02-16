@extends('v1.web.layouts.master')

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/about.css') }}" />
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title d-flex justify-content-center">Who
                <div class="page-title-special">
                    <p>We Are</p>
                </div>
            </h1>
            <p class="page-subtitle d-flex justify-content-center text-center ">
                {{ $about->title }}</p>
        </div>
        <div class="page-content">
            <div class="about-us-video">
                <div class="about_us_video">
                    @if ($about->embed != null)
                        <iframe width="100%" height="auto" src="{{ $about->embed }}" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    @else
                        <video id="player" playsinline controls>
                            <source src="{{ asset($about?->file) }}" type="video/mp4" />
                            <source src="{{ asset($about?->file) }}" type="video/webm" />
                        </video>
                    @endif
                </div>
            </div>
            <div class="about-us-content">
                {{-- <p>
                    helpNhelper is an innovative project of Alhaj Shamsul Hoque Foundation (ASHF). It is a 100% secure and
                    reliable platform for both the help seekers and the donors. ASHF is a non-profit charity and government
                    approved NGO (Reg No: 3201, RJSC Reg No: CHS-620/2018, DNC Reg: 01/2021-22) in Bangladesh. It has
                    received the Special Consultative Status to the United Nations Economic and Social Council (ECOSOC).
                </p>
                <p>
                    ASHF has been serving the poor, distressed and needy people in all districts of Bangladesh including
                    Chattogram, Cox's Bazar, Kurigram, Sylhet, Shunamgonj and Satkhira since 2018. Actually, the Foundation
                    works as a bridge between the help seekers and the providers. So far it has contributed a lot of
                    humanitarian assistances especially food, shelter, education, including emergency responses for FDMNs
                    (Rohingya people in Cox’s Bazar and Bhasan Char).
                </p>
                <p>
                    In addition, ASHF implements innovative ideas to build a smart society. The vision of the Foundation is
                    to make a hunger free, poverty free and healthy society and to ensure the peace and prosperity for all
                    regardless of race, religion, caste and gender.
                </p> --}}
                <p>{{ $about->description }}</p>
            </div>
        </div>
    </div>
@endsection

@section('additional_scripts')
    <script>
        const player = new Plyr('#player', {});
    </script>
@endsection
