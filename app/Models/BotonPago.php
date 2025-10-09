<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BotonPago extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre_proveedor',
        'boton_pago_detalle',
        'usuario_boton_pago',
        'clave_boton_pago',
        'url_boton_pago',
        'token_boton_pago',
        'key_boton_pago',
        'esta_activo',
        'configuracion_adicional'
    ];

    protected $casts = [
        'esta_activo' => 'boolean',
        'configuracion_adicional' => 'array'
    ];

    public function pagos()
    {
        return $this->hasMany(PagosEfectuados::class);
    }
}