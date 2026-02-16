<footer class="footer">
    {{-- <div class="container d-flex justify-content-center ">
        <div class="subscribe-container">
            <h2 class="subscribe-header">
                Overcome Ignorance and
                Fight for Equality
            </h2>
            <div class="subscribe-btn d-flex justify-content-center mt-5">
                <a href="#" class="btn  receive-btn ">
                    Receive News
                </a>
                <a href="{{ url('/current-campaigns') }}" class="btn donate-btn ">
                    Donate
                </a>
            </div>
        </div>
    </div>  --}}
    <div class="container">
        <div class="menu-container">
            <div class="row">
                <div class="col">
                    <ul class="footer-nav">
                        <b class="menu-header">
                            Navigation
                        </b>
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about-us') }}" class="nav-link">
                                About Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('faq') }}" class="nav-link">
                                FAQ
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                Contact Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Privacy Policy
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Terms & Conditions
                            </a>
                        </li> --}}
                    </ul>
                </div>
                <div class="col">
                    <ul class="footer-nav">
                        <b class="menu-header">
                            Apps
                        </b>
                        <li class="nav-item"><a
                                href="https://play.google.com/store/apps/details?id=com.codersLab.helpnhelper&pcampaignid=web_share"
                                class="nav-link" target="_blank">HelpNHelper Android App</a></li>
                        {{-- <li class="nav-item"><a href="#" class="nav-link">HelpNHelper IOS App</a></li> --}}
                    </ul>
                </div>
                {{-- <div class="col">
          <ul class="footer-nav">
            <b class="menu-header">
              What We Do
            </b>
            <li class="nav-item">
              <a href="#" class="nav-link">
                Encouraging Testing
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                Strengthening Advocacy
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                Sharing Information
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                Building Leadership
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                Engaging With Global Fund
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                Shining a Light
              </a>
            </li>
          </ul>
        </div> --}}
                <div class="col">
                    <ul class="footer-nav">
                        <b class="menu-header">
                            Legal
                        </b>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                General Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Privacy Policy
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Terms of Service
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <ul class="footer-nav">
                        {{-- <b class="menu-header">
              Talk to Us
            </b>
            <li class="nav-item">
              <a href="#" class="nav-link">
                support@ercom.com
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                +66 2399 1145
              </a>
            </li> --}}
                        <b class="menu-header">
                            ADDRESS
                        </b>

                        <li class="nav-item pb-20">
                            <a href="#" class="nav-link text-mobile-center" target="_blank">
                                Golam Ali Nazir Para,<br>Chandgaon, <br>Chittagong 4212, Bangladesh.
                            </a>
                        </li>
                        <b class="menu-header">
                            Contact Us
                        </b>
                        <li class="nav-item">
                            <a href="tel:+8801841040543" class="nav-link d-flex align-items-center" style="gap:8px;"
                                target="_blank">
                                <div class="d-flex"><img src="{{ asset('web-assets/icons/call.svg') }}" alt="Phone"
                                        style="width: 15px;"></div>
                                <div>+880 1841-040543</div>
                            </a>
                        </li>
                        <li class="nav-item footer_email">
                            <a href="mailto:shamsulhoquefoundation@gmail.com" class="nav-link d-flex align-items-center"
                                style="gap:8px;" target="_blank">
                                <div class="d-flex"><img src="{{ asset('web-assets/icons/email.svg') }}" alt="Email"
                                        style="width: 21px;"></div>
                                <div>shamsulhoquefoundation@gmail.com</div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.facebook.com/shamsulhoquefoundation/"
                                class="nav-link d-flex align-items-center" style="gap:8px;" target="_blank">
                                <div class="d-flex"><img src="{{ asset('web-assets/icons/facebook.svg') }}"
                                        alt="Email" style="width: 21px;"></div>
                                <div>Facebook</div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://x.com/ashfoundationbd" class="nav-link d-flex align-items-center"
                                style="gap:8px;" target="_blank">
                                <div class="d-flex"><img src="{{ asset('web-assets/icons/twitter.svg') }}"
                                        alt="Email" style="width: 21px;"></div>
                                <div>Twitter</div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.youtube.com/@AlhajShamsulHoqueFoundation"
                                class="nav-link d-flex align-items-center" style="gap:8px;" target="_blank">
                                <div class="d-flex"><img src="{{ asset('web-assets/icons/youtube.svg') }}"
                                        alt="Email" style="width: 18px;"></div>
                                <div>Youtube</div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://bd.linkedin.com/company/ashfbd" class="nav-link d-flex align-items-center"
                                style="gap:8px;" target="_blank">
                                <div class="d-flex"><img src="{{ asset('web-assets/icons/linkedin.svg') }}"
                                        alt="Email" style="width: 17px;"></div>
                                <div>Linkedin</div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer-divider"></div>
    </div>
    <div class="container footer-copyright">
        <div class="d-flex justify-content-between footer_copyright_div">
            <div class="footer_copyright_in_div">
                <p class="text-white">
                    © 2024 helpNhelper. All Rights Reserved.
                </p>
            </div>
            <div class="social-links">
                <a href="https://www.facebook.com/shamsulhoquefoundation/" class="social-link" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://x.com/ashfoundationbd" class="social-link" target="_blank">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="https://www.youtube.com/@AlhajShamsulHoqueFoundation/" class="social-link" target="_blank">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://bd.linkedin.com/company/ashfbd" class="social-link" target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
    </div>
    </div>
</footer>
