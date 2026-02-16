<style>
    .responsive-logo {
        height: auto;
        width: 100%;
        max-width: 45px;
    }

    .desktop-nav a:hover {
        color: rgb(39, 227, 106) !important;
    }

    @media (max-width: 1251px) {
        .desktop-nav {
            display: none !important;
        }

        .mobile-nav {
            display: block !important;
        }
    }

    @media (min-width: 1250px) {
        .desktop-nav {
            display: flex !important;
        }

        .mobile-nav {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .nav-wrapper {
            padding: 10px 24px !important;
        }

        .menu-links a {
            padding: 10px 18px !important;
            font-size: 0.875rem !important;
        }

        .auth-buttons a {
            padding: 10px 24px !important;
            font-size: 0.875rem !important;
        }

        .responsive-logo {
            max-width: 36px;
        }
    }

    @media (max-width: 480px) {
        .responsive-logo {
            max-width: 30px;
        }
    }
</style>

<header style="background-color: transparent; padding: 1rem 1.75rem; position: relative; z-index: 1;">
    <!-- DEBUG: Locale: {{ app()->getLocale() }}, Session: {{ session('locale') }}, Trans: {{ __('Home') }} -->
    <nav class="nav-wrapper"
        style="background-color: #ffffff57; color: white; border-radius: 100px; padding: 10px 40px; max-width: 1667px; margin: 0 auto;">
        <div style="padding: 0 2rem;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <!-- Logo -->
                <div style="flex-shrink: 0;">
                    <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 0.5rem;">
                        <img src="{{ asset('web-assets/images/logo.svg') }}" alt="" class="responsive-logo">
                        <span style="font-size: 1.125rem; color: white; font-weight: 500;">helpNhelper</span>
                    </a>
                </div>

                <!-- Desktop Menu Items -->
                <div class="desktop-nav"
                    style="display: flex; background-color: white; padding: 15px 18px; border-radius: 100px; gap: 0.5rem;">
                    <a href="{{ route('home') }}"
                        style="font-weight: 600; padding: 12px 28px; border-radius: 9999px; text-decoration: none; color: black; background-color: {{ Route::currentRouteName() == 'home' ? 'rgb(39, 227, 106)' : 'transparent' }};">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('current-campaigns') }}"
                        style="font-weight: 600; padding: 12px 16px; border-radius: 9999px; text-decoration: none; color: black; background-color: {{ Route::currentRouteName() == 'current-campaigns' ? 'rgb(39, 227, 106)' : 'transparent' }};">
                        {{ __('Current Campaigns') }}
                    </a>
                    <a href="{{ route('web.our-works') }}"
                        style="font-weight: 600; padding: 12px 16px; border-radius: 9999px; text-decoration: none; color: black; background-color: {{ Route::currentRouteName() == 'web.our-works' ? 'rgb(39, 227, 106)' : 'transparent' }};">
                        {{ __('Our Works') }}
                    </a>
                    <a href="{{ route('about-us') }}"
                        style="font-weight: 600; padding: 12px 16px; border-radius: 9999px; text-decoration: none; color: black; background-color: {{ Route::currentRouteName() == 'about-us' ? 'rgb(39, 227, 106)' : 'transparent' }};">
                        {{ __('About Us') }}
                    </a>
                    <a href="{{ route('web.contact') }}"
                        style="font-weight: 600; padding: 12px 16px; border-radius: 9999px; text-decoration: none; color: black; background-color: {{ Route::currentRouteName() == 'web.contact' ? 'rgb(39, 227, 106)' : 'transparent' }};">
                        {{ __('Contact') }}
                    </a>
                </div>

                <!-- Language Switcher -->
                <div class="dropdown ml-2 mr-2">
                    <button class="btn btn-light dropdown-toggle" type="button" id="languageDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="border-radius: 9999px; font-weight: 600;">
                        @php
                            $locale = session('locale', config('app.locale'));
                            $currentLang = \App\Models\Language::where('code', $locale)->first();
                        @endphp
                        @if($currentLang)
                            <i class="{{ $currentLang->icon }}"></i> {{ $currentLang->name }}
                        @else
                            Language
                        @endif
                    </button>
                    <div class="dropdown-menu" aria-labelledby="languageDropdown">
                        @foreach(\App\Models\Language::where('status', 'active')->get() as $lang)
                            <a class="dropdown-item" href="{{ route('home', ['lang' => $lang->code]) }}">
                                <i class="{{ $lang->icon }}"></i> {{ $lang->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Desktop Auth Buttons -->
                <div class="desktop-nav auth-buttons" style="display: flex; align-items: center; gap: 1rem;">
                    @if (Auth::user())
                        <div class="dropdown ml-3 mr-5">
                            <button class="btn bg-transparent dropdown-toggle text-white" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{-- <i class="far fa-user"></i> --}}
                                <img src="{{ asset('web-assets/profile.png') }}" alt="logo" srcset=""
                                    style="" height="33px">
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ url('profile') }}">Profile</a>
                                @if ((Auth::user()->type == 'seeker' || Auth::user()->type == 'organization') && Auth::user()->status === 'approved')
                                    <a class="dropdown-item" href="{{ url('fund-request') }}">Fund Request</a>
                                @endif
                                <a class="dropdown-item" href="{{ url('history') }}"><span
                                        class="text-uppercase">{{ Auth::user()?->type }}</span> History</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <button class="btn bg-white ml-3 mr-3 sign-up nav_btn_sign_up" data-toggle="modal"
                            data-target="#loginModal"><b>Sign In</b></button>
                    @endif
                </div>

                <!-- Mobile Hamburger Menu -->
                <div class="mobile-nav" style="display: none;">
                    <button id="menu-toggle" style="background: none; border: none; color: white;">
                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu"
            style="position: fixed; top: 0; left: 0; width: 16rem; height: 100%; background-color: #1f2937; color: white; transform: translateX(-100%); transition: transform 0.3s ease-in-out; z-index: 50;">
            <div style="display: flex; flex-direction: column; align-items: flex-start; padding: 1.5rem; gap: 0.5rem;">
                <button id="close-menu" style="align-self: flex-end; background: none; border: none; color: white;">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <!-- Mobile Links -->
                <a href="{{ route('home') }}"
                    style="font-weight: 600; padding: 8px 12px; font-size: 0.875rem; border-radius: 9999px; text-decoration: none; color: {{ Route::currentRouteName() == 'home' ? 'black' : 'white' }}; background-color: {{ Route::currentRouteName() == 'home' ? 'rgb(39, 227, 106)' : 'transparent' }};">
                    {{ __('Home') }}
                </a>
                <a href="{{ route('current-campaigns') }}"
                    style="font-weight: 600; padding: 8px 12px; font-size: 0.875rem; border-radius: 9999px; text-decoration: none; color: {{ Route::currentRouteName() == 'current-campaigns' ? 'black' : 'white' }}; background-color: {{ Route::currentRouteName() == 'current-campaigns' ? 'rgb(39, 227, 106)' : 'transparent' }};">
                    {{ __('Current Campaigns') }}
                </a>
                <a href="{{ route('web.our-works') }}"
                    style="font-weight: 600; padding: 8px 12px; font-size: 0.875rem; border-radius: 9999px; text-decoration: none; color: {{ Route::currentRouteName() == 'web.our-works' ? 'black' : 'white' }}; background-color: {{ Route::currentRouteName() == 'web.our-works' ? 'rgb(39, 227, 106)' : 'transparent' }};">
                    {{ __('Our Works') }}
                </a>
                <a href="{{ route('about-us') }}"
                    style="font-weight: 600; padding: 8px 12px; font-size: 0.875rem; border-radius: 9999px; text-decoration: none; color: {{ Route::currentRouteName() == 'about-us' ? 'black' : 'white' }}; background-color: {{ Route::currentRouteName() == 'about-us' ? 'rgb(39, 227, 106)' : 'transparent' }};">
                    {{ __('About Us') }}
                </a>
                <a href="{{ route('web.contact') }}"
                    style="font-weight: 600; padding: 8px 12px; font-size: 0.875rem; border-radius: 9999px; text-decoration: none; color: {{ Route::currentRouteName() == 'web.contact' ? 'black' : 'white' }}; background-color: {{ Route::currentRouteName() == 'web.contact' ? 'rgb(39, 227, 106)' : 'transparent' }};">
                    {{ __('Contact') }}
                </a>

                <!-- Mobile Language Switcher -->
                <div class="dropdown" style="padding: 8px 12px;">
                     <button class="btn btn-light dropdown-toggle" type="button" id="mobileLanguageDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="border-radius: 9999px; font-weight: 600; width: 100%; text-align: left;">
                         @if($currentLang)
                            <i class="{{ $currentLang->icon }}"></i> {{ $currentLang->name }}
                        @else
                            Language
                        @endif
                    </button>
                    <div class="dropdown-menu" aria-labelledby="mobileLanguageDropdown">
                        @foreach(\App\Models\Language::where('status', 'active')->get() as $lang)
                            <a class="dropdown-item" href="{{ route('home', ['lang' => $lang->code]) }}">
                                <i class="{{ $lang->icon }}"></i> {{ $lang->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @guest
                    <a href="{{ route('web.login') }}"
                        style="border: 1px solid white; padding: 4px 16px; border-radius: 9999px; text-decoration: none; color: white;">Login</a>
                    <a href="{{ route('web.signup') }}"
                        style="background-color: #3b82f6; color: white; padding: 4px 16px; border-radius: 9999px; text-decoration: none;">Signup</a>
                @else
                    @if (Auth::user())
                        <div class="dropdown mr-5">
                            <button class="btn bg-transparent dropdown-toggle text-white" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <i class="far fa-user"></i> --}}
                                <img src="{{ asset('web-assets/profile.png') }}" alt="logo" srcset=""
                                    height="33px">
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ url('profile') }}">Profile</a>
                                @if ((Auth::user()->type == 'seeker' || Auth::user()->type == 'organization') && Auth::user()->status === 'approved')
                                    <a class="dropdown-item" href="{{ url('fund-request') }}">Fund Request</a>
                                @endif
                                <a class="dropdown-item" href="{{ url('history') }}"><span
                                        class="text-uppercase">{{ Auth::user()?->type }}</span> History</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endguest
            </div>
        </div>
    </nav>

    <!-- JavaScript -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenu = document.getElementById('close-menu');

        menuToggle?.addEventListener('click', () => {
            mobileMenu?.style.setProperty('transform', 'translateX(0)');
        });

        closeMenu?.addEventListener('click', () => {
            mobileMenu?.style.setProperty('transform', 'translateX(-100%)');
        });
    </script>
</header>
