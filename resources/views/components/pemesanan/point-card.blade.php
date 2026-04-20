@php
    $points = auth()->check() ? auth()->user()->points : 0;
    $badge = auth()->check() ? auth()->user()->badge : 'Bronze';
    $progress = min(($points / 1000) * 100, 100);
@endphp

<div
    class="bg-white dark:bg-dark-card rounded-3xl p-6 shadow-sm w-full max-w-sm flex items-center justify-between border border-gray-100 dark:border-dark-border transition-colors duration-300">
    <div class="flex-grow">
        <h3 class="text-gray-800 dark:text-white font-bold mb-1">Voyago Point kamu:</h3>
        <div class="flex items-baseline gap-1 mb-2">
            <span class="text-3xl font-black text-gray-800 dark:text-white">{{ $points }}</span>
            <span class="text-gray-400 text-sm font-bold">/1000</span>
        </div>
        <div class="w-full bg-gray-100 dark:bg-dark-border h-2 rounded-full overflow-hidden mb-2 relative">
            <div class="bg-orange-400 h-full rounded-full transition-all duration-500" style="width: {{ $progress }}%">
            </div>
        </div>
        <p class="text-gray-400 text-[10px] font-bold italic">{{ $badge }} Member</p>
    </div>
    <div class="ml-4">
        <div class="w-16 h-16 bg-orange-100 dark:bg-[#121212] rounded-full flex items-center justify-center relative shadow-inner transition-colors duration-300">
            <i class="fas fa-trophy text-orange-400 text-3xl"></i>
            <div class="absolute inset-0 bg-orange-400 opacity-20 rounded-full animate-pulse"></div>
        </div>
    </div>
</div>