{{-- <div class="bg-cover bg-no-repeat bg-top"
    style="background-image: url('{{ asset('web-assets/images/campaign-collection.png') }}')"> --}}
<div class="py-12 bg-[rgb(2_31_23)]">
    <div class="custom-container">
        <div class="pt-6 pb-9">
            <x-campaign-filter :campaignCategory="$campaignCategory"></x-campaign-filter>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                @forelse ($campaigns as $campaign)
                    <x-campaign-card :campaign="$campaign"></x-campaign-card>
                @empty
                    <div
                        class="col-span-full flex flex-col items-center justify-center text-center py-12 bg-gray-100 rounded-xl">
                        <h2 class="text-lg font-semibold text-gray-700">{{ __('No campaigns found') }}</h2>
                        <p class="text-sm text-gray-500 mt-2">{{ __('Try adjusting your filters or search keywords.') }}</p>
                    </div>
                @endforelse
            </div>
            <x-campaign-pagination :campaigns="$campaigns"></x-campaign-pagination>
        </div>
    </div>
</div>
