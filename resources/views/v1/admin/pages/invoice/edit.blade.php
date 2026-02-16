@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit {{ ucfirst($type) }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.invoice.' . $type) }}">{{ ucfirst($type) }}</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
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
                                <form enctype="multipart/form-data" action="{{ route('admin.invoice.update', $type) }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ $invoice->transaction->type }}">
                                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                                    <div class="row">

                                        @if ($type !== 'income')
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="sub_type">Select Sub Type <span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control @error('sub_type') is-invalid @enderror"
                                                        id="sub_type" name="sub_type">
                                                        <option value="general"
                                                            @if (old('sub_type') == 'general') selected @endif>General
                                                        </option>
                                                        <option value="campaign"
                                                            @if (old('sub_type') == 'campaign') selected @endif>Campaign
                                                        </option>
                                                    </select>
                                                    @error('sub_type')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="d-none campaign_input col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="campaign">Select Campaign <span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control  @error('campaign_id') is-invalid @enderror"
                                                        id="campaign" name="campaign_id">
                                                        @foreach ($campaigns as $campaign)
                                                            <option value="{{ $campaign->id }}"
                                                                @if (old('campaign_id') == $campaign->id) selected @endif>
                                                                {{ $campaign->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('campaign_id')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="status">Select Volunteer <span
                                                            class="text-red">*</span></label>
                                                    <select
                                                        class="form-control  @error('volunteer_id') is-invalid @enderror"
                                                        id="volunteer" name="volunteer_id">
                                                        @forelse ($volunteers as $volunteer)
                                                            <option value="{{ $volunteer->id }}"
                                                                @if ($invoice->transaction->volunteer_id == $volunteer->id) selected @endif>
                                                                {{ $volunteer->name }}</option>
                                                        @empty
                                                            <option value="">Volunteer is unavailable</option>
                                                        @endforelse
                                                    </select>
                                                    @error('volunteer_id')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="volunteer_payment_type">Select Volunteer Payment Type <span
                                                            class="text-red">*</span></label>
                                                    <select
                                                        class="form-control  @error('volunteer_payment_type') is-invalid @enderror"
                                                        id="volunteer_payment_type" name="volunteer_payment_type">
                                                        @forelse ($volunteerPaymentTypes as $volunteerPaymentType)
                                                            <option value="{{ $volunteerPaymentType }}"
                                                                @if ($invoice->transaction->volunteer_payment_type == $volunteerPaymentType) selected @endif>
                                                                {{ ucfirst($volunteerPaymentType) }}</option>
                                                        @empty
                                                            <option value="">Volunteer payment type is unavailable
                                                            </option>
                                                        @endforelse
                                                    </select>
                                                    @error('volunteer_payment_type')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="campaign">Select Receiver Type <span
                                                            class="text-red">*</span></label>
                                                    <select
                                                        class="form-control @error('receiver_type') is-invalid @enderror"
                                                        id="campaign" name="receiver_type">
                                                        <option value="donor"
                                                            @if ($invoice->transaction->receiver_type == 'donor') selected @endif>Account
                                                        </option>
                                                        <option value="anonymous"
                                                            @if ($invoice->transaction->receiver_type == 'anonymous') selected @endif>Anonymous
                                                        </option>
                                                    </select>
                                                    @error('receiver_type')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="add_for_account col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="donor_type">Select Donor Type <span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control @error('donor_type') is-invalid @enderror"
                                                        id="donor_type" name="donor_type">
                                                        <option value="donor"
                                                            @if ($invoice->transaction->donor_type == 'donor') selected @endif>Donor
                                                        </option>
                                                        <option value="corporate-donor"
                                                            @if ($invoice->transaction->donor_type == 'corporate-donor') selected @endif>Corporate
                                                            Donor
                                                        </option>
                                                    </select>
                                                    @error('donor_type')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="add_for_account col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="donor_id">Select Donor <span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control @error('donor_id') is-invalid @enderror"
                                                        id="donor_id" name="donor_id">
                                                        @forelse ($donors as $donor)
                                                            <option data-donorType="{{ $donor->type }}"
                                                                value="{{ $donor->id }}"
                                                                @if ($invoice->transaction->donor_id == $donor->id) selected @endif>
                                                                {{ $donor->name }}</option>
                                                        @empty
                                                            <option value="">Donor is unavailable</option>
                                                        @endforelse
                                                    </select>
                                                    @error('donor_id')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="add_for_anonymous d-none col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Name <span class="text-red">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="name" aria-describedby="name" name="name"
                                                        value="{{ $invoice->transaction->name }}">
                                                    @error('name')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="add_for_anonymous d-none col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="mobile">Mobile <span class="text-red">*</span></label>
                                                    <input type="text"
                                                        class="form-control  @error('mobile') is-invalid @enderror"
                                                        id="mobile" aria-describedby="mobile" name="mobile"
                                                        value="{{ $invoice->transaction->mobile }}">
                                                    @error('mobile')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="campaign">Select Campaign <span
                                                            class="text-red">*</span></label>
                                                    <select
                                                        class="form-control  @error('campaign_id') is-invalid @enderror"
                                                        id="campaign" name="campaign_id">
                                                        @forelse ($campaigns as $campaign)
                                                            <option value="{{ $campaign->id }}"
                                                                @if ($invoice->transaction->campaign_id == $campaign->id) selected @endif>
                                                                {{ $campaign->title }}
                                                            </option>
                                                        @empty
                                                            <option value="">Campaign is unavailable</option>
                                                        @endforelse
                                                    </select>
                                                    @error('campaign_id')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="date">Select Payment Date <span
                                                        class="text-red">*</span></label>
                                                <input type="date"
                                                    class="form-control  @error('date') is-invalid @enderror"
                                                    id="date" name="date"
                                                    value="{{ $invoice->transaction->date }}">
                                                @error('date')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="bank">Select Bank <span class="text-red">*</span></label>
                                                <select class="form-control  @error('bank_id') is-invalid @enderror"
                                                    id="bank" name="bank_id">
                                                    @forelse ($banks as $bank)
                                                        <option value="{{ $bank->id }}"
                                                            @if ($invoice->transaction->bank_id == $bank->id) selected @endif>
                                                            {{ $bank->name }}</option>
                                                    @empty
                                                        <option value="">Bank is unavailable</option>
                                                    @endforelse
                                                </select>
                                                @error('bank_id')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="bank_account_id">Select Bank Account <span
                                                        class="text-red">*</span></label>
                                                <select
                                                    class="form-control  @error('bank_account_id') is-invalid @enderror"
                                                    id="bank_account" name="bank_account_id">
                                                    @forelse ($bankAccounts as $bankAccount)
                                                        <option data-bank-id="{{ $bankAccount->bank->id }}"
                                                            value="{{ $bankAccount->id }}"
                                                            @if ($invoice->transaction->bank_account_id == $bankAccount->id) selected @endif>
                                                            {{ $bankAccount->account_number }}</option>
                                                    @empty
                                                        <option value="">Bank account is unavailable</option>
                                                    @endforelse
                                                </select>
                                                @error('bank_account_id')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="transaction_category">Transaction Category <span
                                                        class="text-red">*</span></label>
                                                <select
                                                    class="form-control  @error('transaction_category_id') is-invalid @enderror"
                                                    id="transaction_category" name="transaction_category_id">
                                                    @forelse ($transactionCategories as $transactionCategory)
                                                        <option value="{{ $transactionCategory->id }}"
                                                            @if ($invoice->transaction->transaction_category_id == $transactionCategory->id) selected @endif>
                                                            {{ $transactionCategory->name }}</option>
                                                    @empty
                                                        <option value="">Transaction category is unavailable</option>
                                                    @endforelse
                                                </select>
                                                @error('transaction_category_id')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="transaction_mode">Transaction Mode <span
                                                        class="text-red">*</span></label>
                                                <select
                                                    class="form-control  @error('transaction_mode_id') is-invalid @enderror"
                                                    id="transaction_mode" name="transaction_mode_id">
                                                    @forelse ($transactionModes as $transactionMode)
                                                        <option value="{{ $transactionMode->id }}"
                                                            @if ($invoice->transaction->transaction_mode_id == $transactionMode->id) selected @endif>
                                                            {{ $transactionMode->name }}</option>
                                                    @empty
                                                        <option value="">Transaction mode is unavailable</option>
                                                    @endforelse
                                                </select>
                                                @error('transaction_mode_id')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="amount">Amount <span class="text-red">*</span></label>
                                                <input type="text"
                                                    class="form-control  @error('amount') is-invalid @enderror"
                                                    id="amount" aria-describedby="amount" name="amount"
                                                    value="{{ $invoice->transaction->amount }}">
                                                @error('amount')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="status">Status <span class="text-red">*</span></label>
                                                <select class="form-control @error('status') is-invalid @enderror"
                                                    id="status" name="status">
                                                    @forelse ($statuses as $status)
                                                        <option value="{{ $status->id }}"
                                                            @if ($invoice->transaction->status == $status->id) selected @endif>
                                                            {{ $status->name }}</option>
                                                    @empty
                                                        <option value="">Status is unavailable</option>
                                                    @endforelse
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="remarks">Remarks</label>
                                                <input type="text"
                                                    class="form-control  @error('remarks') is-invalid @enderror"
                                                    id="remarks" aria-describedby="remarks" name="remarks"
                                                    value="{{ $invoice->transaction->remarks }}">
                                                @error('remarks')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                                </form>
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
@section('additional_scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        const receiverType = document.querySelector('select[name="receiver_type"]');
        if (receiverType)
            receiverType.addEventListener("change", (e) => {
                const addForAccount = document.querySelectorAll('.add_for_account');
                const addForAnonymous = document.querySelectorAll('.add_for_anonymous');
                if (e.target.value == 'anonymous') {
                    addForAnonymous.forEach((item) => {
                        item.classList.remove('d-none');
                    });
                    addForAccount.forEach((item) => {
                        item.classList.add('d-none');
                    });
                } else {
                    addForAccount.forEach((item) => {
                        item.classList.remove('d-none');
                    });
                    addForAnonymous.forEach((item) => {
                        item.classList.add('d-none');
                    });
                }
            })

        const subType = document.querySelector('select[name="sub_type"]');
        if (subType)
            subType.addEventListener("change", (e) => {
                const addForAccount = document.querySelector('.campaign_input');
                addForAccount.classList.toggle('d-none');
            });


        // Filter donor type
        document.addEventListener('DOMContentLoaded', function() {

            // Get references to the donor_type and donor_id dropdowns
            const donorTypeSelect = document.querySelector('select[name="donor_type"]');
            const donorIdSelect = document.querySelector('select[name="donor_id"]');

            // Function to filter donor_id options
            function filterDonorOptions() {
                const selectedDonorType = donorTypeSelect.value;


                // Loop through each option in the donor_id dropdown
                // Count visible value
                let countVisibleOption = 0;
                Array.from(donorIdSelect.options).forEach((option, index) => {
                    const donorType = option.getAttribute('data-donorType');
                    // console.log(donorType + ' ' + selectedDonorType);
                    if (donorType === selectedDonorType || option.value === "") {
                        option.style.display = 'block';
                        if (countVisibleOption == 0)
                            donorIdSelect.selectedIndex = index;
                        countVisibleOption++;
                    } else {
                        option.style.display = 'none';
                    }
                });

                if (countVisibleOption == 0)
                    donorIdSelect.innerHTML = donorIdSelect.innerHTML +
                    `<option data-empty=true value="">No option available</option>`;
                else {
                    const optionToRemove = donorIdSelect.querySelector('option[data-empty=true]');
                    if (optionToRemove)
                        optionToRemove.remove();
                }

                // Optionally, reset the donor_id selection if the current value is hidden
                if (donorIdSelect.value && donorIdSelect.querySelector(`option[value="${donorIdSelect.value}"]`)
                    .style.display === 'none') {
                    donorIdSelect.value = '';
                }
            }

            // Event listener for donor_type change
            donorTypeSelect.addEventListener('change', filterDonorOptions);

            // Initial filtering on page load
            filterDonorOptions();


            const bankSelect = document.querySelector('select[name="bank_id"]');
            const bankAccountSelect = document.querySelector('select[name="bank_account_id"]');

            // Function to filter donor_id options
            function filterBankAccountOptions() {
                const selectedBank = bankSelect.value;


                // Loop through each option in the donor_id dropdown
                // Count visible value
                let countVisibleOption = 0;
                Array.from(bankAccountSelect.options).forEach((option, index) => {
                    const bankAccountBank = option.getAttribute('data-bank-id');
                    // console.log(donorType + ' ' + selectedDonorType);
                    if (bankAccountBank === selectedBank || option.value === "") {
                        option.style.display = 'block';
                        if (countVisibleOption == 0)
                            bankAccountSelect.selectedIndex = index;
                        countVisibleOption++;
                    } else {
                        option.style.display = 'none';
                    }
                });

                if (countVisibleOption == 0)
                    bankAccountSelect.innerHTML = bankAccountSelect.innerHTML +
                    `<option data-empty=true value="">No option available</option>`;
                else {
                    const optionToRemove = bankAccountSelect.querySelector('option[data-empty=true]');
                    if (optionToRemove)
                        optionToRemove.remove();
                }

                // Optionally, reset the donor_id selection if the current value is hidden
                if (bankAccountSelect.value && bankAccountSelect.querySelector(
                        `option[value="${bankAccountSelect.value}"]`)
                    .style.display === 'none') {
                    bankAccountSelect.value = '';
                }
            }

            // Event listener for donor_type change
            bankSelect.addEventListener('change', filterBankAccountOptions);

            // Initial filtering on page load
            filterBankAccountOptions();



        });
    </script>
@endsection
