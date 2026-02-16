@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Show Campaign</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.campaigns.index') }}">Campaigns</a>
                            </li>
                            <li class="breadcrumb-item active">Show</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <label for="seeker_id">Application Title</label>
                                        <p>
                                            <a
                                                href="{{ route('admin.seeker-application.show', $campaign->seeker_application_id) }}">
                                                {{ $campaign->seeker_application->title }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="seeker_id">Campaign Category</label>
                                        <p>{{ $campaign->category->parent_category
                                            ? $campaign->category->parent_category->title . ' > ' . $campaign->category->title
                                            : $campaign->category->title }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="title">Title</label>
                                        <p>{{ $campaign->title }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="short_description">Short Description</label>
                                        <p>{{ $campaign->short_description }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="long_description">Long Description</label>
                                        <pre style="font-family: inherit; padding:0; font-size:15px;">{{ $campaign->long_description }}</pre>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="amount">Amount</label>
                                        <p>{{ $campaign->amount }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="terms">Terms</label>
                                        <p>{{ $campaign->terms }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label class="form-label" for="thumbnail">Thumbnail</label>
                                        <div class="">
                                            <img src="{{ asset($campaign->photo) }}" alt=""
                                                style="height: 115px; width: fit-content; margin: 5px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="">Galleries</label>
                                    @if (!$campaign->images->isEmpty())
                                        <div class="d-flex flex-wrap border border-secondary p-2 rounded" style="gap:20px;">
                                            @foreach ($campaign->images as $image)
                                                <div class="d-flex" style="max-width: 150px; position: relative;">
                                                    <img style="object-fit: contain;" src="{{ asset($image->image) }}"
                                                        alt="Campaign Image">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label" for="status">Status</label>
                                        <p class="h6"><span class="badge badge-info">{{ $campaign->status }}</span></p>
                                    </div>
                                </div>
                                @php
                                    $percentage = min(round(($totalDonation / $campaign_info->amount) * 100), 100);
                                @endphp
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <p class="text-bold mb-0">Target Amount: BDT {{ $campaign_info->amount }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-bold mb-0">Total raised: BDT {{ $totalDonation }}</p>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                                aria-valuemin="0" aria-valuemax="100">{{ $percentage }}%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <h3 class="text-center">Transaction History</h3>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <h5 class="text-left">
                                            Target Amount :
                                            <strong>
                                                {{ number_format($campaign_info->amount ?? 0) }}
                                            </strong>
                                        </h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="text-center">
                                            Total Income :
                                            <strong>
                                                {{ number_format($campaign->invoices->where('transaction.type', 'income')->sum('transaction.amount') ?? 0) }}
                                            </strong>
                                        </h5>
                                    </div>
                                    <div class="col text-danger">
                                        <h5 class="text-center">Total Expense :
                                            <strong>
                                                {{ number_format($campaign->invoices->where('transaction.type', 'expense')->sum('transaction.amount') ?? 0) }}
                                            </strong>
                                        </h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="table-responsive">
                                            <style>
                                                .tran_hist_thead {
                                                    overflow-y: scroll;

                                                    tr {
                                                        th:last-child {
                                                            border-right: none;
                                                        }
                                                    }
                                                }

                                                .tran_hist_tbody {
                                                    overflow-y: scroll;

                                                    tr:first-child {
                                                        td {
                                                            border-top: none;
                                                        }
                                                    }
                                                }

                                                .tran_hist_tbody::-webkit-scrollbar {
                                                    width: 10px;
                                                }

                                                .tran_hist_thead::-webkit-scrollbar {
                                                    background: #f2f2f2;
                                                    width: 10px;
                                                }

                                                /* Track */
                                                .tran_hist_tbody::-webkit-scrollbar-track {
                                                    background: #f1f1f1;
                                                }

                                                /* Handle */
                                                .tran_hist_tbody::-webkit-scrollbar-thumb {
                                                    background: #888;
                                                }

                                                /* Handle on hover */
                                                .tran_hist_tbody::-webkit-scrollbar-thumb:hover {
                                                    background: #555;
                                                }

                                                table {
                                                    width: 100%;
                                                    border-collapse: collapse;
                                                }

                                                thead th {
                                                    position: sticky;
                                                    top: 0;
                                                    background-color: #f2f2f2;
                                                    z-index: 2;
                                                }

                                                tbody,
                                                thead {
                                                    display: block;
                                                    /* Makes the body scrollable */
                                                    max-height: 400px;
                                                    /* Set max height for the scrollable area */
                                                    overflow-y: auto;
                                                    /* Enables vertical scrolling */
                                                }

                                                tbody td,
                                                thead th {
                                                    padding: 10px;
                                                    border: 1px solid #ddd;
                                                    text-align: left;
                                                }

                                                tbody tr,
                                                thead tr {
                                                    display: table;
                                                    /* Ensures rows retain table layout */
                                                    width: 100%;
                                                    /* Match the table's width */
                                                    table-layout: fixed;
                                                    /* Prevents collapsing of columns */
                                                }

                                                thead tr,
                                                tbody tr {
                                                    width: 100%;
                                                    /* Keeps alignment intact */
                                                }
                                            </style>
                                            <table class="table table-bordered table-striped">
                                                <thead class="tran_hist_thead">
                                                    <tr>
                                                        <th scope="col">Transaction Date</th>
                                                        <th scope="col">Invoice Number</th>
                                                        <th scope="col">Transaction Category</th>
                                                        <th scope="col">Donor Name</th>
                                                        <th scope="col">Volunteer Name</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tran_hist_tbody">
                                                    @forelse ($campaign->invoices as $invoice)
                                                        <tr>
                                                            <td>{{ $invoice->date ?? 'N/A' }}</td>
                                                            <td>{{ $invoice->sid ?? 'N/A' }}</td>
                                                            <td>{{ $invoice->transaction->transactionCategory->name ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ $invoice->transaction->name ?? ($invoice->transaction->donorInfo->name ?? 'N/A') }}
                                                            </td>
                                                            <td>{{ $invoice->transaction->volunteerInfo->name ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ $invoice->transaction->amount ?? 'N/A' }}</td>
                                                            <td><span
                                                                    class="p-2 text badge badge-{{ $invoice?->transaction?->type == 'income' ? 'success' : 'danger' }}">{{ ucfirst($invoice?->transaction?->type) ?? 'N/A' }}</span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td class="text-center" colspan="7">No data found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.campaign.edit', $campaign->id) }}"
                                        class="btn btn-primary">Edit</a>
                                    <a href="{{ route('admin.campaign.online-donation-download', $campaign->id) }}"
                                        class="btn btn-primary">Online
                                        Donation Statement Download</a>
                                </div>
                            </div>
                        </div><!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
