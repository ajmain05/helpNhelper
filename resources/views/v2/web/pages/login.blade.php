<x-web-layout>
    <x-slot name="title">HelpNHelper - Login</x-slot>
    <x-login></x-login>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Password validation
                const passwordInput = document.querySelector(`input[type="password"]`);
                const toggleButton = document.querySelector('#togglePassword');
                const eyeIcon = toggleButton.querySelector('.eye-icon');
                const eyeOffIcon = toggleButton.querySelector('.eye-off-icon');

                toggleButton.addEventListener('click', function() {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIcon.classList.add('hidden');
                        eyeOffIcon.classList.remove('hidden');
                    } else {
                        passwordInput.type = 'password';
                        eyeIcon.classList.remove('hidden');
                        eyeOffIcon.classList.add('hidden');
                    }
                });

                // Select contact type
                const contactTypes = document.querySelectorAll(`input[type="radio"][name="contact-type"]`);

                contactTypes.forEach((contactType) => {
                    contactType.addEventListener('change', function() {
                        const emailInput = document.querySelector('#input-email');
                        const mobileInput = document.querySelector('#input-mobile');

                        if (this.value === 'email') {
                            emailInput.classList.remove("hidden");
                            emailInput.classList.add("block");

                            mobileInput.classList.remove("block");
                            mobileInput.classList.add("hidden");
                        } else if (this.value === 'mobile') {
                            emailInput.classList.add("hidden");
                            emailInput.classList.remove("block");

                            mobileInput.classList.add("block");
                            mobileInput.classList.remove("hidden");
                        }
                    });
                });

                // Select auth type
                const authTypes = document.querySelectorAll(`input[type="radio"][name="auth-type"]`);

                authTypes.forEach((authType) => {
                    authType.addEventListener('change', function() {
                        const passwordInput = document.querySelector('#input-password');

                        if (this.value === 'password') {
                            passwordInput.classList.remove("hidden");
                            passwordInput.classList.add("block");
                        } else if (this.value === 'otp') {
                            passwordInput.classList.add("hidden");
                            passwordInput.classList.remove("block");
                        }
                    });
                });

                // Otp
                document.querySelectorAll("input[type='radio'][name='auth-type']").forEach((radio) => {
                    radio.addEventListener('change', function() {
                        const authPassword = document.querySelector('#input-password');
                        const authOtp = document.querySelector('#input-otp');
                        const curForm = this.closest('form');
                        const curSubmit = curForm.querySelector('button[type="submit"]');
                        const errorMessage = curForm.querySelector(
                            '.error-message'); // Assuming a p tag with this class
                        const successMessage = curForm.querySelector(
                            '.success-message');

                        errorMessage.classList.add("hidden");
                        successMessage.classList.add("hidden");
                        if (this.checked && this.value === 'otp') {
                            authPassword.classList.add('hidden');
                            authOtp.classList.remove("hidden");
                            curSubmit.textContent = "Please wait...";

                            const email = curForm.querySelector('input[name="email"]').value;
                            const mobile = curForm.querySelector('input[name="mobile"]').value;

                            const otpForm = new FormData();
                            otpForm.append('_token', '{{ csrf_token() }}');
                            if (email) {
                                otpForm.append('email', email);
                            }
                            if (mobile) {
                                otpForm.append('mobile', mobile);
                            }

                            // Clear error message
                            errorMessage.textContent = '';

                            fetch('{{ route('user.otp') }}', {
                                    method: 'POST',
                                    body: otpForm,
                                    headers: {
                                        Accept: "application/json",
                                    },
                                })
                                .then((response) => {
                                    if (!response.ok) {
                                        return response.json().then((data) => {
                                            throw new Error(data.message ||
                                                'Something went wrong');
                                        });
                                    }
                                    return response.json();
                                })
                                .then((data) => {

                                    curSubmit.textContent = "Sign In";
                                    errorMessage.textContent = ''; // Clear error on success
                                    successMessage.textContent = data
                                        .message; // Clear error on success
                                    errorMessage.classList.add("hidden");
                                    successMessage.classList.remove("hidden");
                                })
                                .catch((error) => {
                                    curSubmit.textContent = "Sign In";
                                    errorMessage.textContent = 'Error: ' + error
                                        .message;
                                    errorMessage.classList.remove("hidden");
                                    successMessage.classList.add("hidden");
                                });
                        }

                        if (this.checked && this.value === 'password') {
                            authOtp.classList.add("hidden");
                            authPassword.classList.remove("hidden");
                        }
                    });
                });


            });
        </script>
    </x-slot>
</x-web-layout>
