<div class="signup-container pt-[100px] xl:pt-[180px] bg-cover bg-no-repeat bg-center mt-[-77px] xl:mt-[-130px] min-h-screen px-3 overflow-hidden"
    style="background-image: url('{{ asset('web-assets/v2-images/sign-up/1-Main singup.webp') }}')">
    <!-- Shadow Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-[rgb(2,31,23)] to-transparent z-0"></div>
    <div class="relative z-10">
        {{-- Error --}}
        <x-popup :type="'success'" />
        <x-popup :type="'error'" />
        <form action="{{ route('user.request') }}" method="post">
            @csrf
            <div
                class="reg-step-container max-w-[1200px] w-full mx-auto flex overflow-hidden transition duration-50 ease-in-out">
                {{-- Step 1 --}}
                <div class="reg_step min-w-full flex flex-col items-center h-fit">
                    <h1
                        class="text-white text-[30px] xl:text-[52px] font-semibold leading-[35px] xl:leading-[114.8%] tracking-normal text-center mb-[15px] xl:mb-[50px] max-w-[320px]">
                        {{ __('Welcome to helpNhelper') }} </h1>
                    <h3
                        class="text-white text-[20px] xl:text-[32px] font-medium leading-[1] xl:leading-[114.8%] tracking-normal text-center mb-[20px] xl:mb-[50px]">
                        {{ __('Create Account As') }}
                    </h3>
                    <fieldset class="flex gap-7 flex-wrap mb-[50px] justify-center">
                        <legend class="sr-only">User Type</legend>
                        <div class="flex">
                            <label for="volunteers"
                                class="flex rounded-lg overflow-hidden flex-col bg-white cursor-pointer transition-all hover:bg-[rgb(39_227_106)] w-[120px] xl:w-[200px] has-[:checked]:bg-[rgb(39_227_106)]">
                                <img class="object-cover object-center w-[120px] xl:w-[200px] h-[100px]"
                                    src="{{ asset('web-assets/v2-images/sign-up/2 Volunteer.webp') }}" loading="lazy"
                                    alt="Volunteer Registration">
                                <h4
                                    class="text-[16px] xl:text-[24px] font-semibold leading-[114.8%] tracking-normal text-center px-[20px] xl:px-[40px] py-[6px] xl:py-[22px] my-auto">
                                    {{ __('Volunteer') }}</h4>

                                <input type="radio" name="type" value="volunteer" id="volunteers"
                                    class="sr-only" />
                            </label>
                        </div>
                        <div class="flex">
                            <label for="seekers"
                                class="flex rounded-lg overflow-hidden flex-col bg-white cursor-pointer transition-all hover:bg-[rgb(39_227_106)] w-[120px] xl:w-[200px] has-[:checked]:bg-[rgb(39_227_106)]">
                                <img class="object-cover object-center w-[120px] xl:w-[200px] h-[100px]"
                                    src="{{ asset('web-assets/v2-images/sign-up/3 Sekeer.webp') }}" loading="lazy"
                                    alt="Seeker Registration">
                                <h4
                                    class="text-[16px] xl:text-[24px] font-semibold leading-[114.8%] tracking-normal text-center px-[20px] xl:px-[40px] py-[6px] xl:py-[22px] my-auto">
                                    {{ __('Seeker') }}</h4>

                                <input type="radio" name="type" value="seeker" id="seekers" class="sr-only" />
                            </label>
                        </div>
                        <div class="flex">
                            <label for="donors"
                                class="flex rounded-lg overflow-hidden flex-col bg-white cursor-pointer transition-all hover:bg-[rgb(39_227_106)] w-[120px] xl:w-[200px] has-[:checked]:bg-[rgb(39_227_106)]">
                                <img class="object-cover object-center w-[120px] xl:w-[200px] h-[100px]"
                                    src="{{ asset('web-assets/v2-images/sign-up/4 Doner.webp') }}" loading="lazy"
                                    alt="Donor Registration">
                                <h4
                                    class="text-[16px] xl:text-[24px] font-semibold leading-[114.8%] tracking-normal text-center px-[20px] xl:px-[40px] py-[6px] xl:py-[22px] my-auto">
                                    {{ __('Donor') }}</h4>

                                <input type="radio" name="type" value="donor" id="donors" class="sr-only" />
                            </label>
                        </div>
                        <div class="flex">
                            <label for="corporate-donors"
                                class="flex rounded-lg overflow-hidden flex-col bg-white cursor-pointer transition-all hover:bg-[rgb(39_227_106)] w-[120px] xl:w-[200px] has-[:checked]:bg-[rgb(39_227_106)]">
                                <img class="object-cover object-center w-[120px] xl:w-[200px] h-[100px]"
                                    src="{{ asset('web-assets/v2-images/sign-up/5 Corporate.webp') }}" loading="lazy"
                                    alt="Corporate Donor Registration">
                                <h4
                                    class="text-[16px] xl:text-[24px] font-semibold leading-[114.8%] tracking-normal text-center px-[20px] xl:px-[40px] py-[6px] xl:py-[22px] my-auto">
                                    {{ __('Corporate Donor') }}</h4>
                                <input type="radio" name="type" value="corporate-donor" id="corporate-donors"
                                    class="sr-only" />
                            </label>
                        </div>
                        <div class="flex">
                            <label for="organizations"
                                class="flex rounded-lg overflow-hidden flex-col bg-white cursor-pointer transition-all hover:bg-[rgb(39_227_106)] w-[120px] xl:w-[200px] has-[:checked]:bg-[rgb(39_227_106)]">
                                <img class="object-cover object-center w-[120px] xl:w-[200px] h-[100px]"
                                    src="{{ asset('web-assets/v2-images/sign-up/6 organisation.webp') }}" loading="lazy"
                                    alt="Volunteer Registration">
                                <h4
                                    class="text-[16px] xl:text-[24px] font-semibold leading-[114.8%] tracking-normal text-center px-[10px] xl:px-[40px] py-[6px] xl:py-[22px] my-auto">
                                    {{ __('Organization') }}</h4>
                                <input type="radio" name="type" value="organization" id="organizations"
                                    class="sr-only" />
                            </label>
                        </div>
                    </fieldset>
                    <div class="w-full flex justify-center pb-10">
                        <button type="button"
                            class="reg-reg-next-btn type-change-btn rounded-full bg-[rgb(23_153_234)] py-3 xl:py-5 px-10 xl:px-20 text-white font-semibold">{{ __('Next') }}</button>
                    </div>
                </div>
                {{-- Step 2 --}}
                <div class="reg_step min-w-full flex flex-col items-center h-fit">
                    <div
                        class="w-full flex flex-col xl:flex-row gap-5 xl:gap-0 justify-between items-center mb-6 xl:mb-16">
                        <h3
                            class="text-white mt-2 text-[25px] xl:text-[44px] font-semibold leading-[24px] tracking-normal registration-title">
                            <span>{{ __('Seeker') }}</span>
                            {{ __('Account') }}
                        </h3>
                        @php
                            $tutorial_keys = [
                                'volunteer' => \App\Enums\Content\ContentType::SignupTutorialVolunteer->value,
                                'seeker' => \App\Enums\Content\ContentType::SignupTutorialSeeker->value,
                                'donor' => \App\Enums\Content\ContentType::SignupTutorialDonor->value,
                                'corporate-donor' => \App\Enums\Content\ContentType::SignupTutorialCorporateDonor->value,
                                'organization' => \App\Enums\Content\ContentType::SignupTutorialOrganization->value,
                            ];
                        @endphp
                        <div id="signup-tutorial-container" class="hidden">
                            <a id="signup-tutorial-link" href="#" target="_blank" class="flex items-center gap-2 bg-gradient-to-r from-[#27E36A] to-[#059669] hover:from-[#059669] hover:to-[#27E36A] text-white px-6 py-3 rounded-full shadow-[0_4px_15px_rgba(39,227,106,0.3)] transition-all duration-500 transform hover:scale-105 active:scale-95">
                                <i class="far fa-file-pdf text-white text-xl"></i>
                                <span class="text-base font-bold whitespace-nowrap">{{ __('Signup Tutorial') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="w-full flex flex-col xl:flex-row justify-between items-center gap-2">
                        <h4
                            class="text-[20px] xl:text-[32px] text-white font-medium leading-[1.1] xl:leading-[24px] tracking-normal text-center xl:text-left">
                            {{ __('Personal Information') }}</h4>
                        <div class="flex items-center gap-4">
                            <x-step-bar :step="4" :position="1"></x-step-bar>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const tutorials = @json($tutorials);
                                const tutorialKeys = @json($tutorial_keys);
                                const container = document.getElementById('signup-tutorial-container');
                                const link = document.getElementById('signup-tutorial-link');
                                
                                function updateTutorialLink() {
                                    const role = document.querySelector('input[name="type"]:checked')?.value;
                                    const roleTutorial = (role && tutorialKeys[role]) ? tutorials[tutorialKeys[role]] : null;
                                    
                                    if (roleTutorial) {
                                        const fullUrl = '{{ asset("") }}' + roleTutorial;
                                        // Update Step 2 link
                                        if (link) {
                                            link.href = fullUrl;
                                            container.classList.remove('hidden');
                                        }
                                        // Update other steps links
                                        document.querySelectorAll('.signup-tutorial-link-global').forEach(el => {
                                            el.href = fullUrl;
                                        });
                                        document.querySelectorAll('.signup-tutorial-container-global').forEach(el => {
                                            el.classList.remove('hidden');
                                        });
                                    } else {
                                        if (container) container.classList.add('hidden');
                                        document.querySelectorAll('.signup-tutorial-container-global').forEach(el => {
                                            el.classList.add('hidden');
                                        });
                                    }
                                }

                                // Update on load and when role changes
                                updateTutorialLink();
                                document.querySelectorAll('input[name="type"]').forEach(input => {
                                    input.addEventListener('change', updateTutorialLink);
                                });
                            });
                        </script>
                    </div>
                    <div class="w-full flex flex-col mt-10 gap-7">
                        <div class="flex">
                            <input
                                class="w-full p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                type="text" name="name" id="name" placeholder="{{ __('Full Name') }}" required>
                        </div>
                        <div class="flex">
                            <input
                                class="w-full p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                type="email" name="email" id="email" placeholder="{{ __('Email') }}" required>
                        </div>
                        <div class="flex gap-2">
                            <div class="flex items-center gap-1 bg-white p-2 rounded-lg">
                                <svg width="36.000000" height="36.000000" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <desc>
                                        Created with Pixso.
                                    </desc>
                                    <defs>
                                        <pattern id="pattern_22_14440" patternContentUnits="objectBoundingBox"
                                            width="1.000000" height="1.000000">
                                            <use xlink:href="#image22_1444_0"
                                                transform="matrix(0.00625,0,0,0.00625,0,0)" />
                                        </pattern>
                                        <image id="image22_1444_0" width="160.000000" height="160.000000"
                                            xlink:href="data:image/png;base64,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" />
                                    </defs>
                                    <rect id="Image" width="36.000000" height="36.000000"
                                        transform="matrix(-1 0 0 1 36 0)" fill="url(#pattern_22_14440)"
                                        fill-opacity="1.000000" />
                                </svg>
                                <span class="text-[22px] font-medium leading-[24px] tracking-[0]">+88</span>
                            </div>
                            <div class="flex w-full">
                                <input
                                    class="w-full p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                    type="text" name="mobile" id="mobile" placeholder="{{ __('Mobile') }}" required>
                            </div>
                        </div>
                        <div class="flex relative">
                            <input
                                class="w-full p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                type="password" name="password" id="password" placeholder="{{ __('Password') }}"
                                autocomplete="true" required>

                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none"
                                aria-label="Toggle password visibility">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 eye-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 eye-off-icon hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        <span class="text-sm text-red-200 -mt-5 bg-green-600/70 px-3 py-2 rounded-md font-medium">
                            {{ __('Password must be 8–32 characters long. We recommend mix of letters, numbers, and symbols for a stronger password.') }}
                        </span>
                        <div class="flex relative">
                            <input
                                class="w-full p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="{{ __('Confirm Password') }}" autocomplete="true" required>
                            <button type="button" id="confirmTogglePassword"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none"
                                aria-label="Toggle password visibility">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 confirm-eye-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 confirm-eye-off-icon hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex" id="fb_link_div">
                            <input
                                class="w-full p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                type="text" name="fb_link" id="fb_link" placeholder="{{ __('Facebook Profile Link') }}">
                        </div>
                    </div>
                    <div class="my-7 self-end flex gap-2">
                        <button type="button"
                            class="reg-reg-prev-btn border text-white border-white px-5 xl:px-16 py-1 xl:py-5 rounded-full w-full text-[14px] xl:text-[18px] font-semibold leading-[28px] tracking-normal">{{ __('Previous') }}</button>
                        <button type="button"
                            class="reg-reg-next-btn bg-blue-500 text-white px-5 xl:px-16 py-1 xl:py-5 rounded-full hover:bg-blue-600 w-full text-[14px] xl:text-[18px] font-semibold leading-[28px] tracking-normal">{{ __('Next') }}</button>
                    </div>
                </div>
                {{-- Step 3 --}}
                <div class="reg_step min-w-full flex flex-col items-center h-fit">
                    <div
                        class="w-full flex flex-col xl:flex-row gap-5 xl:gap-0 justify-between items-center mb-6 xl:mb-16">
                        <h3
                            class="text-white mt-2 text-[25px] xl:text-[44px] font-semibold leading-[24px] tracking-normal registration-title">
                            <span>Seeker</span>
                            Account
                        </h3>
                        <div class="signup-tutorial-container-global hidden">
                            <a href="#" target="_blank" class="signup-tutorial-link-global flex items-center gap-2 bg-gradient-to-r from-[#27E36A] to-[#059669] hover:from-[#059669] hover:to-[#27E36A] text-white px-6 py-3 rounded-full shadow-[0_4px_15px_rgba(39,227,106,0.3)] transition-all duration-500 transform hover:scale-105 active:scale-95">
                                <i class="far fa-file-pdf text-white text-xl"></i>
                                <span class="text-base font-bold whitespace-nowrap">{{ __('Signup Tutorial') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="w-full flex flex-col xl:flex-row justify-between items-center gap-2">
                        <h4
                            class="text-[20px] xl:text-[32px] text-white font-medium leading-[1.1] xl:leading-[24px] tracking-normal text-center xl:text-left">
                            {{ __('NID/Birth Certificate/Passport (Max file size: 1MB)') }}</h4>
                        <x-step-bar :step="4" :position="2"></x-step-bar>
                    </div>
                    <div class="w-full flex flex-col mt-10 gap-7 nid-input-div">
                        <input-image
                            class="flex flex-col max-w-[450px] items-center border-2 border-[rgba(39,227,106,0.54)] rounded-lg bg-white pt-10 pb-5 px-5">
                            <!-- Image Placeholder -->
                            <div id="imagePlaceholder"
                                class="image-placeholder relative h-full flex items-center justify-center rounded-lg mb-4 w-full max-w-[220px]">
                                <svg width="111.012207" height="111.000000" viewBox="0 0 111.012 111" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs />
                                    <path id="Icon"
                                        d="M96.33 3C102.77 3 108 8.22 108 14.66L108 96.33C108 102.77 102.77 108 96.33 108L14.66 108C8.22 108 3 102.77 3 96.33L3 14.66C3 8.22 8.22 3 14.66 3L96.33 3ZM35.08 43.83C30.25 43.83 26.33 39.91 26.33 35.08C26.33 30.25 30.25 26.33 35.08 26.33C39.91 26.33 43.83 30.25 43.83 35.08C43.83 39.91 39.91 43.83 35.08 43.83ZM108 73L78.83 43.83L14.66 108"
                                        stroke="#0F1728" stroke-opacity="1.000000" stroke-width="6.000000"
                                        stroke-linejoin="round" stroke-linecap="round" />
                                </svg>

                                <!-- Cross Icon -->
                                <button type="button"
                                    class="removeButton absolute top-0 right-0 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center hidden">
                                    ✕
                                </button>
                            </div>

                            <!-- File Input -->
                            {{-- <label for="nid"
                            class="cursor-pointer text-blue-500 hover:underline mb-2 text-[20px] font-medium leading-6 tracking-[0]">
                            Choose File
                        </label> --}}
                            <input type="file" name="auth_file" id="nid" class="file-input hidden"
                                accept="image/*,application/pdf" />

                            <!-- Supported File Types -->
                            <p class="text-gray-400 mb-4 text-[12px] font-medium leading-6 tracking-[0]">
                                {{ __('Supported file types: pdf, jpeg, png') }}
                            </p>

                            <!-- Button -->
                            <label for="nid"
                                class="bg-green-500 cursor-pointer text-center hover:bg-green-600 text-white font-medium py-2 px-4 w-full rounded-[100px]">
                                {{ __('Choose File') }}
                            </label>
                        </input-image>
                    </div>
                    <div class="my-7 self-end flex gap-2">
                        <button type="button"
                            class="reg-reg-prev-btn border text-white border-white px-5 xl:px-16 py-1 xl:py-5 rounded-full w-full text-[14px] xl:text-[18px] font-semibold leading-[28px] tracking-normal">{{ __('Previous') }}</button>
                        <button type="button" id="step2SkipBtn"
                            class="hidden reg-reg-next-btn border text-white border-white px-5 xl:px-16 py-1 xl:py-5 rounded-full w-full text-[14px] xl:text-[18px] font-semibold leading-[28px] tracking-normal">{{ __('Skip') }}</button>
                        <button type="button"
                            class="reg-reg-next-btn bg-blue-500 text-white px-5 xl:px-16 py-1 xl:py-5 rounded-full hover:bg-blue-600 w-full text-[14px] xl:text-[18px] font-semibold leading-[28px] tracking-normal">{{ __('Next') }}</button>
                    </div>
                </div>
                {{-- Step 4 --}}
                <div class="reg_step min-w-full flex flex-col items-center h-fit">
                    <div
                        class="w-full flex flex-col xl:flex-row gap-5 xl:gap-0 justify-between items-center mb-6 xl:mb-16">
                        <h3
                            class="text-white mt-2 text-[25px] xl:text-[44px] font-semibold leading-[24px] tracking-normal registration-title">
                            <span>Seeker</span>
                            Account
                        </h3>
                        <div class="signup-tutorial-container-global hidden">
                            <a href="#" target="_blank" class="signup-tutorial-link-global flex items-center gap-2 bg-gradient-to-r from-[#27E36A] to-[#059669] hover:from-[#059669] hover:to-[#27E36A] text-white px-6 py-3 rounded-full shadow-[0_4px_15px_rgba(39,227,106,0.3)] transition-all duration-500 transform hover:scale-105 active:scale-95">
                                <i class="far fa-file-pdf text-white text-xl"></i>
                                <span class="text-base font-bold whitespace-nowrap">{{ __('Signup Tutorial') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="w-full flex flex-col xl:flex-row justify-between items-center gap-2 mb-10">
                        <h4
                            class="text-[20px] xl:text-[32px] text-white font-medium leading-[1.1] xl:leading-[24px] tracking-normal text-center xl:text-left">
                            {{ __('Address') }}</h4>
                        <x-step-bar :step="4" :position="3"></x-step-bar>
                    </div>
                    <div class="w-full flex flex-col xl:flex-row gap-6 mb-14">
                        <div class="relative w-full">
                            <input type="hidden" name="country">
                            <input type="text" id="countrySearchInput"
                                class="w-full cursor-pointer p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                placeholder="{{ __('Search for a Country...') }}" autocomplete="none" />
                            <div id="countrySuggestions"
                                class="absolute z-10 w-full bg-white border-2 border-[rgba(39_227_106_0.54)] rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                <!-- Suggestions will go here -->
                            </div>
                        </div>
                        {{-- <div class="flex w-full">
                        <select
                            class="w-full cursor-pointer p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                            name="country" id="country">
                            @foreach ($countries as $country)
                                <option value={{ $country->id }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                        <div class="relative w-full">
                            <input type="hidden" name="division">
                            <input type="text" id="divisionSearchInput"
                                class="w-full cursor-pointer p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                placeholder="{{ __('Search for a division...') }}" autocomplete="none" />
                            <div id="divisionSuggestions"
                                class="absolute z-10 w-full bg-white border-2 border-[rgba(39_227_106_0.54)] rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                <!-- Suggestions will go here -->
                            </div>
                        </div>
                        {{-- <div class="flex w-full">
                        <select
                            class="w-full cursor-pointer p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                            name="division" id="division" placeholder="Full Name">
                            @foreach ($divisions as $division)
                                <option value={{ $division->id }}>{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    </div>
                    <div class="w-full flex flex-col xl:flex-row gap-6 mb-14">
                        <div class="relative w-full">
                            <input type="hidden" name="district">
                            <input type="text" id="districtSearchInput"
                                class="w-full cursor-pointer p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                placeholder="{{ __('Search for a district...') }}" autocomplete="none" />
                            <div id="districtSuggestions"
                                class="absolute z-10 w-full bg-white border-2 border-[rgba(39_227_106_0.54)] rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                <!-- Suggestions will go here -->
                            </div>
                        </div>
                        {{-- <div class="flex w-full">
                        <select
                            class="w-full cursor-pointer p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                            name="district" id="district" placeholder="District">
                            @foreach ($districts as $district)
                                <option value={{ $district->id }}>{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                        <div class="relative w-full">
                            <input type="hidden" name="upazila">
                            <input type="text" id="upazilaSearchInput"
                                class="w-full cursor-pointer p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                placeholder="{{ __('Search for a upazila...') }}" autocomplete="none" />
                            <div id="upazilaSuggestions"
                                class="absolute z-10 w-full bg-white border-2 border-[rgba(39_227_106_0.54)] rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                <!-- Suggestions will go here -->
                            </div>
                        </div>
                        {{-- <div class="flex w-full">
                        <select
                            class="w-full cursor-pointer p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                            name="upazila" id="upazila" placeholder="Upazila">
                            @foreach ($upazilas as $upazila)
                                <option value={{ $upazila->id }}>{{ $upazila->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    </div>
                    <div class="w-full flex flex-col xl:flex-row gap-6 mb-14">
                        <div class="flex w-full">
                            <textarea id="permanent_address" name="permanent_address"
                                class="p-5 mt-2 w-full outline-none border-none rounded-lg text-[22px] font-medium leading-[24px] tracking-normal border-gray-200 align-top shadow-sm sm:text-sm"
                                rows="4" placeholder="{{ __('Permanent Address') }}"></textarea>
                        </div>
                        <div class="flex w-full">
                            <textarea id="present_address" name="present_address"
                                class="p-5 mt-2 w-full outline-none border-none rounded-lg border-gray-200 align-top shadow-sm sm:text-sm"
                                rows="4" placeholder="{{ __('Present Address') }}"></textarea>
                        </div>
                    </div>
                    <div class="w-full flex flex-col xl:flex-row gap-6" id="officeAddressDiv">
                        <div class="flex w-full xl:w-1/2">
                            <textarea id="office_address" name="office_address"
                                class="p-5 mt-2 w-full rounded-lg text-[22px] outline-none border-none font-medium leading-[24px] tracking-normal border-gray-200 align-top shadow-sm sm:text-sm"
                                rows="4" placeholder="{{ __('Office Address') }}"></textarea>
                        </div>
                        <div class="flex w-full xl:w-1/2">

                        </div>
                    </div>
                    <div class="mb-7 self-end flex gap-2">
                        <button type="button"
                            class="reg-reg-prev-btn border text-white border-white px-5 xl:px-16 py-1 xl:py-5 rounded-full w-full text-[14px] xl:text-[18px] font-semibold leading-[28px] tracking-normal">{{ __('Previous') }}</button>
                        <button type="button" id="step3SkipBtn"
                            class="hidden reg-reg-next-btn border text-white border-white px-5 xl:px-16 py-1 xl:py-5 rounded-full w-full text-[14px] xl:text-[18px] font-semibold leading-[28px] tracking-normal">Skip</button>
                        <button type="button"
                            class="reg-reg-next-btn bg-blue-500 text-white px-5 xl:px-16 py-1 xl:py-5 rounded-full hover:bg-blue-600 w-full text-[14px] xl:text-[18px] font-semibold leading-[28px] tracking-normal">{{ __('Next') }}</button>
                    </div>
                </div>
                {{-- Step 5 --}}
                <div class="reg_step min-w-full flex flex-col items-center h-fit">
                    <div
                        class="w-full flex flex-col xl:flex-row gap-5 xl:gap-0 justify-between items-center mb-6 xl:mb-16">
                        <h3
                            class="text-white mt-2 text-[25px] xl:text-[44px] font-semibold leading-[24px] tracking-normal registration-title">
                            <span>Seeker</span>
                            Account
                        </h3>
                        <div class="signup-tutorial-container-global hidden">
                            <a href="#" target="_blank" class="signup-tutorial-link-global flex items-center gap-2 bg-gradient-to-r from-[#27E36A] to-[#059669] hover:from-[#059669] hover:to-[#27E36A] text-white px-6 py-3 rounded-full shadow-[0_4px_15px_rgba(39,227,106,0.3)] transition-all duration-500 transform hover:scale-105 active:scale-95">
                                <i class="far fa-file-pdf text-white text-xl"></i>
                                <span class="text-base font-bold whitespace-nowrap">{{ __('Signup Tutorial') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="w-full flex flex-col xl:flex-row justify-between items-center gap-2 mb-10">
                        <h4
                            class="text-[20px] xl:text-[32px] text-white font-medium leading-[1.1] xl:leading-[24px] tracking-normal text-center xl:text-left">
                        </h4>
                        <x-step-bar :step="4" :position="4"></x-step-bar>
                    </div>
                    <div class="flex w-full" id="licenseNoDiv">
                        <div class="flex w-full xl:w-1/2">
                            <input
                                class="w-full p-5 placeholder:text-[#6F7279] text-[22px] font-medium leading-[24px] tracking-[0] rounded-lg bg-white outline-none border-2 border-[rgba(39_227_106_0.54)]"
                                type="text" name="license_no" id="license_no" placeholder="{{ __('License No') }}">
                        </div>
                    </div>
                    <div class="flex flex-col xl:flex-row w-full">
                        <div class="w-full flex flex-col mt-10 gap-7" id="licenseImageDiv">
                            <label for="license_image"
                                class="text-2xl font-medium leading-6 tracking-normal text-white">{{ __('License Image') }}</label>
                            <input-image
                                class="flex flex-col  max-w-[450px] items-center border-2 border-[rgba(39,227,106,0.54)] rounded-lg bg-white pt-10 pb-5 px-5">

                                <!-- Image Placeholder -->
                                <div id="imagePlaceholder"
                                    class="image-placeholder relative h-full flex items-center justify-center rounded-lg mb-4 w-full max-w-[220px]">
                                    <svg width="111.012207" height="111.000000" viewBox="0 0 111.012 111"
                                        fill="none" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <defs />
                                        <path id="Icon"
                                            d="M96.33 3C102.77 3 108 8.22 108 14.66L108 96.33C108 102.77 102.77 108 96.33 108L14.66 108C8.22 108 3 102.77 3 96.33L3 14.66C3 8.22 8.22 3 14.66 3L96.33 3ZM35.08 43.83C30.25 43.83 26.33 39.91 26.33 35.08C26.33 30.25 30.25 26.33 35.08 26.33C39.91 26.33 43.83 30.25 43.83 35.08C43.83 39.91 39.91 43.83 35.08 43.83ZM108 73L78.83 43.83L14.66 108"
                                            stroke="#0F1728" stroke-opacity="1.000000" stroke-width="6.000000"
                                            stroke-linejoin="round" stroke-linecap="round" />
                                    </svg>

                                    <!-- Cross Icon -->
                                    <button type="button"
                                        class="removeButton absolute top-0 right-0 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center hidden">
                                        ✕
                                    </button>
                                </div>

                                <!-- File Input -->
                                {{-- <label for="license_image"
                                class="cursor-pointer text-blue-500 hover:underline mb-2 text-[20px] font-medium leading-6 tracking-[0]">
                                Choose File
                            </label> --}}
                                <input type="file" name="license_image" id="license_image"
                                    class="file-input hidden" accept="image/*,application/pdf" />

                                <!-- Supported File Types -->
                                <p class="text-gray-400 mb-4 text-[12px] font-medium leading-6 tracking-[0]">
                                    Supported file types: pdf, jpeg, png
                                </p>

                                <!-- Button -->
                                <label for="license_image"
                                    class="bg-green-500 cursor-pointer text-center hover:bg-green-600 text-white font-medium py-2 px-4 w-full rounded-[100px]">
                                    Choose File
                                </label>
                            </input-image>
                        </div>
                        <div class="w-full flex flex-col mt-10 gap-7">
                            <label for="profile_picture"
                                class="text-2xl font-medium leading-6 tracking-normal text-white">{{ __('Profile Picture') }}</label>
                            <input-image
                                class="test flex flex-col max-w-[450px] items-center border-2 border-[rgba(39,227,106,0.54)] rounded-lg bg-white pt-10 pb-5 px-5">

                                <!-- Image Placeholder -->
                                <div id="imagePlaceholder"
                                    class="image-placeholder prof relative h-full flex items-center justify-center rounded-lg mb-4 w-full max-w-[220px]">
                                    <svg width="111.012207" height="111.000000" viewBox="0 0 111.012 111"
                                        fill="none" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <defs />
                                        <path id="Icon"
                                            d="M96.33 3C102.77 3 108 8.22 108 14.66L108 96.33C108 102.77 102.77 108 96.33 108L14.66 108C8.22 108 3 102.77 3 96.33L3 14.66C3 8.22 8.22 3 14.66 3L96.33 3ZM35.08 43.83C30.25 43.83 26.33 39.91 26.33 35.08C26.33 30.25 30.25 26.33 35.08 26.33C39.91 26.33 43.83 30.25 43.83 35.08C43.83 39.91 39.91 43.83 35.08 43.83ZM108 73L78.83 43.83L14.66 108"
                                            stroke="#0F1728" stroke-opacity="1.000000" stroke-width="6.000000"
                                            stroke-linejoin="round" stroke-linecap="round" />
                                    </svg>

                                    <!-- Cross Icon -->
                                    <button type="button"
                                        class="removeButton absolute top-0 right-0 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center hidden">
                                        ✕
                                    </button>
                                </div>

                                <!-- File Input -->
                                {{-- <label for="profile_picture"
                                class="cursor-pointer text-blue-500 hover:underline mb-2 text-[20px] font-medium leading-6 tracking-[0]">
                                Choose File
                            </label> --}}
                                <input type="file" name="photo" id="profile_picture" class="file-input hidden"
                                    accept="image/*" />

                                <!-- Supported File Types -->
                                <p class="text-gray-400 mb-4 text-[12px] font-medium leading-6 tracking-[0]">
                                    Supported file types: pdf, jpeg, png
                                </p>

                                <!-- Button -->
                                <label for="profile_picture"
                                    class="bg-green-500 cursor-pointer text-center hover:bg-green-600 text-white font-medium py-2 px-4 w-full rounded-[100px]">
                                    {{ __('Choose File') }}
                                </label>
                            </input-image>
                        </div>
                    </div>
                    <div class="mt-12 w-full pb-5">
                        <div class="flex items-center justify-start space-x-2 bg-green-600/70 px-3 py-4 rounded-md">
                            <input type="checkbox" name="terms" id="terms" value="1"
                                class="w-10 md:w-7 h-10 md:h-7 border-2 border-gray-300 checked:bg-blue-500 checked:border-blue-500 focus:outline-none focus:ring-none" />
                            <label for="terms" class="text-white cursor-pointer select-none font-semibold">
                                {{ __('By creating an account, you agree to the Terms of Service and Privacy Policy') }}
                            </label>
                        </div>
                    </div>
                    <div class="mb-7 self-end flex gap-2">
                        <button type="button"
                            class="reg-reg-prev-btn border text-white border-white px-5 xl:px-16 py-1 xl:py-5 rounded-full w-full text-[14px] xl:text-[18px] font-semibold leading-[28px] tracking-normal">{{ __('Previous') }}</button>
                        <button type="submit" id="creating-account-submit-btn"
                            class="reg-reg-next-btn submit-btn bg-blue-500 text-white px-5 xl:px-10 py-1 xl:py-5 rounded-full hover:bg-blue-600 w-full text-[14px] xl:text-[18px] font-semibold leading-[28px] tracking-normal whitespace-nowrap">{{ __('Create Account') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="overlay"></div>
<div id="popup">
    <div>Please wait...</div>
    <div>
        <span id="ProgressLabel" class="sr-only">Loading</span>

        <span class="progress-bar" role="progressbar" aria-labelledby="ProgressLabel" aria-valuenow="75"
            class="relative block rounded-full bg-gray-200">
            <span class="absolute inset-0 flex items-center justify-center text-[10px]/4">
                <span class="progress-bar-text font-bold text-white"> 75% </span>
            </span>

            <span class="progress-bar-line block h-4 rounded-full bg-indigo-600 text-center" style="width: 0%">
            </span>
        </span>
    </div>
</div>
