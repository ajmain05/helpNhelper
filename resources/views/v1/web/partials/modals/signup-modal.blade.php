<div class="modal fade" id="signupModal" role="dialog" aria-labelledby="signupModal" aria-hidden="true" tabindex="1">
    <div class="modal-dialog modal-dialog-centered  modal-lg signup-modal" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xl-7">
                        <div class="signup-form">
                            <div class="signup-form-header">
                                <h3 class="signup-form-title"><b>Welcome to helpNhelper</b></h3>
                                {{-- <p class="signup-form-subtitle">Already have an account? <a href="#"
                                        class="signup-form-link" data-dismiss="modal" data-toggle="modal"
                                        data-target="#loginModal">Log In</a>
                                </p> --}}

                                <div class="form-group log_in_btn">
                                    Already have an account?
                                    <div class="button-new">
                                        <a href="#" class="signup-form-link" data-dismiss="modal"
                                            data-toggle="modal" data-target="#loginModal">Sign
                                            In</a>
                                    </div>
                                </div>
                            </div>
                            <div class="signup-form-content">
                                <form action="#" method="POST" id="signup-form">
                                    @csrf
                                    <div class="primary-info">
                                        <div class="form-group">
                                            <label class="form-label">Create Account as</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="type"
                                                    id="volunteers" value="volunteer">
                                                <label class="form-check-label" for="volunteer">Volunteer</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="type"
                                                    id="seekers" value="seeker">
                                                <label class="form-check-label" for="seeker">Seeker</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="type"
                                                    id="donors" value="donor" checked>
                                                <label class="form-check-label" for="donor">Donor</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="type"
                                                    id="corporate-donors" value="corporate-donor" checked>
                                                <label class="form-check-label" for="corporate-donor">Corporate
                                                    Donor</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="type"
                                                    id="organizations" value="organization">
                                                <label class="form-check-label" for="donor">Organization</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="name">Full Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Enter your full name" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">Email <span
                                                    class="text-red">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Enter your email" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="mobile">Mobile Number <span
                                                    class="text-red">*</span></label>
                                            <div class="hnh_signup_mobile_input">
                                                <div class="hnh_signup_img_container">
                                                    <div class="hnh_flag_img"><img
                                                            src="{{ asset('web-assets\Flag-Bangladesh.jpg') }}"
                                                            alt="Bangladesh Flag"></div>
                                                    <div>+88</div>
                                                </div>
                                                <input type="text" class="form-control" id="mobile"
                                                    name="mobile" placeholder="Enter your mobile number" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="password">Password <span
                                                            class="text-red">*</span></label>
                                                    <div class="password_input">
                                                        <input type="password" class="form-control" id="password"
                                                            name="password" placeholder="Enter password" required>
                                                        <div class="password_eye">
                                                            <img src="{{ asset('web-assets/css/eye-regular.svg') }}"
                                                                alt="Password eye">
                                                            <img src="{{ asset('web-assets/css/eye-slash-regular.svg') }}"
                                                                alt="Password eye slash">
                                                        </div>
                                                    </div>
                                                    <div id="password-message" style="color: red; display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="password_confirmation">Confirm
                                                        Password <span class="text-red">*</span></label>
                                                    <div class="password_input">
                                                        <input type="password" class="form-control"
                                                            id="password_confirmation" name="password_confirmation"
                                                            placeholder="Enter confirm password" required>
                                                        <div class="password_eye">
                                                            <img src="{{ asset('web-assets/css/eye-regular.svg') }}"
                                                                alt="Password eye">
                                                            <img src="{{ asset('web-assets/css/eye-slash-regular.svg') }}"
                                                                alt="Password eye slash">
                                                        </div>
                                                    </div>
                                                    <div id="confirm-password-message"
                                                        style="color: red; display: none;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="secondary-info">
                                        <div class="form-group">
                                            <label class="form-label" for="auth_file">NID/Birth
                                                Certificate/Passport (Max file size: 1MB) <span
                                                    class="text-red">*</span></label>
                                            <input type="file" class="form-control-file" id="auth_file"
                                                name="auth_file" accept=".jpg, .jpeg, .png, .pdf">
                                            <small>Supported file types: .pdf, .jpeg, .jpg, .png</small><br>
                                            <div id="error-message-nid" style="color: red;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="country">Country</label>
                                            <select class="form-control signup-form-select2" id="country"
                                                name="country">
                                                @foreach ($countries as $country)
                                                    <option value={{ $country->id }}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="division">Division <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control signup-form-select2-division select2"
                                                id="division" name="division">
                                                @foreach ($divisions as $division)
                                                    <option value={{ $division->id }}>{{ $division->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="district">District <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control signup-form-select2-district-new select2"
                                                name="district" id="district">
                                                {{-- <option value="">--Select--</option> --}}
                                                {{-- @foreach ($districts as $district)
                                                    
                                                    <option value={{ $district->id }}>{{ $district->name }}</option>
                                                    
                                                @endforeach --}}
                                                <option>Select Division first</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="upazila">Upazila <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control signup-form-select2-upazila select2"
                                                name="upazila" id="upazila">
                                                {{-- <option value="">--Select--</option> --}}
                                                {{-- @foreach ($upazilas as $upazila)
                                                    
                                                    <option value={{ $upazila->id }}>{{ $upazila->name }}</option>
                                                    
                                                @endforeach --}}
                                                <option>Select District first</option>
                                            </select>
                                        </div>
                                        <div class="other_address">
                                            <div class="form-group">
                                                <label class="form-label" for="permanent_address">Permanent
                                                    Address <span class="text-red">*</span></label>
                                                <textarea type="text" class="form-control" id="permanent_address" name="permanent_address"
                                                    placeholder="Enter your permanent address"></textarea>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="same_present">
                                                <label class="form-check-label" for="same_present">
                                                    Same as Permanent Address
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="present_address">Present Address <span
                                                        class="text-red">*</span></label>
                                                <textarea type="text" class="form-control" id="present_address" name="present_address"
                                                    placeholder="Enter your present address"></textarea>
                                            </div>
                                        </div>
                                        <div class="organization-info">
                                            <div class="form-group">
                                                <label class="form-label" for="office_address">Office
                                                    Address <span class="text-red">*</span></label>
                                                <textarea type="text" class="form-control" id="office_address" name="office_address"
                                                    placeholder="Enter your office address"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="license_no">License No <span
                                                        class="text-red">*</span></label>
                                                <input type="text" class="form-control" id="license_no"
                                                    name="license_no" placeholder="Enter your license no">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="license_image">License Image <span
                                                        class="text-red">*</span></label>
                                                <input type="file" class="form-control-file" id="license_image"
                                                    name="license_image" accept=".jpg, .jpeg, .png">
                                                <small>Supported file types: .jpeg, .jpg, .png</small><br>
                                                <div id="error-message-license" style="color: red;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="photo">Profile Image <span
                                                    class="text-red">*</span></label>
                                            <input type="file" class="form-control-file" id="photo"
                                                name="photo" accept=".jpg, .jpeg, .png, .gif, .bmp">
                                            <small>Supported file types: .jpeg, .jpg, .png</small><br>
                                            <div id="error-message-profile" style="color: red;"></div>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1"
                                            id="terms">
                                        <label class="form-check-label" for="terms">
                                            By creating an account, you agree to the <a href="#"
                                                class="signup-form-link">Terms of
                                                Service</a> and <a href="#" class="signup-form-link">Privacy
                                                Policy</a>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn submit-btn">Create Account</button>
                                    </div>
                                    <div class="form-group log_in_btn">
                                        Already have an account?
                                        <div class="button-new">
                                            <a href="#" class="signup-form-link" data-dismiss="modal"
                                                data-toggle="modal" data-target="#loginModal">Sign
                                                In</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-5 signup-banner">
                        <div class="signup-banner-img"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
