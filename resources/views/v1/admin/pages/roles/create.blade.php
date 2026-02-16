@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Role</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
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
                                <form enctype="multipart/form-data" action="{{ route('admin.role.store') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}"
                                            placeholder="Enter name" style="text-transform: lowercase;">
                                        @error('name')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input" id="selectAll">
                                            <label class="custom-control-label" for="selectAll">Select All</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="permission_ids">Permissions <span class="text-red">*</span></label>
                                        <select class="form-control select2 @error('permission_ids') is-invalid @enderror"
                                            data-placeholder="-- Select Permissions --" id="permission_ids" multiple
                                            name="permission_ids[]">
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('permission_ids')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
            $('.select2').select2({
                placeholder: {
                    id: '-1', // the value of the option
                    text: '-- Select Permissions --'
                }
            });
            $("#selectAll").click(function() {
                if ($("#selectAll").is(':checked')) {
                    $("#permission_ids > option").prop("selected", "selected");
                    $("#permission_ids").trigger("change");
                } else {
                    $("#permission_ids").val('').change();
                }
            });
        });
    </script>
@endsection
