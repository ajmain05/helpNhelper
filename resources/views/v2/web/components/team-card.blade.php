<div class="group relative overflow-hidden bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 transition-all duration-300 hover:bg-white/20 hover:scale-[1.02] hover:shadow-xl">
    <div class="relative aspect-square overflow-hidden rounded-xl mb-4">
        <img src="{{ asset($teamMember['image']) }}" alt="{{ $teamMember['name'] }}" 
             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
    </div>
    <div class="text-center">
        <h4 class="text-lg font-bold text-white mb-1">{{ $teamMember['name'] }}</h4>
        <h5 class="text-sm font-medium text-green-400 mb-1">{{ $teamMember['designation'] }}</h5>
        <p class="text-xs text-gray-300">{{ $teamMember['institution'] }}</p>
    </div>
</div>
