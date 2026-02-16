@extends('v1.web.layouts.master')

{{-- @section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/fund-request.css') }}" />
@endsection --}}

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
            <div class="table-responsive-lg">
                @if (Auth::user()?->type == 'volunteer')
                    <h2 class="font-weight-bold text-center text-white">Campaign History</h2>
                @endif
                <table class="table table-bordered history_table">
                    <thead class="bg-success">
                        @if (Auth::user()?->type == 'seeker')
                            <tr>
                                <th scope="col">S/N @php $count = 1 @endphp</th>
                                <th scope="col">Title</th>
                                <th scope="col">Requested Amount</th>
                                <th scope="col">Completion Date</th>
                                <th scope="col">status</th>
                                <th scope="col">Action</th>
                            </tr>
                        @elseif (Auth::user()?->type == 'organization')
                            <tr>
                                <th scope="col">S/N @php $count = 1 @endphp</th>
                                <th scope="col">Title</th>
                                <th scope="col">Requested Amount</th>
                                <th scope="col">Completion Date</th>
                                <th scope="col">status</th>
                            </tr>
                        @elseif (Auth::user()?->type == 'volunteer')
                            <tr>
                                <th scope="col">S/N @php $count = 1 @endphp</th>
                                <th scope="col">Seeker Application Tracking Number</th>
                                <th scope="col">Application Title</th>
                                <th scope="col">Completion Date</th>
                                <th scope="col">Application Status</th>
                                {{-- <th scope="col">Document</th> --}}
                                <th scope="col">Action</th>
                            </tr>
                        @elseif (Auth::user()?->type == 'donor')
                            <tr>
                                <th scope="col">S/N @php $count = 1 @endphp</th>
                                <th scope="col">Campaign Title</th>
                                <th scope="col">Amount</th>
                            </tr>
                        @endif
                    </thead>
                    <tbody class="text-white">
                        @if ($history->count() > 0)
                            @if (Auth::user()?->type == 'seeker')
                                @foreach ($history as $history)
                                    <tr>
                                        <th scope="row">{{ $count++ }}</th>
                                        <td>{{ $history->getTranslation('title') }}</td>
                                        <td>{{ $history->requested_amount }} TK</td>
                                        <td>{{ $history->completion_date }}</td>
                                        @if ($history->status == 'pending')
                                            <td><span class="p-1 bg-warning rounded ">{{ $history->status }}</span></td>
                                        @elseif ($history->status == 'investigating')
                                            <td><span class="p-1 bg-info rounded">{{ $history->status }}</span>
                                            </td>
                                        @elseif ($history->status == 'approved')
                                            <td><span class="p-1 bg-primary rounded">{{ $history->status }}</span></td>
                                        @elseif ($history->status == 'rejected')
                                            <td><span class="p-1 bg-danger rounded">{{ $history->status }}</span></td>
                                        @endif
                                        <td class="">
                                            <div class="d-flex justify-content-center">
                                                <a type="button" href="{{ url('/history/' . $history->id) }}"
                                                    class="btn btn-primary">View</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @elseif (Auth::user()?->type == 'organization')
                                @foreach ($history as $history)
                                    <tr>
                                        <th scope="row">{{ $count++ }}</th>
                                        <td>{{ $history->title }}</td>
                                        <td>{{ $history->requested_amount }} TK</td>
                                        <td>{{ $history->completion_date }}</td>
                                        @if ($history->status == 'pending')
                                            <td><span class="p-1 bg-warning rounded ">{{ $history->status }}</span></td>
                                        @elseif ($history->status == 'investigating')
                                            <td><span class="p-1 bg-info rounded">{{ $history->status }}</span>
                                            </td>
                                        @elseif ($history->status == 'approved')
                                            <td><span class="p-1 bg-primary rounded">{{ $history->status }}</span></td>
                                        @elseif ($history->status == 'rejected')
                                            <td><span class="p-1 bg-danger rounded">{{ $history->status }}</span></td>
                                        @endif
                                    </tr>
                                @endforeach
                            @elseif (Auth::user()?->type == 'volunteer')
                                @foreach ($history as $history)
                                    <form action="{{ url('volunteer-document-submit/' . $history->application->id) }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <tr>
                                            <th scope="row">{{ $count++ }}</th>
                                            <td>{{ $history->application->sid ?? 'N/A' }}</td>
                                            <td>{{ $history->application->getTranslation('title') }}</td>
                                            <td>{{ $history->application->completion_date }}</td>
                                            @if ($history->application->status == 'pending')
                                                <td><span
                                                        class="p-1 bg-warning rounded ">{{ $history->application->status }}</span>
                                                </td>
                                            @elseif ($history->application->status == 'approved')
                                                <td><span
                                                        class="p-1 bg-primary rounded">{{ $history->application->status }}</span>
                                                </td>
                                            @elseif ($history->application->status == 'investigating')
                                                <td><span
                                                        class="p-1 bg-info rounded">{{ $history->application->status }}</span>
                                                </td>
                                            @elseif ($history->application->status == 'rejected')
                                                <td><span
                                                        class="p-1 bg-danger rounded">{{ $history->application->status }}</span>
                                                </td>
                                            @endif
                                            {{-- @if ($history->application->volunteer_document == null)
                                                <td>
                                                    <div class="">
                                                        <input type="file" name="volunteer_document" style="width: 250px"
                                                            accept="application/pdf" required
                                                            @if ($history->application->status != 'investigating') disabled @endif>
                                                        <button class="btn btn-primary mt-2" type="submit"
                                                            @if ($history->application->status != 'investigating') disabled @endif>Submit</button>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="">
                                                    <div class="d-flex justify-content-center">
                                                        <a type="button" target="_blank"
                                                            href="{{ $history->application->volunteer_document }}"
                                                            class="btn btn-primary">View</a>
                                                    </div>
                                                </td>
                                            @endif --}}
                                            <td class="">
                                                <div class="d-flex justify-content-center">
                                                    <a type="button"
                                                        href="{{ url('/history/' . $history->application->id) }}"
                                                        class="btn btn-primary">View</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            @elseif (Auth::user()?->type == 'donor')
                                @foreach ($history as $history)
                                    <tr>
                                        <th scope="row">{{ $count++ }}</th>
                                        <td>
                                            <a
                                                href="{{ url('/campaign/' . $history->campaign->id) }}">{{ $history->campaign->title }}</a>
                                        </td>
                                        <td>{{ $history->amount }} Tk</td>
                                    </tr>
                                @endforeach
                            @endif

                        @endif
                    </tbody>
                </table>
                @if ($history->count() == 0)
                    <div class="d-flex justify-content-center text-white">
                        <p>No history available.</p>
                    </div>
                @endif
            </div>
            <div class="table-responsive-lg mt-5">
                @if (Auth::user()?->type == 'volunteer')
                    <h2 class="font-weight-bold text-center text-white">Transaction History</h2>
                    <table class="table table-bordered">
                        <thead class="bg-success">
                            <tr>
                                <th scope="col">Sub type</th>
                                <th scope="col">Campaign Code</th>
                                <th scope="col">Campaign Title</th>
                                <th scope="col">Transaction Category</th>
                                <th scope="col">Bank Info(From)</th>
                                <th scope="col">Bank Info(To)</th>
                                <th scope="col">Payment Date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-white">
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
                                                <span>{{ ucfirst($transaction?->userBank?->type ?? 'N/A') }}</span>
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

                                            <p class="m-0">
                                                <b>Payment Type: </b>
                                                <span>{{ ucfirst($transaction?->volunteer_payment_type) }}</span>
                                            </p>
                                        </td>
                                        <td>{{ $transaction->date }}</td>
                                        <td>{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->remarks ?? 'N/A' }}</td>
                                        <td>
                                            @if ($transaction->receive_status == null)
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#acceptTransaction{{ $transaction->id }}">
                                                    Accept
                                                </button>
                                                <button type="button" class="btn btn-danger mt-2" data-toggle="modal"
                                                    data-target="#declineTransaction{{ $transaction->id }}">
                                                    Decline
                                                </button>
                                                <!--acceptTransaction Modal -->
                                                <div class="modal fade" id="acceptTransaction{{ $transaction->id }}"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-primary"
                                                                    id="exampleModalLabel">
                                                                    Transaction Accept</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to accept this transaction?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <form
                                                                    action="{{ route('accept.transaction', $transaction->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="receive_status"
                                                                        value="accepted">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Accept</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--declineTransaction Modal -->
                                                <div class="modal fade" id="declineTransaction{{ $transaction->id }}"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-danger"
                                                                    id="exampleModalLabel">
                                                                    Transaction Decline</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to decline this transaction?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <form
                                                                    action="{{ route('accept.transaction', $transaction->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="receive_status"
                                                                        value="declined">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Decline</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($transaction->receive_status == 'declined')
                                                <p class="text-danger border p-1 rounded text-center">
                                                    {{ $transaction->receive_status ?? '_' }}
                                                </p>
                                            @elseif ($transaction->receive_status == 'accepted')
                                                <p class="text-primary border p-1 rounded text-center">
                                                    {{ $transaction->receive_status ?? '_' }}</p>
                                            @endif


                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center text-white">No information available.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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
