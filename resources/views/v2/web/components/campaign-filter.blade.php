<form action="{{ route('current-campaigns') }}" method="GET">
    <div class="flex flex-col lg:flex-row flex-wrap items-stretch gap-4">
        <div class="flex-1 min-w-[150px]">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search campaigns..."
                class="w-full px-4 py-2 rounded-full bg-gray-600 text-white placeholder-white focus:outline-none hover:bg-gray-500" />
        </div>

        <div class="min-w-[150px]">
            <select
                class="w-full px-4 py-2 cursor-pointer bg-gray-600 text-white rounded-full hover:bg-gray-500 focus:outline-none bg-no-repeat pr-[2.5rem] appearance-none"
                name="category"
                style="background-image: url('{{ asset('web-assets/icons/down-arrow.svg') }}');background-position-x: 98%;background-position-y: 50%;">
                <option value="">Select Category</option>
                <option value="all" @if ('all' == old('category')) selected @endif>All</option>
                @foreach ($campaignCategory as $category)
                    <option value="{{ $category->id }}" @if ($category->id == old('category')) selected @endif>
                        {{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="min-w-[150px]">
            <select
                class="w-full px-4 py-2 cursor-pointer bg-gray-600 text-white rounded-full hover:bg-gray-500 focus:outline-none bg-no-repeat pr-[2.5rem] appearance-none"
                name="sort"
                style="background-image: url('{{ asset('web-assets/icons/down-arrow.svg') }}');background-position-x: 98%;background-position-y: 50%;">
                <option value="">Order By</option>
                <option value="asc" @if ('asc' == old('sort')) selected @endif>Old to new</option>
                <option value="desc" @if ('desc' == old('sort')) selected @endif>New to old</option>
            </select>
        </div>

        <div class="min-w-[150px]">
            <select
                class="w-full px-4 py-2 cursor-pointer bg-gray-600 text-white rounded-full hover:bg-gray-500 focus:outline-none bg-no-repeat pr-[2.5rem] appearance-none"
                name="per_page"
                style="background-image: url('{{ asset('web-assets/icons/down-arrow.svg') }}');background-position-x: 98%;background-position-y: 50%;">
                <option value="">Select campaign per page</option>
                <option value="5" @if ('5' == old('per_page')) selected @endif>5 Per Page</option>
                <option value="10" @if ('10' == old('per_page')) selected @endif>10 Per Page</option>
                <option value="20" @if ('20' == old('per_page')) selected @endif>20 Per Page</option>
                <option value="30" @if ('30' == old('per_page')) selected @endif>30 Per Page</option>
            </select>
        </div>

        <div class="min-w-[150px]">
            <button
                class="w-full px-4 py-2 text-black bg-green-500 rounded-full hover:bg-green-400 font-semibold flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-5 w-5" fill="currentColor">
                    <path
                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                </svg>
                Apply
            </button>
        </div>

        <div class="min-w-[150px]">
            <a type="button" href="{{ route('current-campaigns') }}"
                class="w-full bg-red-700 ring-red-700 hover:bg-red-800 text-white font-semibold px-4 py-2 rounded-full flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="h-5 w-5" fill="currentColor">
                    <path
                        d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                </svg>
                Reset filters
            </a>
        </div>
    </div>
</form>
