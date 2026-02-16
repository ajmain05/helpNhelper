<div class="flex justify-center items-center space-x-4 mt-6">
    <!-- Previous Page Link -->
    @if ($campaigns->onFirstPage())
        <span
            class="px-4 py-2 text-lg font-semibold tracking-normal text-white bg-transparent border-[1.5px] border-solid border-white rounded-full">‹
            Previous</span>
    @else
        <a href="{{ $campaigns->previousPageUrl() }}"
            class="px-4 py-2 text-lg font-semibold tracking-normal text-[#101828] bg-white border-[1.5px] border-solid border-white rounded-full"
            @if ($campaigns->onFirstPage()) disabled @endif>
            ‹ Previous
        </a>
    @endif

    <!-- Pagination Links -->
    <div class="flex items-center space-x-1 rounded-[100px] bg-[#ffffff4d] p-2">
        @foreach ($campaigns->getUrlRange(1, min($campaigns->lastPage(), 2)) as $page => $url)
            @if ($page == $campaigns->currentPage())
                <span
                    class="text-lg font-medium tracking-normal bg-white text-[#101828] rounded-full px-[14px] py-[3px]">{{ $page }}</span>
            @else
                <a href="{{ $url }}"
                    class="px-3 py-1 hover:text-[#101828] hover:bg-slate-200 text-lg font-medium tracking-normal rounded-full text-white">{{ $page }}</a>
            @endif
        @endforeach

        @if ($campaigns->lastPage() > 2)
            <span class="px-3 py-1 text-gray-500">...</span>
            <a href="{{ $campaigns->url($campaigns->lastPage()) }}"
                class="px-3 py-1 text-blue-500 hover:bg-blue-100 rounded">
                {{ $campaigns->lastPage() }}
            </a>
        @endif
    </div>

    <!-- Next Page Link -->
    @if ($campaigns->hasMorePages())
        <a href="{{ $campaigns->nextPageUrl() }}"
            class="px-4 py-2 text-lg font-semibold tracking-normal text-[#101828] bg-white border-[1.5px] border-solid border-white rounded-full">
            Next ›
        </a>
    @else
        <span
            class="px-4 py-2 text-lg font-semibold tracking-normal text-white bg-transparent border-[1.5px] border-solid border-white rounded-full">Next
            ›</span>
    @endif
</div>
