<div class="custom-container py-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
        <!-- Meet Our Team Section -->
        <div class="flex flex-col">
            <div class="relative flex justify-center mt-8 mb-8 md:mt-12 md:mb-10">
                <div class="inline-block px-8 py-3 bg-white/5 backdrop-blur-md border border-white/10 rounded-full shadow-lg relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                    <h3 class="text-2xl md:text-3xl font-bold text-white tracking-wide uppercase relative z-10">
                        {{ __('Meet Our Team') }}
                    </h3>
                </div>
            </div>
            
            @if(isset($teams) && count($teams) > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($teams as $teamMember)
                        <x-team-card :teamMember="$teamMember" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 text-white bg-gray-800 rounded-xl">
                    {{ __('No team members found') }}
                </div>
            @endif
        </div>

        <!-- Shariah Advisory Board Section -->
        <div class="flex flex-col">
            <div class="relative flex justify-center mt-8 mb-8 md:mt-12 md:mb-10">
                <div class="inline-block px-8 py-3 bg-white/5 backdrop-blur-md border border-white/10 rounded-full shadow-lg relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                    <h3 class="text-2xl md:text-3xl font-bold text-white tracking-wide uppercase relative z-10">
                        {{ __('Shariah Advisory Board') }}
                    </h3>
                </div>
            </div>

            @if(isset($shariah) && count($shariah) > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($shariah as $member)
                        <x-team-card :teamMember="$member" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 text-white bg-gray-800 rounded-xl">
                    {{ __('No board members found') }}
                </div>
            @endif
        </div>
    </div>
</div>

<x-slot name="styles">
    <!-- Removed Swiper CSS -->
</x-slot>
<x-slot name="scripts">
    <!-- Removed Swiper JS -->
</x-slot>
