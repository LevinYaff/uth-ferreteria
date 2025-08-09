<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Venta;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_VENDEDOR = 'vendedor';
    const ROLE_INVENTARIO = 'inventario';
    const ROLE_COMPRAS = 'compras';
    const ROLE_SUPERVISOR = 'supervisor';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'theme_preference',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verifica si el usuario es administrador
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Verifica si el usuario es vendedor
     */
    public function isVendedor(): bool
    {
        return $this->role === self::ROLE_VENDEDOR;
    }

    /**
     * Verifica si el usuario es encargado de inventario
     */
    public function isInventario(): bool
    {
        return $this->role === self::ROLE_INVENTARIO;
    }

    /**
     * Verifica si el usuario es encargado de compras
     */
    public function isCompras(): bool
    {
        return $this->role === self::ROLE_COMPRAS;
    }

    /**
     * Verifica si el usuario es supervisor
     */
    public function isSupervisor(): bool
    {
        return $this->role === self::ROLE_SUPERVISOR;
    }

    /**
     * Get the ventas for the user.
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'user_id');
    }
}
