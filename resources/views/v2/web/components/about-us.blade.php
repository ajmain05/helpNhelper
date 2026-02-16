@php
    $desc = __('about_us_content');
    if ($desc === 'about_us_content') {
        $desc = __($description);
    }
    $paragraphs = explode("\n", $desc);
@endphp
<div class="custom-container">
    <div class="flex justify-between gap-10 mb-5 flex-col xl:flex-row">
        <div class="flex w-full xl:w-1/2 overflow-hidden rounded-2xl items-start">
            <img src="{{ asset($image1 ?? 'web-assets/images/about-us-1.png') }}" alt="About Us" class="w-full">
        </div>
        <div class="flex w-full xl:w-1/2  flex-col">
            <h3 class="text-4xl font-semibold tracking-[0] text-white mb-8">{{ __($title ?? 'We are here to help you!') }}
            </h3>
            @if (!empty($paragraphs))
                <p class="text-white text-[20px] font-semibold leading-[35px] tracking-[0] mb-4">
                    {!! html_entity_decode($paragraphs[0]) !!}</p>
            @endif
        </div>
    </div>
    @if (count($paragraphs) > 1)
        <p class="text-white text-[20px] font-semibold leading-[35px] tracking-[0] mb-10"> {!! html_entity_decode($paragraphs[1]) !!}
        </p>
    @endif
    @if (count($paragraphs) > 2)
        <div class="flex justify-between gap-4 flex-col xl:flex-row">
            <p class="text-white text-[20px] font-semibold leading-[35px] tracking-[0] w-full xl:w-3/5">
                {!! html_entity_decode($paragraphs[2]) !!}</p>
            <div class="flex overflow-hidden rounded-2xl w-full xl:w-2/5">
                <img src="{{ asset($image2 ?? 'web-assets/images/about-us-2.png') }}" alt="About Us" class="w-full">
            </div>
        </div>
    @endif
</div>
