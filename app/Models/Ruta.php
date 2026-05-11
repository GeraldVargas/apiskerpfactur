<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ruta extends Model
{
    protected $table = 'factur.truta';

    protected $primaryKey = 'id_ruta';

    public $timestamps = false;

    protected $fillable = [
        'id_funcionario',
        'cod_ruta',
        'desc_ruta',
        'id_param',
        'sw_proceso',
        'fecha_lectura',
        'fecha_vence',
        'fecha_proxmed',
        'fecha_proxemi',
        'fecha_factura',
        'fecha_anterior',
        'maximo_clientes',
        'sin_lectura',
        'clientes',
        'id_municipio',
        'sw_debito_fiscal',
        'zona_ruta',
        'id_zona',
        'id_usuario_reg',
        'id_usuario_mod',
        'fecha_reg',
        'fecha_mod',
        'estado_reg',
        'id_usuario_ai',
        'usuario_ai',
        'obs_dba',
    ];

    protected $casts = [
        'fecha_lectura' => 'date',
        'fecha_vence' => 'date',
        'fecha_proxmed' => 'date',
        'fecha_proxemi' => 'date',
        'fecha_factura' => 'date',
        'fecha_anterior' => 'date',
        'fecha_reg' => 'datetime',
        'fecha_mod' => 'datetime',
    ];

    public function parametro(): BelongsTo
    {
        return $this->belongsTo(Parametro::class, 'id_param', 'id_param');
    }
}
