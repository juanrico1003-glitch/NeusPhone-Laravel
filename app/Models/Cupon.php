<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    protected $table = 'cupones';

    protected $fillable = [
        'codigo', 'nombre', 'tipo', 'valor', 'minimo_compra',
        'usos_maximos', 'usos_actuales', 'fecha_inicio', 'fecha_fin', 'activo'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function esValido()
    {
        if (!$this->activo) return false;
        if ($this->usos_maximos && $this->usos_actuales >= $this->usos_maximos) return false;
        if ($this->fecha_inicio && now()->lt($this->fecha_inicio)) return false;
        if ($this->fecha_fin && now()->gt($this->fecha_fin)) return false;
        return true;
    }

    public function aplicarDescuento($subtotal)
    {
        if ($this->minimo_compra && $subtotal < $this->minimo_compra) {
            return $subtotal;
        }
        if ($this->tipo === 'porcentaje') {
            return round($subtotal * (1 - $this->valor / 100), 2);
        }
        return max(0, $subtotal - $this->valor);
    }
}
