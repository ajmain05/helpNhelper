@php
    $heroSectionTitle = __('Contact');
    $bgImage = asset('web-assets/images/current-campaigns.png');
@endphp
<x-web-layout>
    <div>
        <x-hero-section :type="2" :title="$heroSectionTitle" :bgImage="$bgImage"></x-hero-section>
        {{-- <div class="py-0 xl:py-12"
            style="background: linear-gradient(180.00deg, rgb(2, 31, 23) 21.836%,rgba(2, 31, 23, 0) 102.01%,rgba(2, 31, 23, 0) 125.868%), url('{{ asset('web-assets/images/campaign-collection.png') }}');"> --}}
        <div class="py-12 bg-[rgb(2_31_23)]">
            <x-contact />
        </div>
    </div>
    <x-slot name="title">HelpNHelper - Contact</x-slot>
</x-web-layout>
