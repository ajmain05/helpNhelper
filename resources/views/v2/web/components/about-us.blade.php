@php
    $image = $image1 ?? 'web-assets/images/about-us-1.png';
    // Split description into paragraphs if it's not empty
    $paragraphs = !empty($description) ? explode("\n", $description) : [];
@endphp

<div class="custom-container">
    <div class="flex gap-10 flex-col xl:flex-row">
        {{-- Left: Tall Image --}}
        <div class="w-full xl:w-2/5 flex-shrink-0 overflow-hidden rounded-2xl">
            <img src="{{ asset($image) }}" alt="About Us"
                class="w-full h-full object-cover">
        </div>
        {{-- Right: Title + All content --}}
        <div class="flex w-full xl:w-3/5 flex-col">
            <h3 class="text-4xl font-semibold tracking-[0] text-white mb-8">
                {{ $title }}
            </h3>
            <div class="text-white text-[18px] font-semibold leading-[34px] tracking-[0] space-y-4">
                @foreach ($paragraphs as $para)
                    @if (trim($para))
                        <p>{!! nl2br(e($para)) !!}</p>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
