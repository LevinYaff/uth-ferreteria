@props(['role'])

@php
$colors = [
    'admin' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
    'vendedor' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
    'inventario' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'compras' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
    'supervisor' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
    'default' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
];

$roleNames = [
    'admin' => 'Administrador',
    'vendedor' => 'Vendedor',
    'inventario' => 'Encargado de Inventario',
    'compras' => 'Encargado de Compras',
    'supervisor' => 'Supervisor',
    'default' => 'Cliente',
];

$colorClass = $colors[$role] ?? $colors['default'];
$roleName = $roleNames[$role] ?? $roleNames['default'];
@endphp

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
    {{ $roleName }}
</span>
