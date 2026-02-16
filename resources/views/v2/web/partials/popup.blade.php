<div role="alert"
    class="message-popup {{ $type }}-message flex justify-between items-start rounded border-s-4 @if ($type == 'success') border-green-500 bg-green-50 @else border-red-500 bg-red-50 @endif p-4 w-[95%] md:w-full max-w-[600px] mx-auto fixed left-[10px] md:left-1/3 z-10">
    <div class="">
        <strong class="block font-medium @if ($type == 'success') text-green-800 @else text-red-800 @endif">
            {{ ucfirst($type) }} </strong>

        <p class="mt-2 text-sm @if ($type == 'success') text-green-700 @else text-red-700 @endif">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo quasi assumenda numquam deserunt
            consectetur autem nihil quos debitis dolor culpa.
        </p>
    </div>
    <button id="dismiss-popup" onclick="this.closest('div[role=alert]').classList.add('hidden')"
        class=" transition  @if ($type == 'success') text-gray-400 hover:text-gray-600 @else text-red-400 hover:text-red-600 @endif">
        <span class="sr-only">Dismiss popup</span>

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
