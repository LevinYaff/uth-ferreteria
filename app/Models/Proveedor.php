<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'contacto',
        'telefono',
        'email',
        'direccion',
        'activo'
    ];

    // Relación con productos
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'producto_proveedor')
                    ->withPivot('precio_compra', 'codigo_proveedor', 'es_proveedor_principal')
                    ->withTimestamps();
    }

    // Relación con compras
    public function compras(): HasMany
    {
        return $this->hasMany(Compra::class);
    }
}
