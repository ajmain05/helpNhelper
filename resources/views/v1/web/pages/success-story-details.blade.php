@extends('v1.web.layouts.master')

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/campaign.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="mt-4">
            <h1 class="page-title d-flex justify-content-center">Success
                <div class="page-title-special">
                    <p>Story</p>
                </div>
            </h1>
        </div>
        <div class="heading">
            <div class="row d-flex justify-content-center">
                <div class="col-8">
                    <h1 class="page-title">{{ $successStory->title }}</h1>
                </div>
            </div>
        </div>
        <div>
            @if (session('success'))
                <div class="alert alert-success text-center">
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
        <div class="campaign-body">
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <div class="campaign-image">
                        <div>
                            <img src="{{ asset($successStory->photo) }}" alt="" srcset=""
                                class="campaign-image">
                        </div>
                    </div>
                    <div class="created">
                        <span>Published at <span>{{ $successStory->created_at }}</span></span>
                    </div>
                    <div class="description">
                        <div class="d-flex justify-content-between">
                            <h4>Campaign Title</h4>
                            <div class="button-new">
                                <a href="{{ url('campaign/' . $successStory?->campaign?->id) }}">See details . . .</a>
                            </div>
                        </div>
                        <p>{{ $successStory->campaign->title }}</p>
                    </div>
                    <div class="description">
                        <h4>Short Description</h4>
                        <p>{{ $successStory->short_description }}</p>
                    </div>
                    <div class="description">
                        <h4>Long Description</h4>
                        <p>{{ $successStory->long_description }}</p>
                    </div>
                    <div class="description">
                        <h4>Previous Condition</h4>
                        <img src="{{ asset($successStory->previous_condition) }}" alt="">
                    </div>
                    <div class="description">
                        <h4>Present Condition</h4>
                        <img src="{{ asset($successStory->present_condition) }}" alt="">
                    </div>
                    {{-- <div class="row mt-3">
                        <div class="col">
                            <a target="_blank" class="btn btn-info" href="{{ route('web.invoice.history', $successStory?->campaign?->id) }}">View all transaction history</a>
                        </div>
                    </div> --}}
                    <div class="button-new justify-content-center mt-4">
                        @php
                            $currentUrl = url()->current();
                            $urlWithoutProtocol = preg_replace('(^https?://)', '', $currentUrl);
                        @endphp
                        <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2F{{ $urlWithoutProtocol }}"
                            target="_blank">Share</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_scripts')
    <script>
        $(document).ready(function() {
            if (session('success')) {
                Toast.fire({
                    icon: 'success',
                    title: session('success')
                })
            }
        });
    </script>
@endsection
