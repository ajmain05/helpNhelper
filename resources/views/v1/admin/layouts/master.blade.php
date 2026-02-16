<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Help N Helper | Admin Panel</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    {{-- <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all-2.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin-assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin-assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- SweetAlert -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/sweetalert2/sweetalert2.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/custom-2.css') }}">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('v1.admin.partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('v1.admin.partials.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="admin-content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->



        <!-- Main Footer -->
        @include('v1.admin.partials.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('admin-assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Bootstrap Switch -->
    <script src="{{ asset('admin-assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>


    <!-- Select2 -->
    <script src="{{ asset('admin-assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Sweetalert 2 -->
    <script src="{{ asset('admin-assets/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <!-- CKeditor -->
    <script src="https://cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>

    {{-- Summernote --}}
    <script src="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin-assets/dist/js/adminlte.min.js') }}"></script>


    <script>
        // Get Division, District, Upazilla

        // $(document).ready(function() {
        if ($('.signup-form-select2-division-new').length) {
            const selectedDivisionValue = $('.signup-form-select2-division-new')[0].value;
            let url = `{{ route('home.districts', ['division_id' => ':id']) }}`.replace(':id',
                selectedDivisionValue);
            $.get(url, (data, status) => {
                mapDistrict = '';
                mapUpazila = '';

                let selectedUpazillaId =
                    `{{ isset($userRequest->upazila->id) ? $userRequest->upazila->id : '' }}`;
                let selectedDistrictId =
                    `{{ isset($userRequest->upazila->district->id) ? $userRequest->upazila->district->id : '' }}`;
                data.data.forEach((element, index) => {
                    if (selectedDistrictId == element.id || index == 0) {
                        const selectedValue = element.id;
                        let url = `{{ route('home.upazilas', ['district_id' => ':id']) }}`
                            .replace(
                                ':id', selectedValue);
                        $.get(url, (data, status) => {
                            data.data.forEach((element, index) => {
                                let isSelected = selectedUpazillaId == element
                                    .id ? 'selected' : '';
                                mapUpazila +=
                                    `<option value=${element.id} ${isSelected}>${element.name}</option>`;

                                if (index == 0) {
                                    let volunteersAvailable =
                                        `{{ isset($volunteers) ? true : false }}`;

                                    if (volunteersAvailable) {

                                        let newUrl =
                                            `{{ route('admin.seeker-application.volunteer.get.upazilla', ['upazila_id' => ':id']) }}`
                                            .replace(':id', element.id);
                                        $.get(newUrl, (data, status) => {
                                            mapVolunteers = '';
                                            data.data.forEach((element, index) => {
                                                mapVolunteers +=
                                                    `<option value="${element.id}">${element.name} (${element.email != null ? element.email : element.mobile})</option>`;
                                            });
                                            if (mapVolunteers == '')
                                                mapVolunteers =
                                                `<option value="">No volunteers are available in this area</option>`;
                                            $('.volunteer-select2').html(
                                                mapVolunteers);
                                        });
                                    }
                                }

                            });
                            $('.signup-form-select2-upazila-new').html(mapUpazila);
                        });
                    }
                    let isSelected = selectedDistrictId == element.id ? 'selected' : '';
                    mapDistrict +=
                        `<option value=${element.id} ${isSelected}>${element.name}</option>`;
                });
                $('.signup-form-select2-district-new').html(mapDistrict);
                $('.signup-form-select2-upazila-new').html(mapUpazila);

            });

            // Select district dynamically based on selected division

            $('.signup-form-select2-division-new').select2();
            $('.signup-form-select2-district-new').select2();
            $('.signup-form-select2-upazila-new').select2();
            $('.volunteer-select2').select2();


            $('.signup-form-select2-division-new').on('change', function() {
                // Get the selected value
                const selectedValue = $(this).val();
                let url = `{{ route('home.districts', ['division_id' => ':id']) }}`.replace(':id',
                    selectedValue);
                $.get(url, (data, status) => {
                    mapDistrict = '';

                    mapUpazila = '';
                    data.data.forEach((element, index) => {
                        if (index == 0) {
                            const selectedValue = element.id;
                            let url =
                                `{{ route('home.upazilas', ['district_id' => ':id']) }}`
                                .replace(
                                    ':id', selectedValue);
                            $.get(url, (data, status) => {
                                data.data.forEach((element, index) => {
                                    mapUpazila +=
                                        `<option value=${element.id}>${element.name}</option>`
                                        .replace(':id', element.id);
                                    if (index == 0) {
                                        let volunteersAvailable =
                                            `{{ isset($volunteers) ? true : false }}`;

                                        if (volunteersAvailable) {

                                            let newUrl =
                                                `{{ route('admin.seeker-application.volunteer.get.upazilla', ['upazila_id' => ':id']) }}`
                                                .replace(':id', element.id);
                                            $.get(newUrl, (data, status) => {
                                                mapVolunteers = '';
                                                data.data.forEach((element,
                                                    index) => {
                                                    mapVolunteers +=
                                                        `<option value="${element.id}">${element.name} (${element.email != null ? element.email : element.mobile})</option>`;
                                                });
                                                if (mapVolunteers == '')
                                                    mapVolunteers =
                                                    `<option value="">No volunteers are available in this area</option>`;
                                                $('.volunteer-select2')
                                                    .html(mapVolunteers);
                                            });
                                        }
                                    }
                                });
                                $('.signup-form-select2-upazila-new').html(mapUpazila);
                            });
                        }
                        mapDistrict +=
                            `<option value=${element.id}>${element.name}</option>`
                            .replace(':id', element.id);
                    });
                    $('.signup-form-select2-district-new').html(mapDistrict);

                });
            });

            $('.signup-form-select2-district-new').on('change', function() {
                // Get the selected value

                mapUpazila = '';
                const selectedValue = $(this).val();
                let url = `{{ route('home.upazilas', ['district_id' => ':id']) }}`.replace(':id',
                    selectedValue);
                $.get(url, (data, status) => {
                    data.data.forEach((element, index) => {
                        mapUpazila +=
                            `<option value=${element.id}>${element.name}</option>`;

                        if (index == 0) {
                            let volunteersAvailable =
                                `{{ isset($volunteers) ? true : false }}`;

                            if (volunteersAvailable) {

                                let newUrl =
                                    `{{ route('admin.seeker-application.volunteer.get.upazilla', ['upazila_id' => ':id']) }}`
                                    .replace(':id', element.id);
                                $.get(newUrl, (data, status) => {
                                    mapVolunteers = '';
                                    data.data.forEach((element,
                                        index) => {
                                        mapVolunteers +=
                                            `<option value="${element.id}">${element.name} (${element.email != null ? element.email : element.mobile})</option>`;
                                    });
                                    if (mapVolunteers == '')
                                        mapVolunteers =
                                        `<option value="">No volunteers are available in this area</option>`;
                                    $('.volunteer-select2').html(mapVolunteers);
                                });
                            }
                        }
                    });
                    $('.signup-form-select2-upazila-new').html(mapUpazila);
                });
            });


            let volunteersAvailable =
                `{{ isset($volunteers) ? true : false }}`;

            if (volunteersAvailable) {
                $('.signup-form-select2-upazila-new').on('change', function() {
                    const selectedValue = $(this).val();
                    let url =
                        `{{ route('admin.seeker-application.volunteer.get.upazilla', ['upazila_id' => ':id']) }}`
                        .replace(':id',
                            selectedValue);
                    let mapVolunteers = '';
                    $.get(url, (data, status) => {
                        data.data.forEach((element, index) => {
                            mapVolunteers +=
                                `<option value="${element.id}">${element.name} (${element.email != null ? element.email : element.mobile})</option>`;
                        });
                        console.log(mapVolunteers);
                        if (mapVolunteers == '')
                            mapVolunteers +=
                            `<option value="">No volunteers are available in this area</option>`;
                        $('.volunteer-select2').html(mapVolunteers);
                    });
                });
            }


        }
        // });
    </script>
    @hasSection('additional_scripts')
        @yield('additional_scripts')
    @endif
</body>

</html>
