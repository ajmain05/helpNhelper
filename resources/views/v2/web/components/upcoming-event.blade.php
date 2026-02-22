<div class="flex flex-col bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('web-assets/images/hero_img.png') }}')">
    <div class="pt-[128px] pb-60"
        style="background: linear-gradient(92deg, rgba(2, 31, 23, 0.6) -4.171%, rgba(2, 31, 23, 0) 87.542%);">
        <div class="max-w-[1200px] mx-auto w-full flex flex-col">
            <div class="flex flex-col max-w-[580px]">
                <h3 class="text-[52px] font-semibold leading-[56px] tracking-[0] text-white mb-9">{{ __('Join Upcoming Events & Webinars') }}
                </h3>
                <div class="flex flex-col gap-7 mb-9">
                    <div class="flex gap-6 border-white border-[1.5px] rounded-[24px] px-8 py-4">
                        <div class="flex flex-col">
                            <h4 class="text-[48px] font-bold leading-[58px] tracking-[0] text-[#27E36A]">28</h4>
                            <p class="text-[24px] font-medium leading-[29px] tracking-[0] text-white">OCT</p>
                        </div>
                        <div class="flex flex-col justify-center">
                            <h5 class="text-[22px] font-semibold leading-[25px] tracking-[0] text-white mb-4">{{ __('Charity Meetup - The Future of Charity') }}</h5>
                            <div class="flex">
                                <span class="flex mr-1">
                                    <img src="{{ asset('web-assets/icons/clock.svg') }}" alt="Clock Icon">
                                </span>
                                <span class="text-white text-[14px] font-medium leading-[25px] tracking-[0] mr-4">3:00
                                    PM -
                                    6:00
                                    PM</span>
                                <span class="flex mr-1">
                                    <img src="{{ asset('web-assets/icons/location.svg') }}" alt="Location Icon">
                                </span>
                                <span class="text-white text-[14px] font-medium leading-[25px] tracking-[0]">Park
                                    Street,
                                    NY</span>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="text-white text-[36px] font-medium leading-[40px] tracking-[0] mb-5">{{ __('Your Help Is Very Important') }}
                </h3>
                <a href="#"
                    class="text-[18px] font-semibold leading-[28px] tracking-[0] py-5 px-10 text-white bg-[rgb(23_153_234)] rounded-full w-fit">{{ __('Become a Donor') }}</a>
            </div>
        </div>
    </div>
</div>
