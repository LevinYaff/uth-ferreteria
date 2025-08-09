@props(['title', 'value', 'icon', 'color' => 'blue', 'change' => null, 'isPositive' => true])

@php
$colors = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600',
    'red' => 'bg-red-100 text-red-600',
    'yellow' => 'bg-yellow-100 text-yellow-600',
    'purple' => 'bg-purple-100 text-purple-600',
    'indigo' => 'bg-indigo-100 text-indigo-600',
];

$textColor = $colors[$color];
$iconBg = str_replace('text-', 'bg-', $textColor);
$iconText = $textColor;
@endphp

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full {{ $iconBg }} {{ $iconText }} mr-4">
                {{ $icon }}
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $title }}</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $value }}</p>
                @if($change !== null)
                    <p class="text-sm {{ $isPositive ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        <span class="flex items-center">
                            @if($isPositive)
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                            {{ $change }}
                        </span>
                    </p>
                @endif
            </div>
        </div>
        @if($slot->isNotEmpty())
            <div class="mt-4">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
