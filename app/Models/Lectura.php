<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lectura extends Model
{
    protected $table = 'factur.tlectura1';

    protected $primaryKey = 'id_lectura';

    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'periodo_lec',
        'gestion_lec',
        'nro_cuenta',
        'fecha_anterior',
        'fecha_actual',
        'lectura_anterior',
        'lectura_actual',
        'lecant_kwh',
        'lecant_kvar',
        'lectura_kwh',
        'lectura_kvar',
        'lectura_kw',
        'consumo_cambio',
        'consumo_peri',
        'consumo_val',
        'consumo_dev',
        'consumo_total',
        'consumo_anterior',
        'conexion_val',
        'reconex_val',
        'potencia_val',
        'potencia_contratada',
        'factor_potencia',
        'importe_dev',
        'saldo_imp_dev',
        'importe_dev_ap',
        'saldo_imp_dev_ap',
        'importe_total',
        'importe_interes',
        'fecha_vence',
        'fecha_proxmed',
        'fecha_proxemi',
        'promedio_val',
        'ultima_lectura',
        'cantidad_periodo',
        'saldo_credito',
        'credito_pagado',
        'tipo_lectura',
        'periodo_corte',
        'nro_digitos',
        'nrodig_kwh',
        'nrodig_kvar',
        'multi_kwh',
        'multi_kvar',
        'multi_kw',
        'id_categoria',
        'cod_ubica',
        'cambio_kvar',
        'sw_potencia_maxima',
        'id_lectura_fk',
        'sw_debito_fiscal',
        'restitucion',
        'desc_restitucion',
        'estado_reg',
    ];

    protected $casts = [
        'fecha_anterior' => 'date',
        'fecha_actual' => 'date',
        'fecha_vence' => 'date',
        'fecha_proxmed' => 'date',
        'fecha_proxemi' => 'date',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}
