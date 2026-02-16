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
                    <p class=""> Profile</p>
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
            <div class="fund-request-content" style="padding: 110px 20px; background-color: rgb(235 241 238 / 92%);">
                <form action={{ url('/profile') }} method="post" enctype="multipart/form-data">
                    @csrf

                    @if (Auth::user()->photo)
                        <div class="d-flex justify-content-center mb-3">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center mb-4">
                                    <img src="{{ asset(Auth::user()?->photo) }}" class="rounded" alt="Profile picture"
                                        style="object-fit: cover; max-width: 100%;" height="210px">
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="form-group d-flex flex-column justify-content-center">
                                        <label class="form-label text-center" for="auth_file">Select New Image</label>
                                        <input type="file" class="form-control-file profile_image_input" id="photo"
                                            name="photo" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <p class="page-subtitle d-flex justify-content-center justify-content-lg-end text-md text-center mt-1">
                        <span class="m-1 mr-4">Status : </span>
                        @if (Auth::user()?->status == 'approved')
                            <span class="p-1 bg-primary rounded">{{ Auth::user()?->status }}</span>
                        @else
                            <span class="p-1 bg-warning rounded">{{ Auth::user()?->status }}</span>
                        @endif
                    </p>

                    <input type="hidden" name="type" value="{{ Auth::user()->type }}">
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="fund-request-last-name">Name <span class="text-red">*</span></label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name ?? null }}"
                                id="fund-request-last-name" name="name">
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="fund-request-email">Email <span class="text-red">*</span></label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email ?? null }}"
                                id="fund-request-email" name="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>
                                <div class="password_input">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter password">
                                    <div class="password_eye">
                                        <img src="{{ asset('web-assets/css/eye-regular.svg') }}" alt="Password eye">
                                        <img src="{{ asset('web-assets/css/eye-slash-regular.svg') }}"
                                            alt="Password eye slash">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="fund-request-phone">Phone <span class="text-red">*</span></label>
                            <input type="text" class="form-control" value="{{ Auth::user()->mobile ?? null }}"
                                id="fund-request-phone" name="mobile">
                        </div>
                    </div>

                    @if (Auth::user()?->type == 'seeker' || Auth::user()?->type == 'volunteer' || Auth::user()?->type == 'organization')
                        <div class="row">
                            <div class="col form-group">
                                <label for="fund-request-permanent-address">Permanent Address</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->permanent_address ?? null }}"
                                    id="fund-request-permanent-address" name="permanent_address"
                                    placeholder="Enter Permanent Address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label for="fund-request-present-address">Present Address</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->present_address ?? null }}" id="fund-request-present-address"
                                    name="present_address" placeholder="Enter Present Address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="division">Division <span
                                            class="text-red">*</span></label>
                                    <select class="form-control signup-form-select2-division" id="division"
                                        name="division">
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}"
                                                {{ Auth::user()->upazila->district->division->id == $division->id ? 'selected' : null }}>
                                                {{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12  col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="district">District <span
                                            class="text-red">*</span></label>
                                    <select class="form-control signup-form-select2-district" name="district"
                                        id="district">
                                        <option class="{{ Auth::user()->upazila->district->id ?? null }}">
                                            {{ Auth::user()->upazila->district->name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="upazila">Upazila <span
                                            class="text-red">*</span></label>
                                    <select class="form-control signup-form-select2-upazila" name="upazila"
                                        id="upazila">
                                        <option value="{{ Auth::user()->upazila->id ?? null }}">
                                            {{ Auth::user()->upazila->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <div class="form-group">
                                    <label class="form-label" for="country">Country</label>
                                    <select class="form-control signup-form-select2" id="country" name="country">
                                        @foreach ($countries as $country)
                                            <option value={{ $country->id }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()?->type == 'seeker' || Auth::user()?->type == 'volunteer' || Auth::user()?->type == 'organization')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="auth_file">NID/Birth
                                            Certificate/Passport <span class="text-red">*</span></label>
                                        <input type="file" class="form-control-file" id="auth_file" name="auth_file"
                                            accept="application/pdf">
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- <div class="row">
                            <div class="col-6 form-group">
                                <label for="fund-request-email">Upazila</label>
                                <input type="email" class="form-control"
                                    value="{{ Auth::user()->upazila->name ?? null }}" id="fund-request-email"
                                    placeholder="Enter Email" name="email">
                            </div>
                            <div class="col-6 form-group">
                                <label for="fund-request-phone">District</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->upazila->district->name ?? null }}" id="fund-request-phone"
                                    placeholder="Enter Phone" name="mobile">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="fund-request-email">Division</label>
                                <input type="email" class="form-control"
                                    value="{{ Auth::user()->upazila->district->division->name ?? null }}"
                                    id="fund-request-email" placeholder="Enter Email" name="email">
                            </div>
                            <div class="col-6 form-group">
                                <label for="fund-request-phone">Country</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->upazila->district->division->country->name ?? null }}"
                                    id="fund-request-phone" placeholder="Enter Phone" name="mobile">
                            </div>
                        </div> --}}
                    @endif
                    <div class="row mb-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
                @if (Auth::user()?->type == 'seeker' || Auth::user()?->type == 'volunteer' || Auth::user()?->type == 'organization')
                    <div class="row">
                        <div class="col">
                            <label for="fund-request-email">NID/Birth Certificate/Passport
                                <a type="button" class="btn btn-primary ml-sm-3 ml-lg-4"
                                    href="{{ url(Auth::user()->auth_file) }}" download>Download</a>
                            </label>
                        </div>
                    </div>
                @endif
                @if (Auth::user()?->type == 'volunteer')
                    <div class="mt-4">
                        <div class="row">
                            <div class="d-flex justify-content-between w-100 px-3">
                                <h4 class="font-weight-bold">Bank Info</h4>
                                <!-- Add Bank Button trigger modal -->
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#addBankInfoModal">
                                    Add Bank Info
                                </button>

                                <!--Add Bank Modal -->
                                <div class="modal fade" id="addBankInfoModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('bank-info.store') }}" method="POSt">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Bank Account</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="form-label" for="">Type <span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control signup-form-select2-" name="type"
                                                            onchange="togglePaymentSections(this.value)">
                                                            <option value="" disabled selected>Select Type</option>
                                                            <option value="mfs"
                                                                {{ old('type') == 'mfs' ? 'selected' : '' }}>MFS</option>
                                                            <option value="bank"
                                                                {{ old('type') == 'bank' ? 'selected' : '' }}>Bank</option>
                                                        </select>
                                                    </div>
                                                    <div id="mfs-section">
                                                        <div class="form-group">
                                                            <label for="">bKash</label>
                                                            <input type="number" name="bkash" class="form-control"
                                                                placeholder="Enter bKash number"
                                                                value="{{ old('bkash') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Nagad</label>
                                                            <input type="number" name="nagad" class="form-control"
                                                                placeholder="Enter Nagad number"
                                                                value="{{ old('nagad') }}">
                                                        </div>
                                                    </div>
                                                    <div id="bank-option">
                                                        <div class="form-group">
                                                            <label for="">Bank Name</label>
                                                            <input type="text" name="bank_name" class="form-control"
                                                                placeholder="Enter Bank Name"
                                                                value="{{ old('bank_name') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Branch Name</label>
                                                            <input type="text" name="branch_name" class="form-control"
                                                                placeholder="Enter Branch Name"
                                                                value="{{ old('branch_name') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Routing Number</label>
                                                            <input type="text" name="routing_number"
                                                                class="form-control" placeholder="Enter Routing Number"
                                                                value="{{ old('routing_number') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Holder Name</label>
                                                            <input type="text" name="holder_name" class="form-control"
                                                                placeholder="Enter Account Holder Name"
                                                                value="{{ old('holder_name') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Account Number</label>
                                                            <input type="text" name="account_number"
                                                                class="form-control" placeholder="Enter Account Number"
                                                                value="{{ old('account_number') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Bank</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 w-full overflow-auto">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="1" class="bg-info text-white text-center">Type</th>
                                        <th colspan="2" class="bg-primary text-white text-center">MFS</th>
                                        <th colspan="5" class="bg-success text-white text-center">Bank Information</th>
                                        <th colspan="1" class="bg-danger text-white text-center">Action</th>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="border-right">Type</th>
                                        <th scope="col">bKash</th>
                                        <th scope="col" class="border-right">Nagad</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Branch</th>
                                        <th scope="col">Routing No.</th>
                                        <th scope="col">Holder Name</th>
                                        <th scope="col" class="border-right">Acc No.</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($userBanks->isNotEmpty())
                                        @foreach ($userBanks as $bank)
                                            <tr>
                                                <td class="border-right">{{ ucfirst($bank->type) }}</td>
                                                <td>{{ $bank->bkash ?? '-' }}</td>
                                                <td class="border-right">{{ $bank->nagad ?? '-' }}</td>
                                                <td>{{ $bank->bank_name ?? '-' }}</td>
                                                <td>{{ $bank->branch_name ?? '-' }}</td>
                                                <td>{{ $bank->routing_number ?? '-' }}</td>
                                                <td>{{ $bank->holder_name ?? '-' }}</td>
                                                <td class="border-right">{{ $bank->account_number ?? '-' }}</td>
                                                <td><!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-transparent"
                                                        data-toggle="modal"
                                                        data-target="#deleteBankInfo{{ $bank->id }}">
                                                        <i class="fa fa-trash text-danger fa-lg"></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteBankInfo{{ $bank->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-danger"
                                                                        id="exampleModalLabel">Bank
                                                                        Info Delete</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to delete this bank info?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <form
                                                                        action="{{ route('bank-info.delete', $bank->id) }}"
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
                                            <td colspan="9" class="text-center">No bank information available.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('additional_scripts')
    <script>
        function togglePaymentSections(selectedType) {
            if (selectedType === "mfs") {
                $("#mfs-section").show();
                $("#bank-option").hide();
                $("#bank-option").hide().find("input").val("");
            } else if (selectedType === "bank") {
                $("#bank-option").show();
                $("#mfs-section").hide();
                $("#mfs-section").hide().find("input").val("");
            } else {
                $("#mfs-section, #bank-option").hide();
            }
        }
        $(document).ready(function() {
            $("#mfs-section, #bank-option").hide();
            let selectedType = $("select[name='type']").val();
            if (selectedType) {
                togglePaymentSections(selectedType);
            }

            @if (!Auth::user())
                Toast.fire({
                    icon: "error",
                    title: "Please login to see Profile."
                });
                $('#signupModal').modal('show');
            @endif
        });
    </script>
@endsection
