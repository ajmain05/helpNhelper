<section class="pb-32 bg-cover bg-no-repeat mt-[-77px] xl:mt-[-130px] min-h-screen pt-[206px] bg-top px-3"
    style="background-image: url('{{ asset('web-assets/images/bg_image.png') }}')">
    <div class="max-w-[1000px] mx-auto flex flex-col">
        <h1
            class="text-[30px] xl:text-[44px] text-white font-semibold leading-[24px] tracking-[0] mb-[30px] xl:mb-[77px]">
            {{ __('Login') }}</h1>
        <h3 class="text-[20px] xl:text-[32px] text-white font-medium leading-[24px] tracking-[0] mb-[30px] xl:mb-10">
            {{ __('Enter your login details') }}
        </h3>
        <form action="{{ route('login') }}" class="flex flex-col" method="POST">
            @csrf
            <div class="bg-red-100 border font-bold border-red-400 text-red-700 px-4 py-3 rounded mb-4 error-message hidden"
                role="alert">
            </div>
            <div class="bg-green-100 border font-bold border-green-400 text-green-700 px-4 py-3 rounded mb-4 success-message hidden"
                role="alert">
            </div>
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                    <strong class="font-bold">Error:</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if ($errors->any())
                @if (!$errors->has('email') && !$errors->has('password'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4 mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->keys() as $fieldName)
                                <li>
                                    <span class="font-semibold">{{ ucfirst($fieldName) }}:</span>
                                    <span>{{ $errors->first($fieldName) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
            <fieldset class="grid grid-cols-2 gap-4 mb-4 max-w-[250px]">
                <legend class="sr-only">Delivery</legend>

                <div class="w-max">
                    <label for="contact-email"
                        class="flex cursor-pointer justify-between gap-3 w-max rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                        <input type="radio" name="contact-type" value="email" id="contact-email"
                            class="size-5 border-gray-300 text-blue-500" checked />
                        <div>
                            <p class="text-gray-700">{{ __('Email') }}</p>
                        </div>

                    </label>
                </div>

                <div class="w-max">
                    <label for="contact-mobile"
                        class="flex cursor-pointer justify-between gap-3 w-max rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                        <input type="radio" name="contact-type" value="mobile" id="contact-mobile"
                            class="size-5 border-gray-300 text-blue-500" />
                        <div>
                            <p class="text-gray-700">{{ __('Mobile') }}</p>
                        </div>
                    </label>
                </div>
            </fieldset>
            <div class="w-full mb-[20px] xl:mb-[45px]" id="input-email">
                <input type="email" id="login-email" name="email" value="{{ old('email') }}"
                    class="w-full border-2 border-[rgba(39_227_106_0.54)] rounded-[8px] px-[10px] xl:px-[24px] py-[10px] xl:py-[22px] text-[14px] xl:text-[22px] font-medium leading-[18px] -tracking-normal mb-2 focus-within:outline-none"
                    placeholder="Email">
                @error('email')
                    <div class="text-red-500 text-[16px] font-semibold">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-full mb-[20px] xl:mb-[45px] hidden" id="input-mobile">
                <input type="text" id="login-mobile" name="mobile" value="{{ old('mobile') }}"
                    class="w-full border-2 border-[rgba(39_227_106_0.54)] rounded-[8px] px-[10px] xl:px-[24px] py-[10px] xl:py-[22px] text-[14px] xl:text-[22px] font-medium leading-[18px] -tracking-normal mb-2 focus-within:outline-none"
                    placeholder="Mobile Number">
                @error('mobile')
                    <div class="text-red-500 text-[16px] font-semibold">{{ $message }}</div>
                @enderror
            </div>
            <fieldset class="grid grid-cols-2 gap-4 mb-4 max-w-[300px]">
                <legend class="sr-only">Delivery</legend>

                <div class="w-max">
                    <label for="auth-password"
                        class="flex cursor-pointer justify-between gap-3 w-max rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                        <input type="radio" name="auth-type" value="password" id="auth-password"
                            class="size-5 border-gray-300 text-blue-500" checked />
                        <div>
                            <p class="text-gray-700">{{ __('Password') }}</p>
                        </div>
                    </label>
                </div>
                <div class="w-max">
                    <label for="auth-otp"
                        class="flex cursor-pointer justify-between gap-3 w-max rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                        <input type="radio" name="auth-type" value="otp" id="auth-otp"
                            class="size-5 border-gray-300 text-blue-500" />
                        <div>
                            <p class="text-gray-700">{{ __('Otp') }}</p>
                        </div>

                    </label>
                </div>
            </fieldset>
            <div class="w-full relative mb-[10px] xl:mb-[10px]" id="input-password">
                <input type="password" name="password"
                    class="w-full border-2 border-[rgba(39_227_106_0.54)] rounded-[8px] px-[10px] xl:px-[24px] py-[10px] xl:py-[22px] text-[14px] xl:text-[22px] font-medium leading-[18px] -tracking-normal focus-within:outline-none"
                    placeholder="{{ __('Password') }}">
                @error('password')
                    <div class="text-red-500 text-[16px] font-semibold">{{ $message }}</div>
                @enderror
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none"
                    aria-label="Toggle password visibility">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 eye-icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 eye-off-icon hidden">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <div class="w-full relative mb-[10px] xl:mb-[10px] hidden" id="input-otp">
                <input type="password" name="otp" id="otp"
                    class="w-full border-2 border-[rgba(39_227_106_0.54)] rounded-[8px] px-[10px] xl:px-[24px] py-[10px] xl:py-[22px] text-[14px] xl:text-[22px] font-medium leading-[18px] -tracking-normal focus-within:outline-none"
                    placeholder="{{ __('Otp Password') }}">
                @error('password')
                    <div class="text-red-500 text-[16px] font-semibold">{{ $message }}</div>
                @enderror
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none"
                    aria-label="Toggle password visibility">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 eye-icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 eye-off-icon hidden">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <div class="flex justify-between items-center mb-6 flex-wrap gap-y-3">
                <p class="text-white text-sm md:text-lg">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('web.signup') }}" class="text-[#1c9ee9] hover:underline font-semibold">
                        {{ __('Sign up') }}
                    </a>
                </p>
                <a href="{{ route('password.request') }}"
                    class="text-[#1c9ee9] text-sm md:text-lg hover:underline font-semibold">
                    {{ __('Forgot Password?') }}
                </a>
            </div>
            <button type="submit"
                class="px-[30px] xl:px-[75px] py-[8px] xl:py-[20px] bg-[rgb(39_227_106)] text-black rounded-full max-w-max text-[18px] font-semibold leading-[28px] tracking-[0]">{{ __('Login') }}</button>
        </form>

    </div>
</section>
