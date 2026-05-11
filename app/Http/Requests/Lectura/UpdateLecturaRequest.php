<?php

namespace App\Http\Requests\Lectura;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLecturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_cliente' => ['sometimes', 'required', 'integer'],
            'periodo_lec' => ['sometimes', 'required', 'numeric'],
            'gestion_lec' => ['sometimes', 'required', 'numeric'],
            'nro_cuenta' => ['sometimes', 'required', 'integer'],
            'fecha_anterior' => ['sometimes', 'required', 'date'],
            'fecha_actual' => ['sometimes', 'nullable', 'date'],
            'lectura_anterior' => ['sometimes', 'required', 'numeric'],
            'lectura_actual' => ['sometimes', 'required', 'numeric'],
            'lecant_kwh' => ['sometimes', 'required', 'numeric'],
            'lecant_kvar' => ['sometimes', 'required', 'numeric'],
            'lectura_kwh' => ['sometimes', 'required', 'numeric'],
            'lectura_kvar' => ['sometimes', 'required', 'numeric'],
            'lectura_kw' => ['sometimes', 'required', 'numeric'],
            'consumo_cambio' => ['sometimes', 'required', 'numeric'],
            'consumo_peri' => ['sometimes', 'required', 'numeric'],
            'consumo_val' => ['sometimes', 'required', 'numeric'],
            'consumo_dev' => ['sometimes', 'nullable', 'numeric'],
            'consumo_total' => ['sometimes', 'required', 'numeric'],
            'consumo_anterior' => ['sometimes', 'nullable', 'numeric'],
            'conexion_val' => ['sometimes', 'required', 'numeric'],
            'reconex_val' => ['sometimes', 'required', 'numeric'],
            'potencia_val' => ['sometimes', 'required', 'numeric'],
            'potencia_contratada' => ['sometimes', 'nullable', 'numeric'],
            'factor_potencia' => ['sometimes', 'nullable', 'numeric'],
            'importe_dev' => ['sometimes', 'required', 'numeric'],
            'saldo_imp_dev' => ['sometimes', 'required', 'numeric'],
            'importe_dev_ap' => ['sometimes', 'nullable', 'numeric'],
            'saldo_imp_dev_ap' => ['sometimes', 'nullable', 'numeric'],
            'importe_total' => ['sometimes', 'required', 'numeric'],
            'importe_interes' => ['sometimes', 'nullable', 'numeric'],
            'fecha_vence' => ['sometimes', 'nullable', 'date'],
            'fecha_proxmed' => ['sometimes', 'nullable', 'date'],
            'fecha_proxemi' => ['sometimes', 'nullable', 'date'],
            'promedio_val' => ['sometimes', 'nullable', 'numeric'],
            'ultima_lectura' => ['sometimes', 'nullable', 'numeric'],
            'cantidad_periodo' => ['sometimes', 'nullable', 'integer'],
            'saldo_credito' => ['sometimes', 'nullable', 'numeric'],
            'credito_pagado' => ['sometimes', 'nullable', 'numeric'],
            'tipo_lectura' => ['sometimes', 'nullable', 'numeric'],
            'periodo_corte' => ['sometimes', 'nullable', 'integer'],
            'nro_digitos' => ['sometimes', 'nullable', 'integer'],
            'nrodig_kwh' => ['sometimes', 'nullable', 'integer'],
            'nrodig_kvar' => ['sometimes', 'nullable', 'integer'],
            'multi_kwh' => ['sometimes', 'nullable', 'numeric'],
            'multi_kvar' => ['sometimes', 'nullable', 'numeric'],
            'multi_kw' => ['sometimes', 'nullable', 'numeric'],
            'id_categoria' => ['sometimes', 'required', 'integer', 'exists:factur.tcategoria1,id_categoria'],
            'cod_ubica' => ['sometimes', 'nullable', 'string', 'max:50'],
            'cambio_kvar' => ['sometimes', 'nullable', 'numeric'],
            'sw_potencia_maxima' => ['sometimes', 'nullable', 'string', 'max:20'],
            'id_lectura_fk' => ['sometimes', 'nullable', 'integer'],
            'sw_debito_fiscal' => ['sometimes', 'nullable', 'string', 'max:10'],
            'restitucion' => ['sometimes', 'nullable', 'numeric'],
            'desc_restitucion' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
