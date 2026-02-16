<div class="modal fade" id="loginModal" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg login-modal" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-12 d-none d-md-block col-md-6 login-banner">
                        <div class="login-banner-img">
                            <h3 class="login-banner-title">
                                Raise more with us
                            </h3>
                            {{-- <p class="login-banner-subtitle">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lobortis maximus nunc, ac rhoncus odio congue quis. Sed ac semper orci, eu porttitor lacus.
              </p> --}}
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="login-form">
                            <div class="login-form-content">
                                <form action="{{ route('login') }}" method="POST" id="login-form">
                                    @csrf
                                    <div class="form-group d-flex">
                                        <b class="login-title">Sign In</b>
                                    </div>
                                    <div class="form-group d-flex login_sign_in_div">
                                        <label class="form-label">Sign in With</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact-type"
                                                    id="contact-email" value="email">
                                                <label class="form-check-label" for="contact-email">Email</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact-type"
                                                    id="contact-mobile" value="mobile">
                                                <label class="form-check-label" for="contact-mobile">Mobile</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group contact-mobile">
                                        <label class="form-label" for="mobile">Mobile Number</label>
                                        <input type="text" class="form-control" id="login-mobile" name="mobile"
                                            placeholder="Enter your mobile number">
                                    </div>
                                    <div class="form-group contact-email">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control" id="login-email" name="email"
                                            placeholder="Enter your email">
                                    </div>
                                    <div class="form-group auth-type">
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="auth-type"
                                                    id="auth-otp" value="otp">
                                                <label class="form-check-label" for="auth-otp">OTP</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="auth-type"
                                                    id="auth-password" value="password">
                                                <label class="form-check-label" for="auth-password">Password</label>
                                                <div id="confirm-password-message" style="color: red; display: none;">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group auth-otp">
                                        <label class="form-label" for="otp">OTP</label>
                                        <div class="password_input">
                                            <input type="password" class="form-control" id="otp" name="otp"
                                                placeholder="Enter OTP">
                                            <div class="password_eye">
                                                <img src="{{ asset('web-assets/css/eye-regular.svg') }}"
                                                    alt="Password eye">
                                                <img src="{{ asset('web-assets/css/eye-slash-regular.svg') }}"
                                                    alt="Password eye slash">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group auth-password">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="password_input">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Enter Password">
                                            <div class="password_eye">
                                                <img src="{{ asset('web-assets/css/eye-regular.svg') }}"
                                                    alt="Password eye">
                                                <img src="{{ asset('web-assets/css/eye-slash-regular.svg') }}"
                                                    alt="Password eye slash">
                                            </div>
                                        </div>
                                        <div id="login-password-message" style="color: red; display: none;"></div>
                                    </div>

                                    <div class="login_form_submit_btn form-group d-flex w-100">
                                        <button type="submit" class="btn submit-btn">Sign In</button>
                                    </div>

                                    <div class="form-group login_btn">
                                        <a href="#" data-toggle="modal" data-dismiss="modal"
                                            data-target="#forgetPasswordModal">Forgot Password?</a>
                                    </div>
                                    <div class="form-group login_btn">
                                        Don't have an account?
                                        <div class="button-new">
                                            <a href="#" class="login-form-link" data-toggle="modal"
                                                data-dismiss="modal" data-target="#signupModal">Sign up</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
