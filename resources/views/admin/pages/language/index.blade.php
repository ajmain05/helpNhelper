@extends('v1.admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Languages</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Language</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.language.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="English" required>
                                </div>
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type="text" name="code" class="form-control" placeholder="en" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Language List</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($languages as $language)
                                    <tr>
                                        <td>{{ $language->id }}</td>
                                        <td>{{ $language->name }}</td>
                                        <td>{{ $language->code }}</td>
                                        <td>
                                            <a href="{{ route('admin.language.status', $language->id) }}" class="btn btn-sm {{ $language->status ? 'btn-success' : 'btn-danger' }}">
                                                {{ $language->status ? 'Active' : 'Inactive' }}
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.language.destroy', $language->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
