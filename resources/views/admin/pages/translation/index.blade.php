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
                <div class="card-header">
                    <h3 class="card-title">Manage Translations</h3>
                    <div class="card-tools">
                        <form method="GET" class="form-inline">
                            <label class="mr-2">Select Language:</label>
                            <select name="locale" class="form-control" onchange="this.form.submit()">
                                @foreach($languages as $language)
                                    <option value="{{ $language->code }}" {{ $locale == $language->code ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="translationTable">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($translations as $key => $value)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>
                                    <input type="text" class="form-control value-input" data-key="{{ $key }}" value="{{ $value }}">
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm save-btn" data-key="{{ $key }}">Save</button>
                                </td>
                            </tr>
                            @endforeach
                            
                            {{-- Add new key row --}}
                            <tr class="bg-light">
                                <td>
                                    <input type="text" id="newKey" class="form-control" placeholder="New Key">
                                </td>
                                <td>
                                    <input type="text" id="newValue" class="form-control" placeholder="Value">
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm" id="addBtn">Add</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('additional_scripts')
<script>
    $(document).ready(function() {
        // CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
            }
        });

        // Save existing translation
        $('.save-btn').click(function() {
            var btn = $(this);
            var key = btn.data('key');
            var value = btn.closest('tr').find('.value-input').val();
            var locale = '{{ $locale }}';

            $.ajax({
                url: '{{ route("admin.translation.update") }}',
                method: 'POST',
                data: {
                    locale: locale,
                    key: key,
                    value: value
                },
                success: function(response) {
                    if(response.success) {
                        alert('Saved successfully!');
                        // Optional: Toastr success
                    }
                },
                error: function() {
                    alert('Error saving translation.');
                }
            });
        });

        // Add new translation
        $('#addBtn').click(function() {
            var key = $('#newKey').val();
            var value = $('#newValue').val();
            var locale = '{{ $locale }}';

            if(key === '' || value === '') {
                alert('Key and Value are required');
                return;
            }

            $.ajax({
                url: '{{ route("admin.translation.update") }}',
                method: 'POST',
                data: {
                    locale: locale,
                    key: key,
                    value: value
                },
                success: function(response) {
                    if(response.success) {
                        location.reload(); 
                    }
                },
                error: function() {
                    alert('Error adding translation.');
                }
            });
        });
    });
</script>
@endsection
