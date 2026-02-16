@extends('v1.web.layouts.master')

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/fund-request.css') }}" />
@endsection

@section('content')
    <div class="container">
        <div class="page-header mb-4">
            <h1 class="page-title d-flex justify-content-center ">
                <span class="text-uppercase text-white">{{ Auth::user()?->type }}</span>
                <div class="page-title-special">
                    <p> History</p>
                </div>
            </h1>
            {{-- <p class="page-subtitle d-flex justify-content-center text-center ">
        Lorem ipsum dolor sit amet consectetur. Nisl amet neque molestie non ut elementum enim aenean vitae. Turpis sit
        sed non eget id diam. Tortor aliquam aenean in enim. </p> --}}
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
            <div class="fund-request-content history-table table-responsive-lg"
                style="background-color: rgb(235 241 238 / 92%);">
                <div class="my-3">
                    <a type="button" href="{{ url('/history') }}" class="btn btn-outline-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                        </svg>
                        <path
                            d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                        </svg>Back To History List
                    </a>
                </div>
                @if (Auth::user()?->type == 'volunteer')
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="" class="">Seeker Application Tracking Number</label>
                            <p>{{ $history?->application?->sid }}</p>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Application Status</label>
                            <p>
                                @if ($history->application->status == 'pending')
                                    <span class="p-1 bg-warning rounded ">{{ $history->application->status }}</span>
                                @elseif ($history->application->status == 'approved')
                                    <span class="p-1 bg-primary rounded">{{ $history->application->status }}</span>
                                @elseif ($history->application->status == 'investigating')
                                    <span class="p-1 bg-info rounded">{{ $history->application->status }}</span>
                                @elseif ($history->application->status == 'rejected')
                                    <span class="p-1 bg-danger rounded">{{ $history->application->status }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Application Title</label>
                            <p>{{ $history->application->getTranslation('title') }}</p>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Completion Date</label>
                            <p>{{ $history->application->completion_date }}</p>
                        </div>
                    </div>
                    <h4 class="text-center font-weight-bold mb-3">Seeker Info</h4>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Name</label>
                            <p>{{ $history->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Mobile Number</label>
                            <p>{{ $history->user->mobile ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Country</label>
                            <p>{{ $history->user->upazila->district->division->country->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Division</label>
                            <p>{{ $history->user->upazila->district->division->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">District</label>
                            <p>{{ $history->user->upazila->district->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Upazila</label>
                            <p>{{ $history->user->upazila->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Permanent Address</label>
                            <p>{{ $history->user->permanent_address ?? 'N/A' }}</p>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Present Address</label>
                            <p>{{ $history->user->present_address ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label for="">Document Status</label>
                            <p>
                                @if ($history->application->volunteer_document_status == 'pending')
                                    <span
                                        class="p-1 bg-warning rounded ">{{ $history->application->volunteer_document_status }}</span>
                                @elseif ($history->application->volunteer_document_status == 'approved')
                                    <span
                                        class="p-1 bg-primary rounded">{{ $history->application->volunteer_document_status }}</span>
                                @elseif ($history->application->volunteer_document_status == 'declined')
                                    <span
                                        class="p-1 bg-danger rounded">{{ $history->application->volunteer_document_status }}</span>
                                @else
                                    <span class="p-1">N/A</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12 form-group">
                            <label for="">Document</label>
                            @if ($history->application->volunteer_document == null && $history->application->volunteer_document_status != 'approved')
                                <form action="{{ url('volunteer-document-submit/' . $history->application->id) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex flex-column">
                                        <input type="file" name="volunteer_document" accept="application/pdf" required
                                            @if ($history->application->status != 'investigating') disabled @endif>
                                        <textarea name="comment" placeholder="Add your comment here..." class="mt-2 w-full p-2 border rounded"
                                            @if ($history->application->status != 'investigating') disabled @endif></textarea>
                                        <button class="btn btn-primary mt-3" type="submit"
                                            @if ($history->application->status != 'investigating') disabled @endif>Submit</button>
                                    </div>
                                </form>
                            @else
                                <div class="d-flex flex-column">
                                    <a type="button" target="_blank"
                                        href="{{ '/' . $history->application->volunteer_document }}"
                                        class="btn btn-primary">View</a>
                                    <label for="" class="mt-2">Comment</label>
                                    <p class="mt-1 w-full p-2 border rounded" disabled>
                                        {{ $history->application->comment ?? 'No comment.' }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif (Auth::user()?->type == 'seeker')
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="" class="">Title</label>
                            <p>{{ $history?->getTranslation('title') }}</p>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Application Status</label>
                            <p>
                                @if ($history->status == 'pending')
                                    <span class="p-1 bg-warning rounded ">{{ $history->status }}</span>
                                @elseif ($history->status == 'approved')
                                    <span class="p-1 bg-primary rounded">{{ $history->status }}</span>
                                @elseif ($history->status == 'investigating')
                                    <span class="p-1 bg-info rounded">{{ $history->status }}</span>
                                @elseif ($history->status == 'rejected')
                                    <span class="p-1 bg-danger rounded">{{ $history->status }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="" class="">Tracking#</label>
                            <p>{{ $history?->sid }}</p>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="" class="">Category</label>
                            <p>{{ $history?->category }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="" class="">Description</label>
                            <p>{{ $history?->getTranslation('description') }}</p>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="" class="">Completion Date</label>
                            <p>{{ $history?->completion_date }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="">Requested Amount</label>
                            <p>{{ $history?->requested_amount }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Document (Image/PDF)</label>
                            @if ($history?->document)
                                <a type="button" class="btn btn-primary ml-sm-3 ml-lg-4" target="_blank"
                                    href="/{{ $history->document }}">View</a>
                            @else
                                <span class="text-muted ml-4">N/A</span>
                            @endif
                        </div>

                        <div class="col">
                            <label for="">Image</label>
                            @if ($history?->image)
                                <a type="button" class="btn btn-primary ml-sm-3 ml-lg-4" target="_blank"
                                    href="/{{ $history->image }}">View</a>
                            @else
                                <span class="text-muted ml-4">N/A</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('additional_scripts')
    <script>
        $(document).ready(function() {
            @if (!Auth::user())
                Toast.fire({
                    icon: "error",
                    title: "Please login to see History."
                });
                $('#signupModal').modal('show');
            @endif
        });
    </script>
@endsection
