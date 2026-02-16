<x-web-layout>
    <x-slot name="title">HelpNHelper - Forgot Password</x-slot>

    <section class="pb-32 bg-cover bg-no-repeat mt-[-77px] xl:mt-[-130px] min-h-screen pt-[206px] bg-top px-3"
        style="background-image: url('{{ asset('web-assets/images/bg_image.png') }}')">
        <div class="max-w-[1000px] mx-auto flex flex-col">
            <h1
                class="text-[30px] xl:text-[44px] text-white font-semibold leading-[24px] tracking-[0] mb-[30px] xl:mb-[77px]">
                Forgot Password
            </h1>
            <h3 class="text-[20px] xl:text-[32px] text-white font-medium leading-[24px] tracking-[0] mb-[30px] xl:mb-10">
                Enter your email to receive password reset instructions
            </h3>

            @if (session('status'))
                <div
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 font-medium max-w-[500px]">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="flex flex-col w-full">
                @csrf

                <div class="w-full mb-[10px] xl:mb-[25px]" id="email">
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full border-2 border-[rgba(39_227_106_0.54)] rounded-[8px] px-[10px] xl:px-[24px] py-[10px] xl:py-[22px] text-[14px] xl:text-[22px] font-medium leading-[18px] -tracking-normal mb-2 focus-within:outline-none"
                        placeholder="Email">
                    @error('email')
                        <div class="text-red-500 text-[16px] font-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <div class="w-full xl:mt-6">
                    <button type="submit"
                        class="px-[30px] xl:px-[75px] py-[8px] xl:py-[20px] bg-[rgb(39_227_106)] text-black rounded-full max-w-max text-[18px] font-semibold leading-[28px] tracking-[0]">Send
                        Password Reset Link</button>
                </div>
            </form>
        </div>
    </section>
</x-web-layout>
