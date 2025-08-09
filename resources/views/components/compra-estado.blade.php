@props(['estado'])

@php
$colors = [
    'pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'recibida' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'parcial' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
    'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
];

$estados = [
    'pendiente' => 'Pendiente',
    'recibida' => 'Recibida',
    'parcial' => 'Recibida Parcialmente',
    'cancelada' => 'Cancelada',
];

$colorClass = $colors[$estado] ?? $colors['pendiente'];
$estadoText = $estados[$estado] ?? $estados['pendiente'];
@endphp

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
    {{ $estadoText }}
</span>
