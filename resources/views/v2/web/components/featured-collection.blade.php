@if ($type == 1)
    <div class="flex flex-col pt-5 xl:pt-[128px] bg-cover bg-center bg-no-repeat pb-5 xl:pb-16"
        style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('web-assets/v2-images/home/2nd Stage-Donation content 1920-1080- Final.webp') }}');">

        <div class="flex justify-center bg-[#021f1754] py-[18px] px-[20px]">
            <h3
                class="text-[30px] xl:text-[52px]  font-semibold leadding-[50px] xl:leading-[86px] tracking-[0] text-center text-white">
                {{ __('Donate to Make an Impact') }}</h3>
        </div>
        <div class="max-w-[1200px] w-full mx-auto flex flex-col">
            <div class="flex flex-col xl:flex-row gap-[28px] mt-[44px] {{ $type }}">
                @foreach ($campaigns as $campaign)
                    <x-campaign-card :type="$type" :campaign="$campaign"></x-campaign-card>
                @endforeach
            </div>
            <div class="flex justify-center mt-[68px]">
                <a href="{{ route('current-campaigns') }}"
                    class="text-[18px] font-semibold leading-[28px] tracking-[0%] py-5 px-24 text-white bg-[rgb(23_153_234)] rounded-full">{{ __('VIEW ALL') }}</a>
            </div>
        </div>
    </div>
@elseif($type == 2)
    <div class="custom-container">
        <div class="flex flex-col pt-9">
            <div class="flex justify-between py-[18px]">
                <h3 class="text-[52px] font-semibold leading-[86px] tracking-[0] text-center text-white">{{ __('Recent Campaigns') }}</h3>
                <div class="flex gap-5">
                    <div class="featured-collection-prev swiper-button-prev custom-navigation-btn relative"></div>
                    <div class="featured-collection-next swiper-button-next custom-navigation-btn relative"></div>
                </div>
            </div>
            <div class="w-full mx-auto flex flex-col">
                <div class="flex flex-wrap overflow-hidden gap-[28px]">
                    <div class="swiper related-products-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($campaigns as $campaign)
                                <div class="swiper-slide">
                                    <x-campaign-card :campaign="$campaign"></x-campaign-card>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="flex justify-center mt-[68px]">
                    <a href="{{ route('current-campaigns') }}"
                        class="text-[18px] font-semibold leading-[28px] tracking-[0%] py-5 px-24 text-white bg-[rgb(23_153_234)] rounded-full">{{ __('VIEW ALL') }}</a>
                </div>
            </div>
        </div>
    </div>
@endif
