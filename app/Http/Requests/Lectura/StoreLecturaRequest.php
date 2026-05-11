<?php

namespace App\Http\Requests\Lectura;

use Illuminate\Foundation\Http\FormRequest;

class StoreLecturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_cliente' => ['required', 'integer'],
            'periodo_lec' => ['required', 'numeric'],
            'gestion_lec' => ['required', 'numeric'],
            'nro_cuenta' => ['required', 'integer'],
            'fecha_anterior' => ['required', 'date'],
            'fecha_actual' => ['nullable', 'date'],
            'lectura_anterior' => ['required', 'numeric'],
            'lectura_actual' => ['required', 'numeric'],
            'lecant_kwh' => ['required', 'numeric'],
            'lecant_kvar' => ['required', 'numeric'],
            'lectura_kwh' => ['required', 'numeric'],
            'lectura_kvar' => ['required', 'numeric'],
            'lectura_kw' => ['required', 'numeric'],
            'consumo_cambio' => ['required', 'numeric'],
            'consumo_peri' => ['required', 'numeric'],
            'consumo_val' => ['required', 'numeric'],
            'consumo_dev' => ['nullable', 'numeric'],
            'consumo_total' => ['required', 'numeric'],
            'consumo_anterior' => ['nullable', 'numeric'],
            'conexion_val' => ['required', 'numeric'],
            'reconex_val' => ['required', 'numeric'],
            'potencia_val' => ['required', 'numeric'],
            'potencia_contratada' => ['nullable', 'numeric'],
            'factor_potencia' => ['nullable', 'numeric'],
            'importe_dev' => ['required', 'numeric'],
            'saldo_imp_dev' => ['required', 'numeric'],
            'importe_dev_ap' => ['nullable', 'numeric'],
            'saldo_imp_dev_ap' => ['nullable', 'numeric'],
            'importe_total' => ['required', 'numeric'],
            'importe_interes' => ['nullable', 'numeric'],
            'fecha_vence' => ['nullable', 'date'],
            'fecha_proxmed' => ['nullable', 'date'],
            'fecha_proxemi' => ['nullable', 'date'],
            'promedio_val' => ['nullable', 'numeric'],
            'ultima_lectura' => ['nullable', 'numeric'],
            'cantidad_periodo' => ['nullable', 'integer'],
            'saldo_credito' => ['nullable', 'numeric'],
            'credito_pagado' => ['nullable', 'numeric'],
            'tipo_lectura' => ['nullable', 'numeric'],
            'periodo_corte' => ['nullable', 'integer'],
            'nro_digitos' => ['nullable', 'integer'],
            'nrodig_kwh' => ['nullable', 'integer'],
            'nrodig_kvar' => ['nullable', 'integer'],
            'multi_kwh' => ['nullable', 'numeric'],
            'multi_kvar' => ['nullable', 'numeric'],
            'multi_kw' => ['nullable', 'numeric'],
            'id_categoria' => ['required', 'integer', 'exists:factur.tcategoria1,id_categoria'],
            'cod_ubica' => ['nullable', 'string', 'max:50'],
            'cambio_kvar' => ['nullable', 'numeric'],
            'sw_potencia_maxima' => ['nullable', 'string', 'max:20'],
            'id_lectura_fk' => ['nullable', 'integer'],
            'sw_debito_fiscal' => ['nullable', 'string', 'max:10'],
            'restitucion' => ['nullable', 'numeric'],
            'desc_restitucion' => ['nullable', 'string', 'max:255'],
        ];
    }
}
