@props(['recibido', 'ordenado', 'estado' => null])

@php
// Determinar el estado si no se proporciona directamente
if ($estado === null) {
    if ($recibido === 0) {
        $estado = 'pendiente';
    } elseif ($recibido < $ordenado) {
        $estado = 'parcial';
    } else {
        $estado = 'completo';
    }
}

$colors = [
    'pendiente' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
    'parcial' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
    'completo' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
];

$estados = [
    'pendiente' => 'Pendiente',
    'parcial' => 'Parcial',
    'completo' => 'Completo',
];

$colorClass = $colors[$estado] ?? $colors['pendiente'];
$estadoText = $estados[$estado] ?? $estados['pendiente'];
@endphp

<span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
    {{ $estadoText }}
</span>
