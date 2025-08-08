<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'documento',
        'tipo_documento',
        'telefono',
        'email',
        'direccion',
        'ciudad',
        'estado',
        'codigo_postal',
        'latitud',
        'longitud',
        'fecha_nacimiento',
        'notas',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'latitud' => 'float',
        'longitud' => 'float',
        'activo' => 'boolean',
    ];

    // Relación con ventas
    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class);
    }

    // Nombre completo del cliente
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    // Obtener productos más comprados
    public function productosMasComprados($limit = 5)
    {
        return Producto::select(
                'productos.id',
                'productos.nombre',
                'productos.descripcion',
                'productos.codigo',
                'productos.precio_venta',
                'productos.stock',
                'productos.imagen',
                'productos.activo',
                'productos.categoria_id',
                'productos.created_at',
                'productos.updated_at',
                DB::raw('SUM(detalle_ventas.cantidad) as total_comprado')
            )
            ->join('detalle_ventas', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->where('ventas.cliente_id', $this->id)
            ->where('ventas.estado', 'completada')
            ->groupBy(
                'productos.id',
                'productos.nombre',
                'productos.descripcion',
                'productos.codigo',
                'productos.precio_venta',
                'productos.stock',
                'productos.imagen',
                'productos.activo',
                'productos.categoria_id',
                'productos.created_at',
                'productos.updated_at'
            )
            ->orderBy('total_comprado', 'desc')
            ->limit($limit)
            ->get();
    }

    // Total gastado por el cliente
    public function getTotalGastadoAttribute()
    {
        return $this->ventas()
            ->where('estado', 'completada')
            ->sum('total');
    }
}
