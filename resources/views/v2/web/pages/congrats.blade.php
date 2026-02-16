<x-web-layout>
    <div class="pt-[180px] bg-cover bg-no-repeat bg-center mt-[-77px] xl:mt-[-130px] min-h-screen px-3 overflow-hidden"
        style="background-image: url('{{ asset('web-assets/images/bg_image.png') }}')">
        <div class="max-w-[1200px] mx-auto reg_step flex flex-col items-center">
            <div class="w-full flex justify-between items-center gap-2">
                <h4 class="text-[32px] text-white font-medium leading-[24px] tracking-normal">Congratulation!</h4>
                <x-step-bar :step="4" :position="4"></x-step-bar>
            </div>
            <div class="w-full flex flex-col mt-10 gap-7">
                <h3 class="text-2xl font-medium leading-6 tracking-normal mb-11 text-white">Your account successfully
                    created</h3>
                <a href="{{ route('home') }}" style="max-width: 200px;"
                    class="rounded-[100px] flex justify-center bg-green-500 w-full px-6 py-4 text-lg font-semibold leading-7 tracking-normal">Homepage</a>
            </div>
        </div>
    </div>
    <x-slot name="title">HelpNHelper - Registration Complete</x-slot>
</x-web-layout>
