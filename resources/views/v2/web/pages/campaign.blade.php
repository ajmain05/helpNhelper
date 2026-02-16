@php
    $heroSectionTitle = $campaign->getTranslation('title');
    $bgImage = asset('web-assets/images/current-campaigns.png');
@endphp
<x-web-layout>
    <div>
        <x-hero-section :campaign="$campaign" :type="3" :title="$heroSectionTitle" :bgImage="$bgImage"></x-hero-section>
        {{-- <div class="py-12"
            style="background: linear-gradient(180.00deg, rgb(2, 31, 23) 21.836%,rgba(2, 31, 23, 0) 102.01%,rgba(2, 31, 23, 0) 125.868%), url('{{ asset('web-assets/images/campaign-collection.png') }}');"> --}}
        <div class="py-12 bg-[rgb(2_31_23)]">
            <x-campaign-detail :campaign="$campaign" />
            <x-gallery :campaignImages="$campaign->images" />
            <x-featured-collection :type="2" :campaigns="$campaigns"></x-featured-collection>
        </div>
    </div>
    <x-slot name="title">HelpNHelper - Current Campaigns</x-slot>

    <x-slot name="styles">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    </x-slot>
    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            let featuredCollectionSwiper = new Swiper(".related-products-swiper", {
                spaceBetween: 30,
                slidesPerView: 3,
                navigation: {
                    nextEl: ".featured-collection-next",
                    prevEl: ".featured-collection-prev",
                },
                breakpoints: {
                    // when window width is >= 320px
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    // when window width is >= 480px
                    568: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    // when window width is >= 640px
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30
                    }
                }
            });
            let gallerySwiper = new Swiper(".gallery-swiper", {
                spaceBetween: 30,
                slidesPerView: 5.2,
                navigation: {
                    nextEl: ".gallery-next",
                    prevEl: ".gallery-prev",
                },
                breakpoints: {
                    // when window width is >= 320px
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    // when window width is >= 480px
                    568: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    // when window width is >= 640px
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30
                    }
                }
            });
        </script>
    </x-slot>
</x-web-layout>
