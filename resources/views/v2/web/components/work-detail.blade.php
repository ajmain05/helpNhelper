<div class="custom-container">
    <div class="flex flex-col">
        <div class="flex justify-between mb-8 flex-col xl:flex-row">
            <div class="flex max-w-[600px] w-full xl:w-1/2 rounded-2xl overflow-hidden">
                <img class="w-full" src="{{ asset($work->photo) }}" alt="Work Image">
            </div>
            <div class="flex flex-col w-full xl:w-1/2">
                <h3 class="text-4xl text-white font-semibold mb-4">{{ $work->getTranslation('title') }}</h3>
                <h4 class="text-2xl text-white font-medium mb-2">{{ __('Short Description') }}</h4>
                <p class="text-lg font-regular text-white">{{ $work->getTranslation('short_description') }}</p>
            </div>
        </div>
        <div class="flex flex-col mb-8">
            <h4 class="text-2xl text-white font-medium mb-3">{{ __('Long Description') }}</h4>
            <p class="text-lg font-regular text-white">{{ $work->getTranslation('long_description') }}</p>
        </div>
        <div class="flex justify-between gap-8 flex-col xl:flex-row">
            <div class="flex flex-col w-full xl:w-1/2 ">
                <h4 class="text-2xl text-white font-medium mb-3">{{ __('Previous Condition') }}</h4>
                <div class="flex rounded-2xl overflow-hidden">
                    <img class="w-full" src="{{ asset($work->previous_condition) }}" alt="Work Present Condition">
                </div>
            </div>
            <div class="flex flex-col w-full xl:w-1/2 ">
                <h4 class="text-2xl text-white font-medium mb-3">{{ __('Present Condition') }}</h4>
                <div class="flex rounded-2xl overflow-hidden">
                    <img class="w-full" src="{{ asset($work->present_condition) }}" alt="Work Previous Condition">
                </div>
            </div>
        </div>
    </div>

</div>
