<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagosEfectuados extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'identificacion',
        'cliente',
        'correo',
        'telefono',
        'boton_pago_id',
        'referencia',
        'fecha_pago',
        'curso_id',
        'curso_nombre',
        'valor',
        'descripcion',
        'estado',
        'respuesta_proveedor',
        'tipo_pago',
        'registrado_moodle',
        'moodle_user_id',
        'fecha_registro_moodle',
        'datos_moodle',
        'direccion',
        'ciudad'
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'valor' => 'decimal:2',
        'respuesta_proveedor' => 'array',
        'datos_moodle' => 'array',
        'registrado_moodle' => 'boolean',
        'fecha_registro_moodle' => 'datetime'
    ];

    public function botonPago()
    {
        return $this->belongsTo(BotonPago::class);
    }
}
