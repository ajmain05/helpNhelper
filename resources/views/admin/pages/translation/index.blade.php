@extends('v1.admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Translations</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title mb-0">Manage Translations &mdash; <span class="badge badge-info">{{ strtoupper($locale) }}</span></h3>
                    <form method="GET" class="form-inline">
                        <label class="mr-2 mb-0">Language:</label>
                        <select name="locale" class="form-control form-control-sm" onchange="this.form.submit()">
                            @foreach($languages as $language)
                                <option value="{{ $language->code }}" {{ $locale == $language->code ? 'selected' : '' }}>
                                    {{ $language->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="p-3 border-bottom bg-light">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="mb-1 font-weight-bold small">New Key</label>
                                <input type="text" id="newKey" class="form-control form-control-sm" placeholder="e.g. About Us">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-1 font-weight-bold small">Translation Value</label>
                                <input type="text" id="newValue" class="form-control form-control-sm" placeholder="e.g. আমাদের সম্পর্কে">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success btn-sm btn-block" id="addBtn">
                                    <i class="fas fa-plus"></i> Add Key
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 border-bottom">
                        <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search keys or values...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm mb-0" id="translationTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:35%">Key</th>
                                    <th>Translation Value</th>
                                    <th style="width:130px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($translations as $key => $value)
                                <tr data-key="{{ $key }}">
                                    <td class="align-middle">
                                        <code class="text-dark small">{{ $key }}</code>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm value-input" value="{{ $value }}">
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary btn-xs save-btn" title="Save">
                                            <i class="fas fa-save"></i> Save
                                        </button>
                                        <button class="btn btn-danger btn-xs delete-btn ml-1" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No translation keys found for this language.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted small">
                    Total keys: <strong>{{ count($translations) }}</strong>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('additional_scripts')
<script>
$(document).ready(function () {

    var locale = '{{ $locale }}';
    var updateUrl = '{{ route("admin.translation.update") }}';
    var destroyUrl = '{{ route("admin.translation.destroy") }}';
    var csrfToken = '{{ csrf_token() }}';

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });

    function showToast(message, type) {
        if (window.toastr) {
            toastr[type](message);
        } else {
            alert(message);
        }
    }

    // Search/filter
    $('#searchInput').on('keyup', function () {
        var q = $(this).val().toLowerCase();
        $('#translationTable tbody tr').each(function () {
            var rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.indexOf(q) > -1);
        });
    });

    // Save existing translation
    $(document).on('click', '.save-btn', function () {
        var btn = $(this);
        var row = btn.closest('tr');
        var key = row.data('key');
        var value = row.find('.value-input').val();

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: { locale: locale, key: key, value: value },
            success: function (response) {
                if (response.success) {
                    showToast('Saved successfully!', 'success');
                } else {
                    showToast(response.message || 'Error saving.', 'error');
                }
            },
            error: function (xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : 'Error saving translation. Check file permissions on server.';
                showToast(msg, 'error');
            },
            complete: function () {
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Save');
            }
        });
    });

    // Delete translation key
    $(document).on('click', '.delete-btn', function () {
        var btn = $(this);
        var row = btn.closest('tr');
        var key = row.data('key');

        if (!confirm('Delete key "' + key + '"?')) return;

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: destroyUrl,
            method: 'DELETE',
            data: { locale: locale, key: key },
            success: function (response) {
                if (response.success) {
                    row.fadeOut(300, function () { $(this).remove(); });
                    showToast('Key deleted.', 'success');
                } else {
                    showToast(response.message || 'Error deleting.', 'error');
                }
            },
            error: function (xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : 'Error deleting key. Check file permissions on server.';
                showToast(msg, 'error');
                btn.prop('disabled', false).html('<i class="fas fa-trash"></i>');
            }
        });
    });

    // Add new key
    $('#addBtn').click(function () {
        var key   = $('#newKey').val().trim();
        var value = $('#newValue').val().trim();

        if (!key || !value) {
            showToast('Both Key and Value are required.', 'warning');
            return;
        }

        var btn = $(this).prop('disabled', true).text('Adding...');

        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: { locale: locale, key: key, value: value },
            success: function (response) {
                if (response.success) {
                    showToast('Key added successfully!', 'success');
                    // Append new row to table
                    var newRow = '<tr data-key="' + $('<div>').text(key).html() + '">' +
                        '<td class="align-middle"><code class="text-dark small">' + $('<div>').text(key).html() + '</code></td>' +
                        '<td><input type="text" class="form-control form-control-sm value-input" value="' + $('<div>').text(value).html() + '"></td>' +
                        '<td class="text-center align-middle">' +
                        '<button class="btn btn-primary btn-xs save-btn" title="Save"><i class="fas fa-save"></i> Save</button> ' +
                        '<button class="btn btn-danger btn-xs delete-btn ml-1" title="Delete"><i class="fas fa-trash"></i></button>' +
                        '</td></tr>';
                    // Remove "no keys" row if present
                    $('#translationTable tbody tr td[colspan]').closest('tr').remove();
                    $('#translationTable tbody').append(newRow);
                    $('#newKey').val('');
                    $('#newValue').val('');
                } else {
                    showToast(response.message || 'Error adding key.', 'error');
                }
            },
            error: function (xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : 'Error adding key. Check file permissions on server (chmod -R 775 lang/).';
                showToast(msg, 'error');
            },
            complete: function () {
                btn.prop('disabled', false).html('<i class="fas fa-plus"></i> Add Key');
            }
        });
    });

});
</script>
@endsection
