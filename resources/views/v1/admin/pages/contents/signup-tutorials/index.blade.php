@extends('v1.admin.layouts.master')

@section('title', 'Manage Signup Tutorials')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Signup Tutorials</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach($types as $type => $label)
                <div class="col-md-6">
                    <div class="card card-outline card-primary shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h3 class="card-title font-weight-bold text-dark">{{ $label }}</h3>
                        </div>
                        <div class="card-body">
                            @php
                                $content = $contents->get($type);
                            @endphp
                            
                            @if($content && $content->embed)
                            <div class="alert alert-light border mb-3 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="far fa-file-pdf fa-2x text-danger mr-3"></i>
                                    <div>
                                        <div class="font-weight-bold">Current PDF:</div>
                                        <a href="{{ asset($content->embed) }}" target="_blank" class="text-primary text-break">
                                            {{ basename($content->embed) }}
                                        </a>
                                    </div>
                                </div>
                                <a href="{{ asset($content->embed) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-external-link-alt"></i> View
                                </a>
                            </div>
                            @else
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-exclamation-triangle mr-1"></i> No tutorial PDF uploaded yet.
                            </div>
                            @endif

                            <form action="{{ route('admin.contents.signup-tutorials.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="type" value="{{ $type }}">
                                <div class="form-group mb-3">
                                    <label class="btn btn-block btn-outline-secondary py-3 cursor-pointer mb-0">
                                        <i class="fas fa-cloud-upload-alt mr-2"></i> {{ $content && $content->embed ? 'Replace PDF' : 'Upload PDF' }}
                                        <input type="file" name="pdf_file" class="d-none" accept=".pdf" onchange="this.form.submit()">
                                    </label>
                                    <small class="form-text text-muted text-center mt-2">Maximum file size: 5MB. Format: PDF only.</small>
                                </div>
                                @if($errors->has('pdf_file') && old('type') == $type)
                                    <div class="text-danger small mt-1 shadow-sm px-2 py-1 bg-white rounded">
                                        {{ $errors->first('pdf_file') }}
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .cursor-pointer { cursor: pointer; }
    .card { transition: all 0.3s ease; border-radius: 12px; }
    .card:hover { transform: translateY(-5px); }
    .btn-outline-secondary { border-style: dashed; border-width: 2px; }
    .btn-outline-secondary:hover { border-style: solid; }
</style>
@endpush
