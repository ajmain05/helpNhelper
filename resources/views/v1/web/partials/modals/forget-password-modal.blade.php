<div class="modal fade" id="forgetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgetPasswordModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg login-modal" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6 login-banner">
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
                                <form action="#" method="POST" id="forget-password-form">
                                    @csrf
                                    <div class="form-group d-flex login_sign_in_div">
                                        <label class="form-label">Send reset link to</label>
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

                                    <div class="form-group input-email">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control mb-0" id="login-email" name="email"
                                            placeholder="Enter your email">
                                    </div>
                                    <div class="form-group input-mobile">
                                        <label class="form-label" for="mobile">Mobile</label>
                                        <input type="text" class="form-control mb-0" id="login-mobile" name="mobile"
                                            placeholder="Enter your mobile number">
                                    </div>
                                    <div class="login_form_submit_btn form-group forgot_pass_btn d-flex w-100">
                                        <button type="submit" class="btn submit-btn">Submit</button>
                                    </div>
                                    <div class="form-group log_in_btn">
                                        Already have an account?
                                        <div class="button-new">
                                            <a href="#" class="signup-form-link" data-dismiss="modal"
                                                data-toggle="modal" data-target="#loginModal">Sign
                                                In</a>
                                        </div>
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
