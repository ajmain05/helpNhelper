<div class="flex bg-[rgb(39_227_106)] justify-center">
    <div class="max-w-[1200px] gap-5 xl:gap-20 py-16 flex justify-between flex-col xl:flex-row px-2">
        <div class="flex w-full xl:w-1/2 ">
            <img src="{{ asset('web-assets/images/donate_img.png') }}" alt="Donate" loading="lazy"
                class="w-full object-contain">
        </div>
        <div class="w-full xl:w-1/2 flex flex-col">
            <h3
                class="text-[25px] xl:text-[45px] font-bold leading-[30px] xl:leading-[55px] tracking-[0] text-[#101828] mb-10">
                {{ __('Give a little, Change a lot your donation makes a difference') }}!</h3>
            <fieldset class="flex gap-6 mb-9 flex-wrap">
                <legend class="sr-only">Color</legend>

                <div>
                    <label for="value_500"
                        class="flex cursor-pointer px-8 py-3 items-center justify-center rounded-full border-black group bg-transparent text-gray-900 hover:text-[#1799EA] border  hover:border-[#1799EA] has-[:checked]:border-blue-500 has-[:checked]:bg-[#1799EA] has-[:checked]:text-white">
                        <input type="radio" name="ColorOption" value="500" id="value_500" class="sr-only"
                            checked />

                        <p
                            class="bg-transparent text-black group-has-[:checked]:text-white rounded-full text-lg font-medium leading-7 tracking-normal">
                            BDT 500</p>
                    </label>
                </div>
                <div>
                    <label for="value_1000"
                        class="flex cursor-pointer px-8 py-3 items-center justify-center rounded-full border-black group bg-transparent text-gray-900 hover:text-[#1799EA] border  hover:border-[#1799EA] has-[:checked]:border-blue-500 has-[:checked]:bg-[#1799EA] has-[:checked]:text-white">
                        <input type="radio" name="ColorOption" value="1000" id="value_1000" class="sr-only"
                            checked />

                        <p
                            class="bg-transparent text-black group-has-[:checked]:text-white rounded-full text-lg font-medium leading-7 tracking-normal">
                            BDT 1000</p>
                    </label>
                </div>
                <div>
                    <label for="value_5000"
                        class="flex cursor-pointer px-8 py-3 items-center justify-center rounded-full border-black group bg-transparent text-gray-900 hover:text-[#1799EA] border  hover:border-[#1799EA] has-[:checked]:border-blue-500 has-[:checked]:bg-[#1799EA] has-[:checked]:text-white">
                        <input type="radio" name="ColorOption" value="5000" id="value_5000" class="sr-only"
                            checked />

                        <p
                            class="bg-transparent text-black group-has-[:checked]:text-white rounded-full text-lg font-medium leading-7 tracking-normal">
                            BDT 5000</p>
                    </label>
                </div>
                <div>
                    <label for="value_custom"
                        class="flex cursor-pointer px-8 py-3 items-center justify-center rounded-full border-black group bg-transparent text-gray-900 hover:text-[#1799EA] border  hover:border-[#1799EA] has-[:checked]:border-blue-500 has-[:checked]:bg-[#1799EA] has-[:checked]:text-white">
                        <input type="radio" name="ColorOption" id="value_custom" class="sr-only" checked />

                        <p
                            class="bg-transparent text-black group-has-[:checked]:text-white rounded-full text-lg font-medium leading-7 tracking-normal">
                            {{ __('Custom') }}</p>
                    </label>
                </div>

            </fieldset>
            <div class="flex mb-12">
                <a href="{{ route('current-campaigns') }}"
                    class="flex w-max xl:w-fit bg-white rounded-full justify-between gap-2 items-center pl-[24px] pr-2 py-[6px] w-full">
                    <span class="text-lg font-semibold leading-7 tracking-normal text-[#101828]">
                        {{ __('Donate Now') }}
                    </span>
                    <span class="rounded-full bg-[rgb(2_31_23)] p-4">
                        <img src="{{ asset('web-assets/icons/donate-white.svg') }}" alt="Donate Icon">
                    </span>
                </a>
            </div>
            <h4 class="text-[44px] font-medium leading-[71px] tracking-[0] text-[#101828] mb-4">{{ __('Successful Donors') }}</h4>
            <img src="{{ asset('web-assets/images/donor_image.png') }}" alt="Donate Image" class="w-fit">
        </div>
    </div>
</div>
