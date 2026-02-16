@php
    $longDescription = $campaign->getTranslation('long_description');
    $parts = explode('.', $longDescription);
    $parts = array_filter(array_map('trim', $parts));
    $totalParts = count($parts);
    if ($totalParts <= 2) {
        $firstPart = implode('. ', $parts) . '.';
        $middlePart = '';
        $lastPart = '';
    } elseif ($totalParts >= 3 && $totalParts <= 5) {
        $firstPart = implode('. ', array_slice($parts, 0, 2)) . '.';
        $middlePart = implode('. ', array_slice($parts, 2)) . '.';
        $lastPart = '';
    } else {
        // First 2 sentences
        $firstPart = implode('. ', array_slice($parts, 0, 2)) . '.';

        // Middle sentences
        $middlePart = implode('. ', array_slice($parts, 2, $totalParts - 5)) . '.';

        // Last 3 sentences
        $lastPart = implode('. ', array_slice($parts, -3)) . '.';
    }
@endphp
<div>
    <div class="custom-container">
        <div class="flex items-center gap-10 flex-col lg:flex-row">
            @if ($campaign->photo)
                <div class="flex max-w-[500px] w-full lg:w-1/2">
                    <img class="w-full rounded-2xl" src="{{ asset($campaign->photo) }}" alt="Campaign thumbnail">
                </div>
            @endif
            <div class="w-full lg:w-1/2 self-start">
                <p class="text-xl font-medium tracking-[0] text-white mb-10">
                    {!! nl2br(e($campaign->getTranslation('short_description') ?? '-')) !!}
                </p>

                <p class="text-xl font-medium tracking-[0] text-white">{!! nl2br(e($firstPart)) !!}</p>
            </div>

        </div>
        <div class="flex flex-col gap-8 my-8">
            <p class="text-xl font-medium tracking-[0] text-white">
                {!! nl2br(e($middlePart)) !!}
            </p>

            <div class="flex justify-between gap-10 flex-col lg:flex-row">
                <div class="flex flex-col gap-5 max-w-[830px]">
                    <p class="text-xl font-medium tracking-[0] text-white">{!! nl2br(e($lastPart)) !!}</p>
                    <div class="flex flex-col gap-4 mb-10 items-start">
                        <a href="{{ route('donation', $campaign->id) }}" class="custom-btn-1">
                            <span class="text-lg font-semibold leading-7 tracking-normal text-[#101828]">{{ __('Donate Now') }}</span>
                            <span class="bg-white/55 p-4 rounded-full">
                                <svg width="24.000000" height="18.000000" viewBox="0 0 24 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs />
                                    <path id="Vector"
                                        d="M9.23 15.57C8.89 15.62 8.54 15.68 8.16 15.75C7.79 15.82 7.35 15.94 6.86 16.11C6.36 16.28 5.79 16.52 5.14 16.82C4.49 17.12 3.71 17.51 2.82 18L0 13.91C1.9 12.79 3.42 11.9 4.56 11.25C5.69 10.61 6.59 10.12 7.24 9.8C7.89 9.48 8.37 9.27 8.69 9.18C9 9.09 9.3 9.03 9.59 9C10.15 8.94 10.78 8.9 11.48 8.9C12.18 8.9 12.86 8.88 13.54 8.83C14.22 8.81 14.83 8.79 15.37 8.76C15.91 8.74 16.33 8.77 16.62 8.87C16.88 8.94 17.02 9.07 17.02 9.26C17.02 9.46 16.96 9.63 16.84 9.76C16.69 9.88 16.52 9.97 16.33 10.04C16.14 10.11 15.92 10.18 15.68 10.25C15.46 10.3 15.25 10.34 15.04 10.37C14.84 10.4 14.64 10.44 14.45 10.49C14.25 10.54 14.08 10.57 13.94 10.59C13.79 10.62 13.65 10.67 13.51 10.77C13.36 10.86 13.21 10.97 13.05 11.11C12.9 11.25 12.72 11.41 12.53 11.6C13.47 11.64 14.28 11.67 14.97 11.67C15.66 11.67 16.25 11.65 16.75 11.63C17.24 11.61 17.66 11.58 18.01 11.54C18.36 11.51 18.67 11.47 18.94 11.42C19.47 11.31 19.9 11.16 20.22 10.99C20.55 10.82 20.84 10.64 21.11 10.46C21.38 10.25 21.63 10.04 21.87 9.83C22.11 9.63 22.33 9.46 22.52 9.35C22.91 9.12 23.23 9.06 23.5 9.18C23.77 9.31 23.92 9.51 23.97 9.76C24.02 9.88 23.99 10.01 23.9 10.16C23.8 10.31 23.57 10.57 23.21 10.94C23.02 11.1 22.79 11.29 22.54 11.51C22.29 11.73 22.02 11.96 21.74 12.2C21.47 12.44 21.19 12.68 20.91 12.91C20.63 13.14 20.37 13.34 20.13 13.5C19.67 13.84 19.31 14.07 19.05 14.19C18.78 14.31 18.49 14.41 18.18 14.5C17.55 14.64 16.78 14.75 15.86 14.85C14.94 14.94 13.93 15.04 12.82 15.16C12.26 15.2 11.69 15.26 11.11 15.31C10.54 15.37 9.91 15.46 9.23 15.57L9.23 15.57ZM11.44 6.27C10.91 5.95 10.41 5.57 9.95 5.13C9.5 4.69 9.13 4.22 8.87 3.71C8.63 3.23 8.52 2.73 8.56 2.23C8.6 1.72 8.81 1.25 9.19 0.81C9.36 0.6 9.59 0.41 9.86 0.24C10.14 0.07 10.47 -0.01 10.86 0C11.25 0.01 11.67 0.14 12.15 0.39C12.62 0.65 13.14 1.07 13.72 1.67C14.3 1.07 14.83 0.65 15.31 0.39C15.8 0.14 16.23 0.01 16.62 0C17 -0.02 17.33 0.07 17.6 0.24C17.86 0.41 18.09 0.6 18.28 0.81C18.67 1.25 18.88 1.72 18.92 2.23C18.95 2.73 18.84 3.23 18.57 3.71C18.31 4.22 17.95 4.69 17.51 5.13C17.06 5.57 16.56 5.95 16 6.27C15.59 6.53 15.19 6.76 14.79 6.96C14.39 7.17 14.1 7.47 13.9 7.86C13.85 7.95 13.8 8 13.74 8C13.68 8 13.62 7.95 13.58 7.86C13.38 7.47 13.09 7.17 12.69 6.96C12.29 6.76 11.87 6.52 11.44 6.27L11.44 6.27ZM9.52 1.5C9.37 1.82 9.33 2.11 9.37 2.36C9.4 2.6 9.47 2.69 9.59 2.64C9.64 2.62 9.71 2.48 9.81 2.23C9.86 2.11 9.9 2 9.95 1.88C10 1.77 10.09 1.65 10.21 1.54C10.35 1.35 10.54 1.24 10.79 1.19C10.91 1.14 11.02 1.13 11.11 1.14C11.21 1.15 11.28 1.16 11.33 1.16C11.5 1.11 11.57 1.06 11.55 1.02C11.5 0.86 11.35 0.75 11.11 0.71C10.85 0.59 10.56 0.61 10.24 0.77C9.9 0.94 9.66 1.18 9.52 1.5L9.52 1.5ZM15.64 11.49C16.15 11.1 16.64 10.75 17.11 10.44C17.58 10.13 17.97 9.88 18.28 9.7C18.62 9.51 18.9 9.38 19.12 9.31C19.33 9.25 19.66 9.23 20.09 9.28C19.64 9.63 19.15 9.97 18.63 10.32C18.11 10.66 17.56 11.03 16.98 11.42C16.81 11.45 16.61 11.47 16.38 11.48C16.15 11.49 15.91 11.49 15.64 11.49L15.64 11.49ZM19.41 11.01C19.19 11.08 18.92 11.15 18.61 11.22C18.29 11.29 17.88 11.34 17.38 11.39C18.17 10.91 18.8 10.49 19.26 10.13C19.72 9.77 20.1 9.49 20.42 9.28C20.73 9.1 21.02 8.99 21.27 8.95C21.52 8.92 21.87 9 22.3 9.21C21.96 9.47 21.64 9.7 21.34 9.92C21.04 10.14 20.78 10.33 20.56 10.49C20.32 10.65 20.12 10.77 19.97 10.84C19.81 10.91 19.62 10.96 19.4 11.01L19.41 11.01Z"
                                        fill="#101828" fill-opacity="1.000000" fill-rule="nonzero" />
                                </svg>
                            </span>
                        </a>
                        
                        <!-- Share Button -->
                        <button onclick="toggleShareModalDetails('{{ $campaign->id }}', '{{ addslashes($campaign->getTranslation('title')) }}', '{{ route('campaign', $campaign->id) }}')" 
                            class="flex justify-center items-center bg-[#1799ea] hover:bg-[#1589d1] px-6 py-2 rounded-[100px] transition-colors h-[52px]" title="{{ __('Share') }}">
                            <span class="text-[16px] font-semibold leading-7 tracking-normal text-white">{{ __('Share') }}</span>
                        </button>
                    </div>
                </div>
                @if ($campaign?->photo)
                    <div class="flex  max-w-[600px]">
                        <img class="w-full rounded-2xl" src="{{ asset($campaign->photo) }}" alt="Campaign Details">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@php
    $url = route('campaign', $campaign->id);
@endphp

<!-- Social Share Modal -->
<div id="shareModalDetails-{{ $campaign->id }}" onclick="event.stopPropagation(); closeShareModalDetails('{{ $campaign->id }}')" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div onclick="event.stopPropagation()" class="bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-2xl w-[90%] max-w-md transform scale-95 transition-transform duration-300 border border-white/20">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">{{ __('Share this campaign') }}</h3>
            <button onclick="closeShareModalDetails('{{ $campaign->id }}')" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-4 gap-4 mb-6">
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}" target="_blank" class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                </div>
                <span class="text-xs font-medium text-gray-600">Facebook</span>
            </a>

             <!-- Twitter/X -->
             <a href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}&text={{ urlencode($campaign->getTranslation('title')) }}" target="_blank" class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-100 text-gray-900 group-hover:bg-black group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </div>
                <span class="text-xs font-medium text-gray-600">Twitter</span>
            </a>

            <!-- LinkedIn -->
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($url) }}" target="_blank" class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-50 text-blue-700 group-hover:bg-blue-700 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                </div>
                <span class="text-xs font-medium text-gray-600">LinkedIn</span>
            </a>


        </div>

        <div class="relative">
            <label class="text-sm font-medium text-gray-700 mb-2 block">{{ __('Page Link') }}</label>
            <div class="flex items-center gap-2 bg-gray-50 rounded-lg p-2 border border-gray-200">
                <input type="text" value="{{ $url }}" readonly class="bg-transparent border-none text-sm text-gray-600 w-full focus:ring-0">
                <button onclick="copyToClipboardDetails('{{ $url }}')" class="p-2 text-gray-500 hover:text-green-600 transition-colors" title="{{ __('Copy Link') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleShareModalDetails(id, title = '', url = '') {
        const modal = document.getElementById('shareModalDetails-' + id);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            // Small delay to allow display:block to apply before opacity transition
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div').classList.remove('scale-95');
                modal.querySelector('div').classList.add('scale-100');
            }, 10);
        } else {
            closeShareModalDetails(id);
        }
    }

    function closeShareModalDetails(id) {
        const modal = document.getElementById('shareModalDetails-' + id);
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.remove('scale-100');
        modal.querySelector('div').classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function copyToClipboardDetails(text, platform = null) {
        navigator.clipboard.writeText(text).then(() => {
            if (platform) {
                alert(platform + ' does not support web sharing. Link copied to clipboard!');
            } else {
                alert('Link copied to clipboard!');
            }
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>

