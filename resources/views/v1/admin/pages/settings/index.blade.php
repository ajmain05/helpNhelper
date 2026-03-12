@extends('v1.admin.layouts.master')

@section('title', 'General Settings')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>General Settings</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-olive">
                            <div class="card-header">
                                <h3 class="card-title">System Configuration</h3>
                            </div>
                            <form action="{{ route('admin.general-settings.update') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="org_service_charge" class="col-sm-3 col-form-label">Organization Service Charge (%)</label>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control" id="org_service_charge" name="org_service_charge" value="{{ $settings['org_service_charge'] ?? '7.00' }}" placeholder="Enter service charge percentage">
                                            <small class="text-muted">This percentage will be deducted from the total collected amount for organization applications.</small>
                                        </div>
                                    </div>
                                    {{-- Add more settings here as needed --}}
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-olive">Save Settings</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
