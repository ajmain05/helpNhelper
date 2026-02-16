@php
    $heroSectionTitle = __('Campaigns');
    $bgImage = asset('web-assets/images/current-campaigns.png');
@endphp
<x-web-layout>
    <div>
        <x-hero-section :type="2" :title="$heroSectionTitle" :bgImage="$bgImage"></x-hero-section>
        <x-campaign-collection :campaigns="$campaigns" :campaignCategory="$campaignCategory"></x-campaign-collection>
    </div>
    <x-slot name="title">HelpNHelper - Current Campaigns</x-slot>
</x-web-layout>
