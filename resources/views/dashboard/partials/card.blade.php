<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $title }}</p>
                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $value }}</p>
            </div>
            <div class="p-3 {{ $iconColor }} rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}" />
                </svg>
            </div>
        </div>
        @if($subtitle ?? false)
            <div class="mt-4">
                <span class="{{ $subtitleColor ?? 'text-gray-500' }} text-sm font-semibold">{{ $subtitle }}</span>
            </div>
        @endif
    </div>
</div>