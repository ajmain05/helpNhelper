<div class="flex items-center justify-center">
    @for ($i = 0; $i < $step; $i++)
        <div class="flex items-center">
            <div id="step1"
                class="w-6 xl:w-10 text-[10px] xl:text-[16px] h-6 xl:h-10 flex items-center justify-center rounded-full border-2 @if($i < $position-1) border-[#1799EA] bg-[#1799EA] text-white @elseif ($i < $position) border-white text-white @else border-gray-500 text-gray-500 bg-transparent @endif font-semibold cursor-pointer">
                {{ $i + 1 }}
            </div>
            @unless ($i == $step - 1)
                <div class="h-[2px] w-[10px] xl:w-20 @if ($i < $position - 1) bg-white @else bg-gray-500 @endif">
                </div>
            @endunless
        </div>
    @endfor
</div>
