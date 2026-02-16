@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Show {{ ucfirst($type) }} Transaction</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.invoice.' . $type) }}">{{ ucfirst($type) }}</a>
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
                                @if ($type == 'income')
                                @endif
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h6 class="text-bold">Sub Type</h6>
                                        <p>{{ $invoice->transaction->sub_type }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h6 class="text-bold">Campaign</h6>
                                        <p>{{ $invoice->transaction->campaignInfo->title ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                @if ($type != 'income')
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h6 class="text-bold">Volunteer</h6>
                                            <p>{{ $invoice->transaction->volunteerInfo->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h6 class="text-bold">Receiver Type</h6>
                                            <p>{{ $invoice->transaction->receiver_type ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    @if ($invoice->transaction->receiver_type != 'anonymous')
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 class="text-bold">Donor Type</h6>
                                                <p>{{ $invoice->transaction->donor_type ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 class="text-bold">Donor Name</h6>
                                                <p>{{ $invoice->transaction->donorInfo->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 class="text-bold">Donor Name</h6>
                                                <p>{{ $invoice->transaction->donorInfo->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 class="text-bold">Donor's Name</h6>
                                                <p>{{ $invoice->transaction->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 class="text-bold">Donor's Mobile</h6>
                                                <p>{{ $invoice->transaction->mobile ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h6 class="text-bold">Payment Date</h6>
                                        <p>{{ $invoice->transaction->date ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                @if ($invoice->transaction->receiver_type != 'anonymous')
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h6 class="text-bold">Volunteer Bank Account(To)</h6>
                                            <p>
                                                <b>Type: </b>
                                                <span>{{ ucfirst($invoice?->transaction?->userBank?->type) }}</span>

                                                @if ($invoice?->transaction?->userBank?->type === 'bank')
                                                    <b>, Bank Name: </b>
                                                    <span>{{ $invoice?->transaction?->userBank?->bank_name }}</span>
                                                    <b>, Account Number: </b>
                                                    <span>{{ $invoice?->transaction?->userBank?->account_number }}</span>
                                                @elseif ($invoice?->transaction?->userBank?->type === 'mfs')
                                                    <b>, bKash: </b>
                                                    <span>{{ $invoice?->transaction?->userBank?->bkash ?? 'N/A' }}</span>
                                                    <b>, Nagad: </b>
                                                    <span>{{ $invoice?->transaction?->userBank?->nagad ?? 'N/A' }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 mb-3">
                                            <h6 class="text-bold">Receive Status</h6>
                                            @if ($invoice?->transaction->receive_status == 'declined')
                                                <span class="text-danger border p-1 rounded text-center">
                                                    {{ ucfirst($invoice?->transaction->receive_status) ?? '_' }}
                                                </span>
                                            @elseif ($invoice?->transaction->receive_status == 'accepted')
                                                <span class="text-primary border p-1 rounded text-center">
                                                    {{ ucfirst($invoice?->transaction->receive_status) ?? '_' }}</span>
                                            @elseif ($invoice?->transaction->receive_status == null)
                                                <span class="text-info border p-1 rounded text-center">
                                                    Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h6 class="text-bold">Bank(From)</h6>
                                            <p>{{ $invoice->transaction->bankInfo->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h6 class="text-bold">Bank Account No(From)</h6>
                                            <p>{{ $invoice->transaction->bankAccountInfo->account_number ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h6 class="text-bold">Transaction Category</h6>
                                        <p>{{ $invoice->transaction->transactionCategory->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h6 class="text-bold">Transaction Mode</h6>
                                        <p>{{ $invoice->transaction->transactionMode->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h6 class="text-bold">Amount</h6>
                                        <p>BDT {{ $invoice->transaction->amount ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h6 class="text-bold">Status</h6>
                                        {{-- <p><span class="badge badge-primary">{{ $invoice->statusInfo->name ?? 'N/A' }}</span></p> --}}
                                        <p>{{ $invoice->statusInfo->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h6 class="text-bold">Remarks</h6>
                                        {{-- <p><span class="badge badge-primary">{{ $invoice->statusInfo->name ?? 'N/A' }}</span></p> --}}
                                        <p>{{ $invoice->transaction->remarks ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.invoice.edit', $invoice->id) }}" class="btn btn-primary">Edit</a>

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
