<x-web-layout>
    <x-slot name="title">HelpNHelper - Reset Password</x-slot>

    <section class="pb-32 bg-cover bg-no-repeat mt-[-77px] xl:mt-[-130px] min-h-screen pt-[206px] bg-top px-3"
        style="background-image: url('{{ asset('web-assets/images/bg_image.png') }}')">
        <div class="max-w-[1000px] mx-auto flex flex-col">
            <h1
                class="text-[30px] xl:text-[44px] text-white font-semibold leading-[24px] tracking-[0] mb-[30px] xl:mb-[77px]">
                Reset Password
            </h1>
            <h3 class="text-[20px] xl:text-[32px] text-white font-medium leading-[24px] tracking-[0] mb-[30px] xl:mb-10">
                Enter a new password to reset your account
            </h3>

            <form method="POST" action="{{ route('password.update') }}" class="flex flex-col w-full">
                @csrf

                {{-- Required hidden token field --}}
                <input type="hidden" name="token" value="{{ $token }}">
                {{-- Hidden input (for payload) --}}
                <input type="hidden" name="email" value="{{ old('email', $email ?? '') }}">

                {{-- Email --}}
                <div class="w-full mb-[10px] xl:mb-[25px]" id="email">
                    <input type="email" name="email" value="{{ old('email', $email ?? '') }}" disabled
                        class="w-full text-white border-2 cursor-not-allowed border-[rgba(39_227_106_0.54)] rounded-[8px] px-[10px] xl:px-[24px] py-[10px] xl:py-[22px] text-[14px] xl:text-[22px] font-medium leading-[18px] -tracking-normal mb-2 focus-within:outline-none"
                        placeholder="Email">
                    @error('email')
                        <div class="text-red-500 text-[16px] font-semibold">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="w-full mb-[10px] xl:mb-[25px]" id="password">
                    <input type="password" name="password" required
                        class="w-full border-2 border-[rgba(39_227_106_0.54)] rounded-[8px] px-[10px] xl:px-[24px] py-[10px] xl:py-[22px] text-[14px] xl:text-[22px] font-medium leading-[18px] -tracking-normal mb-2 focus-within:outline-none"
                        placeholder="New Password">
                    @error('password')
                        <div class="text-red-500 text-[16px] font-semibold">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="w-full mb-[10px] xl:mb-[25px]" id="password_confirmation">
                    <input type="password" name="password_confirmation" required
                        class="w-full border-2 border-[rgba(39_227_106_0.54)] rounded-[8px] px-[10px] xl:px-[24px] py-[10px] xl:py-[22px] text-[14px] xl:text-[22px] font-medium leading-[18px] -tracking-normal focus-within:outline-none"
                        placeholder="Confirm New Password">
                </div>

                {{-- Submit --}}
                <div class="w-full xl:mt-6">
                    <button type="submit"
                        class="px-[30px] xl:px-[75px] py-[8px] xl:py-[20px] bg-[rgb(39_227_106)] text-black rounded-full max-w-max text-[18px] font-semibold leading-[28px] tracking-[0]">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-web-layout>
