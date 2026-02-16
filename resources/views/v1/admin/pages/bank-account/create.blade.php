@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Bank Account</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.bank-account') }}">Bank Account</a></li>
                            <li class="breadcrumb-item active">Create</li>
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
                                <form enctype="multipart/form-data" action="{{ route('admin.bank-account.store') }}"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="bank">Select Bank</label>
                                        <select class="form-control select2 @error('bank') is-invalid @enderror"
                                            id="bank" name="bank">
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}"
                                                    {{ $bank->id == old('bank') ? 'selected' : '' }}>{{ $bank->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bank')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="branch_name">Branch Name <span class="text-red">*</span></label>
                                        <input type="text"
                                            class="form-control @error('branch_name') is-invalid @enderror" id="branch_name"
                                            value="{{ old('branch_name') }}" name="branch_name"
                                            placeholder="Enter branch name">
                                        @error('branch_name')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="account_number">Account Number <span class="text-red">*</span></label>
                                        <input type="text"
                                            class="form-control @error('account_number') is-invalid @enderror"
                                            id="account_number" value="{{ old('account_number') }}" name="account_number"
                                            placeholder="Enter account number">
                                        @error('account_number')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="opening_balance">Opening Balance <span class="text-red">*</span></label>
                                        <input type="text"
                                            class="form-control @error('opening_balance') is-invalid @enderror"
                                            id="opening_balance" value="{{ old('opening_balance') }}"
                                            name="opening_balance" placeholder="Enter opening balance">
                                        @error('opening_balance')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="remarks">Remarks <span class="text-red">*</span></label>
                                        <input type="text"
                                            class="form-control @error('remarks') is-invalid @enderror"
                                            id="remarks" value="{{ old('remarks') }}" name="remarks"
                                            >
                                        @error('remarks')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}
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
@endsection
