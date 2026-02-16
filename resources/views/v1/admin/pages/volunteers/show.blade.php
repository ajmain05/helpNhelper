@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Volunteer Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.volunteers.index') }}">Volunteer</a></li>
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
                            {{-- volunteer information --}}
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $userRequest->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $userRequest->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td>{{ $userRequest->mobile ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Facebook Profile</th>
                                        <td>{{ $userRequest->fb_link ?? '-' }}</td>
                                    </tr>
                                    @if ($userRequest->type != 'donor')
                                        <tr>
                                            <th>Division</th>
                                            <td>{{ $userRequest?->upazila?->district?->division?->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>District</th>
                                            <td>{{ $userRequest?->upazila?->district?->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Upazila</th>
                                            <td>{{ $userRequest?->upazila?->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Country</th>
                                            <td>{{ $userRequest?->upazila?->district?->division?->country?->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Permanent Address</th>
                                            <td>{{ $userRequest->permanent_address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Present Address</th>
                                            <td>{{ $userRequest->present_address }}</td>
                                        </tr>
                                        <tr>
                                            <th>NID/Birth Certificate/Passport</th>
                                            <td>
                                                <a href="{{ asset($userRequest->auth_file) }}" target="_blank">View
                                                    Document</a>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Profile Image</th>
                                        <td>
                                            <img src="{{ asset($userRequest->photo) }}" alt="Profile Image"
                                                class="img-thumbnail" width="150">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span
                                                class="badge badge-{{ $userRequest->status == 'approved' ? 'success' : 'warning' }}">
                                                {{ ucfirst($userRequest->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                <a href="{{ route('admin.volunteers.index') }}" class="btn btn-secondary mt-3">Back</a>
                            </div>
                            {{-- bank info --}}
                            <div class="p-3">
                                <h4 class="font-weight-bold">Bank Info</h4>

                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th colspan="1" class="bg-info text-white text-center">Type</th>
                                            <th colspan="2" class="bg-primary text-white text-center">MFS</th>
                                            <th colspan="5" class="bg-success text-white text-center">Bank Information
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="border-right">Type</th>
                                            <th scope="col">bKash</th>
                                            <th scope="col" class="border-right">Nagad</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Branch</th>
                                            <th scope="col">Routing No.</th>
                                            <th scope="col">Holder Name</th>
                                            <th scope="col">Acc No.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($userRequest->userBanks->isNotEmpty())
                                            @foreach ($userRequest->userBanks as $bank)
                                                <tr>
                                                    <td class="border-right">{{ ucfirst($bank->type) }}</td>
                                                    <td>{{ $bank->bkash ?? '-' }}</td>
                                                    <td class="border-right">{{ $bank->nagad ?? '-' }}</td>
                                                    <td>{{ $bank->bank_name ?? '-' }}</td>
                                                    <td>{{ $bank->branch_name ?? '-' }}</td>
                                                    <td>{{ $bank->routing_number ?? '-' }}</td>
                                                    <td>{{ $bank->holder_name ?? '-' }}</td>
                                                    <td>{{ $bank->account_number ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">No bank information available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            {{-- volunteer transactions --}}
                            <div class="p-3">
                                <h4 class="font-weight-bold">Transactions Info</h4>
                                <table class="table table-hover table-striped">
                                    <thead class="bg-success">
                                        <tr>
                                            <th scope="col">Sub type</th>
                                            <th scope="col">Campaign Code</th>
                                            <th scope="col">Campaign Title</th>
                                            <th scope="col">Transaction Category</th>
                                            <th scope="col">Bank Info(From)</th>
                                            <th scope="col">Bank Info(To)</th>
                                            <th scope="col">Payment Type</th>
                                            <th scope="col">Payment Date</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($transactions->isNotEmpty())
                                            @foreach ($transactions as $transaction)
                                                <tr>
                                                    <td>{{ $transaction?->sub_type }}</td>
                                                    <td>{{ $transaction?->campaignInfo?->sid ?? 'N/A' }}</td>
                                                    <td>{{ $transaction?->campaignInfo?->title ?? 'N/A' }}</td>
                                                    <td>{{ $transaction?->transactionCategory?->name }}</td>
                                                    <td>
                                                        <p class="m-0">
                                                            <b>Name: </b>
                                                            <span>{{ $transaction?->bankInfo?->name }} </span>
                                                        </p>
                                                        <p class="m-0">
                                                            <b>Account:</b>
                                                            <span>{{ $transaction?->bankAccountInfo?->account_number }}</span>
                                                        </p>
                                                        <p class="m-0">
                                                            <b>Mode:</b>
                                                            <span>{{ $transaction?->transactionMode?->name }}</span>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="m-0">
                                                            <b>Type: </b>
                                                            <span>{{ ucfirst($transaction?->userBank?->type) }}</span>
                                                        </p>

                                                        @if ($transaction?->userBank?->type === 'bank')
                                                            <p class="m-0">
                                                                <b>Bank Name:</b>
                                                                <span>{{ $transaction?->userBank?->bank_name }}</span>
                                                            </p>
                                                            <p class="m-0">
                                                                <b>Account:</b>
                                                                <span>{{ $transaction?->userBank?->account_number }}</span>
                                                            </p>
                                                        @elseif ($transaction?->userBank?->type === 'mfs')
                                                            <p class="m-0">
                                                                <b>bKash:</b>
                                                                <span>{{ $transaction?->userBank?->bkash ?? 'N/A' }}</span>
                                                            </p>
                                                            <p class="m-0">
                                                                <b>Nagad:</b>
                                                                <span>{{ $transaction?->userBank?->nagad ?? 'N/A' }}</span>
                                                            </p>
                                                        @endif
                                                    </td>
                                                    <td>{{ $transaction->volunteer_payment_type }}</td>
                                                    <td>{{ $transaction->date }}</td>
                                                    <td>{{ $transaction->amount }}</td>
                                                    <td>{{ $transaction->remarks }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center">No information available.</td>
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
