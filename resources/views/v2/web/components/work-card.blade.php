@php
    $url = route('web.our-work', $work->id);
@endphp
<div class="flex flex-col items-start bg-white px-4 py-5 border-1.5 border-gray-400 rounded-[24px] w-full">
    <img src="{{ asset($work->photo ?? 'web-assets/images/fc_image.png') }}" alt="Campaign Image"
        class="object-cover object-center mb-[28px] rounded-[16px] w-full max-w-[452px] h-[370px]">
    <h4 class="text-[28px] font-medium leading-[34px] tracking-[0] mb-[10px] text-[#101828]">{{ $work->getTranslation('title') }}</h4>
    <p class="text-[16px] font-medium leading-[28px] tracking-[0] mb-[22px] text-[#101828]">
        {{ $work->getTranslation('short_description') }}</p>
    <a href="{{ $url }}"
        class="flex justify-center w-full border border-solid border-[#021F17] rounded-full text-lg tracking-normal font-semibold py-3 px-4 text-center">See
        More
        ></a>
</div>
