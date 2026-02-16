<div class="custom-container">
    <div class="flex flex-col pt-9">
        <div class="flex justify-between py-[18px]">
            <h3 class="text-[52px] font-semibold leading-[86px] tracking-[0] text-center text-white">{{ __('Gallery') }}</h3>
            <div class="flex gap-5">
                <div class="gallery-prev swiper-button-prev custom-navigation-btn relative"></div>
                <div class="gallery-next swiper-button-next custom-navigation-btn relative"></div>
            </div>
        </div>
        <div class="w-full mx-auto flex flex-col">
            <div class="block">
                <div class="swiper gallery-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($campaignImages as $image)
                        <div class="swiper-slide">
                            <div class="flex border-4 border-white rounded-[24px] overflow-hidden">
                                <img src="{{ asset($image->image) }}" alt="Campaign Image"
                                    class="w-full">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
