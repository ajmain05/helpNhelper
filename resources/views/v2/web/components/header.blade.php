<header class="bg-black px-3 py-4 xl:px-8 bg-transparent z-[1] relative">
    <nav
        class="bg-header text-white rounded-[100px] py-[10px] px-[10px] xl:px-[30px] 2xl:px-[80px] max-w-[1667px] mx-auto">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img class="w-full max-w-[20px] xl:max-w-[45px]" src="{{ asset('web-assets/images/logo.svg') }}"
                            alt="">
                        <span class="text-base xl:text-lg text-white font-medium">helpNhelper</span>
                    </a>
                </div>

                <!-- Menu Items -->
                <div class="hidden xl:flex bg-white px-[18px] py-[15px] rounded-[100px]">
                    <a href="{{ route('home') }}"
                        class="transition-all @if (Route::currentRouteName() == 'home') bg-[rgb(39_227_106)] px-7 @else pr-4 hover:text-green-700 @endif font-semibold py-3 text-black rounded-full">{{ __('Home') }}</a>
                    <a href="{{ route('current-campaigns') }}"
                        class="transition-all @if (Route::currentRouteName() == 'current-campaigns') bg-[rgb(39_227_106)] px-7 @else px-4 hover:text-green-700 @endif font-semibold  py-3 text-black rounded-full">{{ __('Current Campaigns') }}</a>
                    <a href="{{ route('web.our-works') }}"
                        class="transition-all @if (Route::currentRouteName() == 'web.our-works') bg-[rgb(39_227_106)] px-7 @else px-4 hover:text-green-700 @endif font-semibold py-3 text-black rounded-full">{{ __('Our Works') }}</a>
                    <a href="{{ route('about-us') }}"
                        class="transition-all @if (Route::currentRouteName() == 'about-us') bg-[rgb(39_227_106)] px-7 @else px-4 hover:text-green-700 @endif font-semibold py-3 text-black rounded-full">{{ __('About Us') }}</a>
                    <a href="{{ route('web.contact') }}"
                        class="transition-all @if (Route::currentRouteName() == 'web.contact') bg-[rgb(39_227_106)] px-7 @else pl-4 hover:text-green-700 @endif font-semibold py-3 text-black rounded-full">{{ __('Contact') }}</a>
                </div>

                @guest
                    <!-- Login & Signup Buttons -->
                    <div class="hidden xl:flex items-center space-x-4">
                        <a href="{{ route('web.login') }}"
                            class="border border-white px-10 py-3 rounded-full transition-all hover:bg-[#27e36a] hover:text-black">{{ __('Login') }}</a>
                        <a href="{{ route('web.signup') }}"
                            class="bg-blue-500 text-white px-10 py-3 rounded-full transition-all hover:bg-blue-600">{{ __('Signup') }}</a>
                    </div>
                @else
                    <div class="hidden xl:flex items-center space-x-4">
                        <a href="{{ url('/profile') }}"
                            class="bg-[#27e36a] text-black hover:text-white font-semibold px-10 py-3 rounded-full transition hover:bg-blue-600">{{ __('Profile') }}</a>
                    </div>
                @endguest
                <div class="hidden xl:flex relative">
                     @php
                        $locale = session('locale', config('app.locale'));
                        $currentLang = \App\Models\Language::where('code', $locale)->first();
                        $flags = [
                            'en' => '<svg class="w-5 h-5 rounded-full object-cover border border-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480"><path fill="#012169" d="M0 0h640v480H0z"/><path fill="#FFF" d="M75 0l244 181L562 0h78v62L400 241l240 178v61h-80L320 301 81 480H0v-60l239-178L0 64V0h75z"/><path fill="#C8102E" d="M424 294l216 163v23h-36L288 197 51.5 362.6 15 480H0v-10l252-196L7.4 23.3 0 11.2V0h44L288 167 525.6 0h42l-143.6 109.9L424 294z"/><path fill="#FFF" d="M250 0h140v480H250zM0 170h640v140H0z"/><path fill="#C8102E" d="M280 0h80v480h-80zM0 200h640v80H0z"/></svg>',
                            'bn' => '<svg class="w-5 h-5 rounded-full object-cover border border-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480"><path fill="#006a4e" d="M0 0h640v480H0z"/><circle cx="280" cy="240" r="140" fill="#f42a41"/></svg>',
                            'ar' => '<svg class="w-5 h-5 rounded-full object-cover border border-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480"><path fill="#007a3d" d="M0 0h640v480H0z"/><path fill="#fff" d="M190 240l100 40 40-100-40 100-100-40z" opacity=".8"/></svg>' // Simplified specific flag not available, using placeholder color
                        ];
                        // Better Arabic Flag (Saudi)
                        $flags['ar'] = '<svg class="w-5 h-5 rounded-full object-cover border border-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480"><path fill="#006C35" d="M0 0h640v480H0z"/><path fill="#FFF" d="M185 300l250-20v30l-250-20z"/></svg>'; // Very simplified for visual hint
                    @endphp
                    <button id="desktop-lang-btn" class="flex items-center gap-2 bg-white border-2 border-gray-300 text-gray-700 py-2.5 px-5 rounded-full focus:outline-none focus:ring-2 focus:ring-[#27e36a] hover:bg-gray-50 transition-colors shadow-sm">
                         @if($currentLang && isset($flags[$currentLang->code]))
                            {!! $flags[$currentLang->code] !!}
                            <span class="font-medium">{{ $currentLang->name }}</span>
                        @elseif($currentLang)
                             <span class="font-medium">{{ $currentLang->name }}</span>
                        @else
                            <span class="font-medium">{{ __('Language') }}</span>
                        @endif
                        <svg class="w-4 h-4 ml-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="desktop-lang-menu" class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl py-2 hidden z-50 border border-gray-100 overflow-hidden transform transition-all duration-200 origin-top-right">
                        @foreach(\App\Models\Language::where('status', 1)->get() as $lang)
                            <a href="{{ route('home', ['lang' => $lang->code]) }}" class="block px-5 py-3 hover:bg-green-50 flex items-center gap-3 text-gray-700 transition-colors border-b last:border-0 border-gray-50">
                                @if(isset($flags[$lang->code]))
                                    {!! $flags[$lang->code] !!}
                                @endif
                                <span class="font-medium">{{ $lang->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Mobile Hamburger Menu -->
                <div class="xl:hidden flex items-center">
                    <button id="menu-toggle" class="text-white focus:outline-none">
                        <!-- Hamburger Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Sliding in from the left) -->
        <div id="mobile-menu"
            class="fixed top-0 left-0 w-64 h-full bg-gray-800 text-white transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden z-50">
            <div class="flex flex-col items-start p-6 space-y-2">
                <button id="close-menu" class="self-end text-white">
                    <!-- Close Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <a href="{{ route('home') }}"
                    class="@if (Route::currentRouteName() == 'home') bg-[rgb(39_227_106)] text-black @else text-white hover:text-green-700 @endif font-semibold px-3 py-2 rounded-full text-sm">{{ __('Home') }}</a>
                <a href="{{ route('current-campaigns') }}"
                    class="@if (Route::currentRouteName() == 'current-campaigns') bg-[rgb(39_227_106)] text-black @else text-white hover:text-green-700 @endif font-semibold px-3 py-2 rounded-full text-sm">{{ __('Current Campaigns') }}</a>
                <a href="{{ route('web.our-works') }}"
                    class="@if (Route::currentRouteName() == 'web.our-works') bg-[rgb(39_227_106)] text-black @else text-white hover:text-green-700 @endif font-semibold px-3 py-2 rounded-full text-sm">{{ __('Our Works') }}</a>
                <a href="{{ route('about-us') }}"
                    class="@if (Route::currentRouteName() == 'about-us') bg-[rgb(39_227_106)] text-black @else text-white hover:text-green-700 @endif font-semibold px-3 py-2 rounded-full text-sm">{{ __('About Us') }}</a>
                <a href="{{ route('web.contact') }}"
                    class="@if (Route::currentRouteName() == 'web.contact') bg-[rgb(39_227_106)] text-black @else text-white hover:text-green-700 @endif font-semibold px-3 py-2 rounded-full text-sm">{{ __('Contact') }}</a>
                @guest

                    <a href="{{ route('web.login') }}"
                        class="border border-white px-4 py-1 rounded-full hover:bg-[#27e36a] w-fit">{{ __('Login') }}</a>
                    <a href="{{ route('web.signup') }}"
                        class="bg-blue-500 text-white px-4 py-1 rounded-full hover:bg-blue-600 w-fit">{{ __('Signup') }}</a>
                @else
                    <a href="{{ url('/profile') }}"
                        class="bg-blue-600 text-white px-4 py-1 font-semibold rounded-full hover:bg-blue-600 w-fit">{{ __('Profile') }}</a>
                @endguest
                <div class="flex xl:hidden flex-col gap-2 mt-4">
                    <span class="text-sm text-gray-400">{{ __('Language') }}</span>
                    @foreach(\App\Models\Language::where('status', 1)->get() as $lang)
                        <a href="{{ route('home', ['lang' => $lang->code]) }}" class="flex items-center gap-2 text-white hover:text-[#27e36a]">
                            <i class="{{ $lang->icon }}"></i> {{ $lang->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>
    <!-- JavaScript -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenu = document.getElementById('close-menu');

        // Open the mobile menu
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.remove('-translate-x-full');
        });

        // Close the mobile menu
        closeMenu.addEventListener('click', () => {
            mobileMenu.classList.add('-translate-x-full');
        });

        // Desktop Language Switcher Toggle
        const desktopLangBtn = document.getElementById('desktop-lang-btn');
        const desktopLangMenu = document.getElementById('desktop-lang-menu');

        if(desktopLangBtn && desktopLangMenu) {
            desktopLangBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                desktopLangMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!desktopLangBtn.contains(e.target) && !desktopLangMenu.contains(e.target)) {
                    desktopLangMenu.classList.add('hidden');
                }
            });
        }
    </script>

</header>
