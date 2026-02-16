@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <ul class="nav nav-tabs">
                                <li class="nav-item cursor-pointer" id="rating-details-tab" style="cursor: pointer;">
                                    <a class="nav-link active">Ratings</a>
                                </li>
                                <li class="nav-item cursor-pointer" id="user-details-tab" style="cursor: pointer;">
                                    <a class="nav-link">User Details</a>
                                </li>
                            </ul>
                            {{-- user information --}}
                            <div class="card-body" id="user-details">
                                <h4 class="font-weight-bold">User Info</h4>

                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td>{{ $user->mobile ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Facebook Profile</th>
                                        <td>{{ $user->fb_link ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Division</th>
                                        <td>{{ $user?->upazila?->district?->division?->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>District</th>
                                        <td>{{ $user?->upazila?->district?->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Upazila</th>
                                        <td>{{ $user?->upazila?->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Country</th>
                                        <td>{{ $user?->upazila?->district?->division?->country?->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Permanent Address</th>
                                        <td>{{ $user->permanent_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Present Address</th>
                                        <td>{{ $user->present_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ratings</th>
                                        <td>{{ $user->ratings->sum('score') }}</td>
                                    </tr>
                                    <tr>
                                        <th>NID/Birth Certificate/Passport</th>
                                        <td>
                                            <a href="{{ asset($user->auth_file) }}" target="_blank">View
                                                Document</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Profile Image</th>
                                        <td>
                                            <img src="{{ asset($user->photo) }}" alt="Profile Image" class="img-thumbnail"
                                                width="150">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span
                                                class="badge badge-{{ $user->status == 'approved' ? 'success' : 'warning' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Back</a>
                            </div>
                            {{-- Ratings info --}}
                            <div class="p-3" id="ratings-info">
                                <div class="row">
                                    <div class="d-flex justify-content-between w-100 px-3 pb-3">
                                        <h4 class="font-weight-bold">Rating Info</h4>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <p class="form-label mb-0" style="width:200px"><b>Month Filter:</b></p>
                                            <input type="month" name="month_year" class="form-control" id="monthPicker"
                                                onchange="
                                                var ratingMonth = this.value;
                                                var currentUrl = window.location.href;
                                                var newUrl = currentUrl.split('?')[0] + '?rating_month=' + ratingMonth;
                                                window.location.href = newUrl;
                                            ">
                                        </div>
                                        <!-- Add Bank Button trigger modal -->
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#addRatingModal">
                                            Add Rating
                                        </button>


                                        <!--Add Bank Modal -->
                                        <div class="modal fade" id="addRatingModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ route('admin.user.rating.store', ['userId' => $user->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Add Rating
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="form-label" for="">Rating Type <span
                                                                        class="text-red">*</span></label>
                                                                <select class="form-control signup-form-select2-"
                                                                    name="rating_type_id" required>
                                                                    <option value="" disabled selected>Select Type
                                                                    </option>
                                                                    @foreach ($ratingTypes as $ratingType)
                                                                        <option value="{{ $ratingType->id }}"
                                                                            {{ old('rating_type_id') == $ratingType->id ? 'selected' : '' }}>
                                                                            {{ $ratingType->title }} (Out of
                                                                            {{ $ratingType->highest_score }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Rating Score <span
                                                                        class="text-red">*</span></label></label>
                                                                <input type="number" name="score" class="form-control"
                                                                    placeholder="Enter score" value="{{ old('score') }}"
                                                                    step="0.1" required>
                                                            </div>
                                                            @php
                                                                $currentMonth = now()->format('Y-m');
                                                            @endphp

                                                            <div class="form-group">
                                                                <label for="month">Month <span
                                                                        class="text-red">*</span></label>
                                                                <input type="month" name="month_year" class="form-control"
                                                                    required
                                                                    value="{{ old('month_year', $currentMonth) }}">
                                                            </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Add
                                                                Rating</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-striped table-hover">
                                    <thead class="table-light bg-success">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Score</th>
                                            <th scope="col">Out Of</th>
                                            <th scope="col">Month</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($user->ratings->isNotEmpty())
                                            @foreach ($user->ratings as $rating)
                                                <tr>
                                                    <td>{{ $rating->ratingType->title ?? '-' }}</td>
                                                    <td>{{ $rating->score ?? '-' }}</td>
                                                    <td>{{ $rating->ratingType->highest_score ?? '-' }}</td>
                                                    <td>
                                                        {{ $rating->month_year ? \Carbon\Carbon::createFromFormat('Y-m', $rating->month_year)->format('M Y') : '-' }}
                                                    </td>
                                                    <td><!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-transparent"
                                                            data-toggle="modal"
                                                            data-target="#deleteRatingModal{{ $rating->id }}">
                                                            <i class="fa fa-trash text-danger fa-lg"></i>
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="deleteRatingModal{{ $rating->id }}"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title text-danger"
                                                                            id="exampleModalLabel">Rating Delete</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to delete this rating?
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <form
                                                                            action="{{ route('admin.user.rating.delete', $rating->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">No information available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('additional_scripts')
    <script>
        $(document).ready(function() {
            // Initially show User Details and hide Ratings Info
            $("#user-details").hide();
            $("#ratings-info").show();

            // On User Details tab click
            $("#user-details-tab").on("click", function() {
                $("#user-details").show(); // Show User Details
                $("#ratings-info").hide(); // Hide Ratings Info

                // Add active class to User Details tab and remove from Ratings tab
                $("#user-details-tab .nav-link").addClass("active");
                $("#rating-details-tab .nav-link").removeClass("active");
            });

            // On Ratings tab click
            $("#rating-details-tab").on("click", function() {
                $("#user-details").hide(); // Hide User Details
                $("#ratings-info").show(); // Show Ratings Info

                // Add active class to Ratings tab and remove from User Details tab
                $("#rating-details-tab .nav-link").addClass("active");
                $("#user-details-tab .nav-link").removeClass("active");
            });

            var urlParams = new URLSearchParams(window.location.search);
            var ratingMonth = urlParams.get('rating_month');
            if (ratingMonth) {
                // Set the selected month if it's available in the query
                document.getElementById('monthPicker').value = ratingMonth;
            }
        });
    </script>
@endsection
