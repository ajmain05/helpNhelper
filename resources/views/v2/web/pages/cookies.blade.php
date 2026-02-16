<x-web-layout>
    <div class="bg-[#01261d] min-h-screen pt-[150px] pb-[100px]">
        <div class="custom-container">
            @php
                $content = \App\Models\Content::where('type', 'cookies')->first();
            @endphp
             <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold mb-8 text-white text-center">{{ __($content->title ?? 'Cookie Preferences') }}</h1>
                <div class="prose prose-lg prose-invert max-w-none text-gray-300 bg-[#023b2e] p-8 md:p-12 rounded-3xl shadow-xl">
                    {!! $content->description ?? __('Content for Cookie Preferences goes here...') !!}
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
