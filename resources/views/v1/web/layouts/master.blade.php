<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('web-assets/icons/favicon.svg') }}" type="image/svg+xml">
    @if (isset($campaign->title) && isset($setCampaign))
        <meta property="og:title" content="{{ $campaign->title }}" />
        <meta property="twitter:title" content="{{ $campaign->title }}" />
    @else
        <meta property="og:title" content="Help N Helper" />
        <meta name="twitter:title" content="Help N Helper" />
    @endif
    @if (isset($campaign->photo) && isset($setCampaign))
        <meta property="og:image" content="{{ asset($campaign->photo) }}" />
        <meta property="twitter:image" content="{{ asset($campaign->photo) }}" />
    @else
        <meta property="og:image" content="{{ asset('web-assets/logo.jpeg') }}" />
        <meta name="twitter:image" content="{{ asset('web-assets/logo.jpeg') }}" />
    @endif
    @if (isset($campaign->short_description) && isset($setCampaign))
        <meta property="og:description" content="{{ $campaign->short_description }}" />
        <meta property="twitter:description" content="{{ $campaign->short_description }}" />
    @else
        <meta name="og:description"
            content="A simple platform for Help Seekers, Donors and Volunteers from any part of the world. You can request for fund stating a particular need regardless of race, ethnicity, nationality, caste, religion, belief, gender or other status." />
        <meta name="twitter:description"
            content="A simple platform for Help Seekers, Donors and Volunteers from any part of the world. You can request for fund stating a particular need regardless of race, ethnicity, nationality, caste, religion, belief, gender or other status." />
    @endif
    <meta property="og:site_name" content="Help N Helper" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <title> Help N Helper </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href='https://fonts.googleapis.com/css?family=Philosopher' rel='stylesheet'>
    {{-- <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'> --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    {{-- <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all-2.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin-assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin-assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin-assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- SweetAlert -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/sweetalert2/sweetalert2.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('web-assets/plugins/owl-carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web-assets/plugins/owl-carousel/dist/assets/owl.theme.default.min.css') }}">
    <!-- Plyer -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

    {{-- Swiper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('web-assets/css/styles-10.css') }}">

    @hasSection('additional_styles')
        @yield('additional_styles')
    @endif
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Header -->
        {{-- @include('v1.web.partials.header') --}}
        <!-- /.Header -->
        <!-- Navbar -->
        {{-- @include('v1.web.partials.navbar') --}}
        @include('v1.web.partials.new-navbar')
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        @if (!Auth::user())
            @include('v1.web.partials.modals.signup-modal')
            @include('v1.web.partials.modals.login-modal')
            @include('v1.web.partials.modals.forget-password-modal')
        @endif
        <!-- /.content-wrapper -->


        {{-- Popup Overlay on signup submission --}}

        @include('v1.web.partials.modals.popup')


        <!-- Main Footer -->
        {{-- @include('v1.web.partials.footer') --}}
        @include('v1.web.partials.new-footer')
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
    {{-- Plyr --}}
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    {{-- Owl Carousel --}}
    <script src="{{ asset('web-assets/plugins/owl-carousel/dist/owl.carousel.min.js') }}"></script>

    <script>
        // Client side validation: document, image
        function validateFile(fileInput, errorMessage, maxSize, allowedFormats, checkRules) {

            errorMessage.textContent = '';

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];


                // Rule 1: Check file format
                if (checkRules.includes(1) && !allowedFormats.includes(file.type)) {
                    errorMessage.textContent = `Invalid file format.`;
                    return;
                }
                // Rule 2: Check file size
                if (checkRules.includes(2) && file.size > (maxSize * 1024 * 1024)) {
                    errorMessage.textContent = `File size limit exceeds. Please upload a smaller image.`;
                    return;
                }
            } else {
                errorMessage.textContent = 'Please select an file to upload.';
                return;
            }
        }
        const fileInput = document.querySelector('input[name="auth_file"]');
        const errorMessage = document.getElementById('error-message-nid');
        const allowedFormats = ['application/pdf', 'image/jpeg', 'image/png'];

        if (fileInput)
            fileInput.addEventListener("change", () => validateFile(fileInput, errorMessage, 1, allowedFormats, [1, 2]));

        // Reduce Image size
        const MAX_WIDTH = 450;
        const MAX_HEIGHT = 600;

        const image_input_1 = document.querySelector('input[name="photo"]');
        if (image_input_1)
            image_input_1.addEventListener("change", () => {
                const temp_message = document.getElementById('error-message-profile');
                const tempAllowedFormats = ['image/jpeg', 'image/png'];
                validateFile(image_input_1, temp_message, 0.5, tempAllowedFormats, [1]);
                reduceImageSize(image_input_1, 450, 600);
            });

        const image_input_2 = document.querySelector('input[name="license_image"]');
        if (image_input_2)
            image_input_2.addEventListener("change", () => {
                const temp_message = document.getElementById('error-message-license');
                const tempAllowedFormats = ['image/jpeg', 'image/png'];
                validateFile(image_input_2, temp_message, 1, tempAllowedFormats, [1]);
                reduceImageSize(image_input_2, 700, 933)
            });


        function reduceImageSize(event, MAX_WIDTH = 450, MAX_HEIGHT = 600) {
            const file = event.files[0]; // get the file
            const blobURL = URL.createObjectURL(file);
            const img = new Image();
            img.src = blobURL;

            img.onload = function() {
                const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
                const canvas = document.createElement("canvas");
                canvas.width = newWidth;
                canvas.height = newHeight;
                const ctx = canvas.getContext("2d");
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = "high";
                ctx.drawImage(img, 0, 0, newWidth, newHeight);

                canvas.toBlob((blob) => {
                    // Handle the compressed image

                    // Create a new file from the blob
                    const compressedFile = new File([blob], file.name, {
                        type: blob.type,
                    });

                    // Set the compressed file to the input field
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(compressedFile);
                    event.files = dataTransfer.files;
                }, 'image/jpeg', 0.99);
            };
        }

        function calculateSize(img, maxWidth, maxHeight) {
            let width = img.width;
            let height = img.height;

            // calculate the width and height, constraining the proportions
            if (width > height) {
                if (width > maxWidth) {
                    height = Math.round((height * maxWidth) / width);
                    width = maxWidth;
                }
            } else {
                if (height > maxHeight) {
                    width = Math.round((width * maxHeight) / height);
                    height = maxHeight;
                }
            }
            return [width, height];
        }

        function readableBytes(bytes) {
            const i = Math.floor(Math.log(bytes) / Math.log(1024)),
                sizes = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];

            return (bytes / Math.pow(1024, i)).toFixed(2) + " " + sizes[i];
        }

        // Password show/hidden
        $(".password_eye").click(function() {
            $(this).toggleClass("hidden");
            var input = $(this).closest(".password_input").find("input");
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        // Client side validation: password

        $('#signup-form input[name="password"]').on('blur', function() {
            var password = $(this).val();
            var messageElement = $('#password-message');

            // Check if the password is longer than 8 characters
            if (password.length < 8) {
                messageElement.text('Password must be longer than 7 characters.');
                messageElement.show(); // Show the message
                $(this).css('border-color', 'red'); // Optional: Change border color
                $(this).css('margin-bottom', '10px');
            } else {
                messageElement.text(''); // Clear the message
                messageElement.hide(); // Hide the message
                $(this).css('border-color', ''); // Reset border color
            }
        });
        $('#signup-form input[name="password_confirmation"]').on('blur', function() {
            var password = $(this).val();
            var messageElement = $('#confirm-password-message');

            // Check if the password is longer than 8 characters
            if (password.length < 8) {
                messageElement.text('Password must be longer than 7 characters.');
                messageElement.show(); // Show the message
                $(this).css('border-color', 'red'); // Optional: Change border color
                $(this).css('margin-bottom', '10px');
            } else {
                messageElement.text(''); // Clear the message
                messageElement.hide(); // Hide the message
                $(this).css('border-color', ''); // Reset border color
            }
        });

        $('#login-form input[name="password"]').on('blur', function() {
            var password = $(this).val();
            var messageElement = $('#login-password-message');

            // Check if the password is longer than 8 characters
            if (password.length < 8) {
                messageElement.text('Password must be longer than 7 characters.');
                messageElement.show(); // Show the message
                $(this).css('border-color', 'red'); // Optional: Change border color
                $(this).css('margin-bottom', '10px');
            } else {
                messageElement.text(''); // Clear the message
                messageElement.hide(); // Hide the message
                $(this).css('border-color', ''); // Reset border color
            }
        });

        // Get Division, District, Upazilla
        $(document).ready(function() {
            if ($('.signup-form-select2-division').length) {
                const selectedDivisionValue = $('.signup-form-select2-division')[0].value;
                let url = `{{ route('home.districts', ['division_id' => ':id']) }}`.replace(':id',
                    selectedDivisionValue);
                $.get(url, (data, status) => {
                    mapDistrict = '';
                    mapUpazila = '';
                    let selectedUpazillaId =
                        `{{ isset(Auth::user()->upazila->id) ? Auth::user()->upazila->id : '' }}`;
                    let selectedDistrictId =
                        `{{ isset(Auth::user()->upazila->district->id) ? Auth::user()->upazila->district->id : '' }}`;
                    data.data.forEach((element, index) => {
                        if (selectedDistrictId == element.id || (selectedDistrictId == '' &&
                                index == 0)) {
                            let url = `{{ route('home.upazilas', ['district_id' => ':id']) }}`
                                .replace(
                                    ':id', element.id);
                            $.get(url, (data, status) => {
                                data.data.forEach(element => {

                                    let isSelected = selectedUpazillaId == element
                                        .id ? 'selected' : '';
                                    mapUpazila +=
                                        `<option value=${element.id} ${isSelected}>${element.name}</option>`;
                                });
                                $('.signup-form-select2-upazila').html(mapUpazila);
                            });
                        }
                        let isSelected = selectedDistrictId == element.id ? 'selected' : '';
                        mapDistrict +=
                            `<option value=${element.id} ${isSelected}>${element.name}</option>`;
                    });
                    $('.signup-form-select2-district-new').html(mapDistrict);

                    $('.signup-form-select2-upazila').html(mapUpazila);
                });

                // Campaing card link

                // $('#card-campaign').click(function() {
                //     var url = $(this).data('url');
                //     window.location.href = url;
                // });

                // Select district dynamically based on selected division




                $('.signup-form-select2-division').on('change', function() {
                    // Get the selected value
                    const selectedValue = $(this).val();
                    let url = `{{ route('home.districts', ['division_id' => ':id']) }}`.replace(':id',
                        selectedValue);
                    $.get(url, (data, status) => {
                        mapDistrict = '';
                        data.data.forEach((element, index) => {
                            if (index == 0) {
                                const selectedValue = element.id;
                                let url =
                                    `{{ route('home.upazilas', ['district_id' => ':id']) }}`
                                    .replace(
                                        ':id', selectedValue);
                                $.get(url, (data, status) => {
                                    mapUpazila = '';
                                    data.data.forEach(element => {
                                        mapUpazila +=
                                            `<option value=${element.id}>${element.name}</option>`;
                                    });
                                    $('.signup-form-select2-upazila').html(
                                        mapUpazila);
                                });
                            }
                            mapDistrict +=
                                `<option value=${element.id}>${element.name}</option>`;
                        });
                        $('.signup-form-select2-district-new').html(mapDistrict);

                        $('.signup-form-select2-upazila').html(mapUpazila);
                    });
                });

                $('.signup-form-select2-district-new').on('change', function() {
                    // Get the selected value
                    const selectedValue = $(this).val();
                    let url = `{{ route('home.upazilas', ['district_id' => ':id']) }}`.replace(':id',
                        selectedValue);
                    $.get(url, (data, status) => {
                        mapUpazila = '';
                        data.data.forEach(element => {
                            mapUpazila +=
                                `<option value=${element.id}>${element.name}</option>`;
                        });
                        $('.signup-form-select2-upazila').html(mapUpazila);
                    });
                });
            }
        });

        // $('body').on('shown.bs.modal', '.modal', function() {
        //     $(this).find('select').each(function() {
        //         var dropdownParent = $(document.body);
        //         if ($(this).parents('.modal.in:first').length !== 0)
        //             dropdownParent = $(this).parents('.modal.in:first');
        //         $(this).select2({
        //             dropdownParent: dropdownParent
        //             // ...
        //         });
        //     });
        // });
        // $('.signup-form-select2-division').select2({
        //     dropdownParent: $('.signup-form-select2-division').parent()
        // });
        // $('.signup-form-select2-district-new').select2();
        // $('.signup-form-select2-upazila').select2();

        $(".select2").each((_i, e) => {
            var $e = $(e);
            $e.select2({
                dropdownParent: $e.parent()
            });
        });
        window.onload = function() {
            const campaignCard = document.querySelectorAll('.current-campaign-card');
            campaignCard.forEach((item) => {
                item.addEventListener("click", (e) => {
                    var campaignCard = e.target.closest('.current-campaign-card');
                    var url = campaignCard.getAttribute("data-url");
                    window.location.href = url;
                })
            })
        }

        const Toast = Swal.mixin({
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: 'swal-wide',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        $('#loginModal').on('shown.bs.modal', function() {
            document.body.classList.add('modal-open');
        });
        $('#signupModal').on('shown.bs.modal', function() {
            document.body.classList.add('modal-open');
        });
        $(function() {
            $('.signup-form-select2').select2({
                minimumResultsForSearch: Infinity
            });
        });
        $('#same_present').change(function() {
            if (this.checked) {
                $('#present_address').val($('#permanent_address').val());
            }
        });
        $("input[type='radio'][name='type']").change(function() {
            if (this.checked && (this.value === 'donor' || this.value === 'corporate-donor')) {
                $('.secondary-info').hide();
            }
            if (this.checked && (this.value !== 'donor' && this.value !== 'corporate-donor')) {
                $('.secondary-info').show();
            }
            if (this.checked && this.value === 'organization') {
                $('.organization-info').show();
                $('.other_address').hide();
            }
            if (this.checked && this.value !== 'organization') {
                $('.organization-info').hide();
                $('.other_address').show();
            }
        });
        $("input[type='radio'][name='contact-type']").change(function() {
            $('.auth-type').show();
            if (this.checked && this.value === 'mobile') {
                $('.contact-email').hide();
                $('.contact-mobile').show();
            }
            if (this.checked && this.value === 'email') {
                $('.contact-mobile').hide();
                $('.contact-email').show();
            }
        });
        $("input[type='radio'][name='auth-type']").change(function() {
            if (this.checked && this.value === 'otp') {
                $('.auth-password').hide();
                let curForm = $(this).closest('form');
                let curSubmit = curForm.find('.submit-btn');
                //curSubmit.prop('disabled', true);
                curSubmit.text("Please wait...");
                let email = curForm.find('input[name="email"]').val();
                let mobile = curForm.find('input[name="mobile"]').val();
                let otpForm = new FormData();
                otpForm.append('_token', '{{ csrf_token() }}');
                if (email) {
                    otpForm.append('email', email);
                    otpForm.delete('mobile');
                }
                if (mobile) {
                    otpForm.append('mobile', mobile);
                    otpForm.delete('email');
                }
                // for (let [key, value] of otpForm.entries()) {
                //     console.log(key, value);
                // }
                // return;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.otp') }}',
                    data: otpForm,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.auth-otp').show();
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                        curSubmit.prop('disabled', false);
                        curSubmit.text("Sign In");
                    },
                    error: function(response) {
                        curSubmit.prop('disabled', false);
                        Toast.fire({
                            icon: "error",
                            title: response.responseJSON.message
                        });
                        curSubmit.text("Sign In");
                    }
                });
            }
            if (this.checked && this.value === 'password') {
                $('.auth-otp').hide();
                $('.auth-password').show();
            }
        });
        $('#signup-form').submit(function(e) {
            e.preventDefault();

            // Password checking
            let confirm_password = $('#signup-form input[name="password_confirmation"]');
            let password = $('#signup-form input[name="password"]');
            if (password.val().length < 8 || confirm_password.val().length < 8)
                return;
            if (password.val() != confirm_password.val()) {
                Toast.fire({
                    icon: "error",
                    title: "Password does not match"
                });

                password.css('border-color', 'red');
                confirm_password.css('border-color', 'red');
                return;
            }

            // Popup overlay
            $('#overlay').show();
            $('#popup').show();

            $(this).find('.submit-btn').prop('disabled', true);
            // $(this).find('.submit-btn').text("Please wait...");
            let form = $(this);
            let url = '{{ route('user.request') }}';
            let data = new FormData(form[0]);
            // console.log(data);
            if ($('#terms').is(':checked')) {
                data.append('terms', 1);
            }

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var percentComplete = (e.loaded / e.total) * 100;
                            // $('#progress-bar').width(percentComplete + '%');
                            // console.log(percentComplete);
                            $('.progress-bar').css('width', percentComplete + '%').attr(
                                'aria-valuenow', percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });
                    form[0].reset();
                    form.find('.submit-btn').prop('disabled', false);
                    // form.find('.submit-btn').text("Create Account");
                    $('#signupModal').modal('hide');
                    $('#overlay').hide();
                    $('#popup').hide();
                    $('.progress-bar').css('width', '0%').attr('aria-valuenow',
                        0); // Reset progress bar
                },
                error: function(response) {
                    form.find('.submit-btn').prop('disabled', false);
                    // form.find('.submit-btn').text("Create Account");
                    $('#overlay').hide();
                    $('#popup').hide();
                    $('.progress-bar').css('width', '0%').attr('aria-valuenow',
                        0); // Reset progress bar
                    Toast.fire({
                        icon: "error",
                        title: response.responseJSON.message
                    });
                }
            });
        });
        $('.login-form').submit(function(e) {
            let password = $('#login-form input[name="password"]');
            let authType = $('#login-form input[name="auth-type"]');
            console.log(password.val());

            if (authType.val() == 'password' && password.val().length < 8) {
                e.preventDefault();
                password.css('border-color', 'red');
                return;
            }
        });
        let formEmail = $('#forget-password-form .input-email');
        let formMobile = $('#forget-password-form .input-mobile');
        formMobile.hide();
        formEmail.hide();
        $('#forget-password-form input[name="contact-type"]').change(function() {
            if (this.value == 'email') {
                formMobile.hide();
                // formMobile.val('');
                formEmail.show();
            } else {
                formMobile.show();
                formEmail.hide();
                // formEmail.val('');
            }
        });
        $('.contact-email').hide();
        $('.contact-mobile').hide();
        $('.auth-type').hide();
        $('.auth-password').hide();
        $('.auth-otp').hide();
        $('.secondary-info').hide();
        @if (session('error'))
            Toast.fire({
                icon: "error",
                title: "{{ session('error') }}"
            });
        @endif
        @if (session('verifiedMessage'))
            Toast.fire({
                icon: "success",
                title: "{{ session('verifiedMessage') }}"
            });
        @endif

        // Forget password request

        $('#forget-password-form').submit(function(e) {
            e.preventDefault();


            let form = $(this);
            let url = '{{ route('user.forgetPassword') }}';
            let data = new FormData(form[0]);
            form.find('.submit-btn').text("Please wait...");
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    // console.log(response);
                    $('#forgetPasswordModal').modal('hide');
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });
                    form[0].reset();
                    form.find('.submit-btn').text("Submit");
                },
                error: function(response) {
                    Toast.fire({
                        icon: "error",
                        title: response.responseJSON.message
                    });
                    form.find('.submit-btn').text("Submit");
                }
            });
        });
    </script>
    @hasSection('additional_scripts')
        @yield('additional_scripts')
    @endif
</body>

</html>
