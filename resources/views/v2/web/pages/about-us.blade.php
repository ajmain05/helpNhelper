@php
    $heroSectionTitle = __('About Us');
    $bgImage = asset('web-assets/images/current-campaigns.png');
@endphp
<x-web-layout>
    <div>
        <x-hero-section :type="2" :title="$heroSectionTitle" :bgImage="$bgImage"></x-hero-section>
        {{-- <div class="py-12"
            style="background: linear-gradient(180.00deg, rgb(2, 31, 23) 21.836%,rgba(2, 31, 23, 0) 102.01%,rgba(2, 31, 23, 0) 125.868%), url('{{ asset('web-assets/images/campaign-collection.png') }}');"> --}}
        <div class="py-12 bg-[rgb(2_31_23)]">
            @php
                $locale = app()->getLocale();
                $titleField = $locale == 'en' ? 'title' : 'title_' . $locale;
                $descField = $locale == 'en' ? 'description' : 'description_' . $locale;
                $aboutTitle = $about->$titleField ?? $about->title;
                $aboutDesc = $about->$descField ?? $about->description;
            @endphp
            <x-about-us
                :image1="$about?->image_1 ?? null"
                :title="$aboutTitle"
                :description="$aboutDesc" />

            <x-team :teams="$teams" :shariah="$shariah" />
        </div>
    </div>
    <x-slot name="title">HelpNHelper - About Us</x-slot>
</x-web-layout>
