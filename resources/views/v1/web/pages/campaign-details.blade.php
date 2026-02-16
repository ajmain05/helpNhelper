@extends('v1.web.layouts.master')

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/campaign.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="heading">
            <h1 class="page-title d-flex justify-content-center">{{ $campaign->title }}</h1>
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
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="campaign-image">
                        @if (isset($campaign->photo))
                            <div>
                                <img src="{{ asset($campaign->photo) }}" alt="" srcset=""
                                    class="campaign-image">
                            </div>
                        @else
                            <div>
                                <h1>{{ $campaign->category->title }}</h1>
                            </div>
                        @endif
                    </div>
                    <div class="created">
                        <span>Published at <span>{{ $campaign->created_at }}</span></span>
                    </div>
                    <div class="description">
                        <h4>Short Description</h4>
                        <p>{{ $campaign->short_description }}</p>
                    </div>
                    <div class="description">
                        <h4>Long Description</h4>
                        <pre style="font-family: inherit; padding:0; font-size:15px;white-space: break-spaces;">{{ $campaign->long_description }}</pre>
                    </div>
                    <div class="button campaign_details_btn">
                        <a href="{{ url('donation/' . $campaign->id) }}">Donate</a>
                        @php
                            $currentUrl = url()->current();
                            $urlWithoutProtocol = preg_replace('(^https?://)', '', $currentUrl);
                        @endphp
                        <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2F{{ $urlWithoutProtocol }}"
                            target="_blank">Share</a>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="donation-box">
                        <p class="tk">
                            <span>{{ number_format(round($totalDonation ?? 0)) }} Tk</span> raised of
                            {{ number_format(round($campaign->amount)) }} TK target
                        </p>
                        <div>
                            @php
                                $percentage = min(round(($totalDonation / $campaign->amount) * 100), 100);
                            @endphp
                            <div style="width: 89%;">
                                <span style="margin-left:{{ $percentage }}%"
                                    class="percentage">{{ $percentage }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <p class="donations">{{ $campaign->total_donors }} donations</p>
                        <hr>
                        <div>
                            <p class="text-center"><b>Address</b></p>
                            <table class="table table-bordered text-sm">
                                <tbody>
                                    <tr>
                                        <th>Upazila</th>
                                        <td>{{ $campaign->seeker_application->user->upazila->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>District</th>
                                        <td>{{ $campaign->seeker_application->user->upazila->district->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Division</th>
                                        <td>{{ $campaign->seeker_application->user->upazila->district->division->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Country</th>
                                        <td>{{ $campaign->seeker_application->user->upazila->district->division->country->name }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <a href="{{ url('donation/' . $campaign->id) }}" class="donate-button">
                            Donate Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
