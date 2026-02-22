@php
    $heroSectionTitle = __('home_hero_title');
    $bgImage = asset('web-assets/v2-images/home/1st home page cover.jpg');
@endphp
<x-web-layout>
    <div>
        <div role="alert"
            class="message-popup @if (session('verifiedMessage')) active @endif flex justify-between items-start rounded border-s-4 border-green-500 bg-green-50 p-4 w-[95%] md:w-full max-w-[600px] mx-auto fixed left-[10px] md:left-1/3 z-10">
            <div class="">
                <strong class="block font-medium text-green-800"> Congratulations </strong>

                <p class="mt-2 text-sm text-green-700">
                    {{ session('verifiedMessage') }}
                </p>
            </div>
            <button id="dismiss-popup" class="text-gray-400-400 transition hover:text-gray-600">
                <span class="sr-only">Dismiss popup</span>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <x-hero-section :type="1" :title="$heroSectionTitle" :bgImage="$bgImage" :contents="$heroSectionContents"></x-hero-section>
        <x-featured-collection :campaigns="$campaigns"></x-featured-collection>
        <x-donate></x-donate>
        {{-- <x-upcoming-event></x-upcoming-event> --}}
        <x-marquee-text :keywords="['Support', 'Help', 'Love']" :length=6 :type=1></x-marquee-text>
        <x-marquee-text :keywords="['Help', 'Love', 'Support']" :length=6 :type=2></x-marquee-text>
        <x-faq :faqs="$faqs"></x-faq>
        <x-map></x-map>
    </div>
    <x-slot name="title">HelpNHelper - Home</x-slot>
    <x-slot name="scripts">
        <script>
            const closePopupBtn = document.querySelector("#dismiss-popup");
            const popup = document.querySelector(".message-popup");
            closePopupBtn.addEventListener("click", () => {
                popup.classList.add("hidden");
            });
        </script>
    </x-slot>
</x-web-layout>
