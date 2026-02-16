<div
    class="flex overflow-hidden w-full @if ($type == 1) mt-[-200px] @elseif($type == 2) mt-[-41px] @endif @if ($type == 1) rotate-[-4deg] @elseif($type == 2) rotate-[4deg] @endif  gap-6 py-5 @if ($type == 1) bg-[#27E36A] @elseif($type == 2) bg-[#1799EA] @endif">
    @for ($i = 0; $i < $length; $i++)
        @foreach ($keywords as $words)
            <p
                class="text-[28px] font-medium leading-[34px] tracking-[-0px] @if ($type == 1) text-[#101828] @elseif($type == 2) text-white @endif ">
                {{ $words }}</p>
            @if ($type == 1)
                <img src="{{ asset('web-assets/icons/love-black.svg') }}" alt="Love Icon">
            @elseif($type == 2)
                <img src="{{ asset('web-assets/icons/love-white.svg') }}" alt="Love Icon">
            @endif
        @endforeach
    @endfor
</div>
