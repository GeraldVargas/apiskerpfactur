<?php

namespace App\Http\Requests\Ruta;

use Illuminate\Foundation\Http\FormRequest;

class StoreRutaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_funcionario' => ['nullable', 'integer'],
            'cod_ruta' => ['required', 'string', 'max:50'],
            'desc_ruta' => ['required', 'string', 'max:255'],
            'id_param' => ['nullable', 'integer', 'exists:factur.tparametro1,id_param'],
            'sw_proceso' => ['required', 'string', 'max:10'],
            'fecha_lectura' => ['nullable', 'date'],
            'fecha_vence' => ['nullable', 'date'],
            'fecha_proxmed' => ['nullable', 'date'],
            'fecha_proxemi' => ['nullable', 'date'],
            'fecha_factura' => ['nullable', 'date'],
            'fecha_anterior' => ['nullable', 'date'],
            'maximo_clientes' => ['nullable', 'integer'],
            'sin_lectura' => ['nullable', 'integer'],
            'clientes' => ['nullable', 'integer'],
            'id_municipio' => ['nullable', 'integer'],
            'sw_debito_fiscal' => ['required', 'string', 'max:10'],
            'zona_ruta' => ['nullable', 'numeric'],
            'id_zona' => ['nullable', 'integer'],
            'id_usuario_reg' => ['nullable', 'integer'],
            'id_usuario_mod' => ['nullable', 'integer'],
            'fecha_reg' => ['nullable', 'date'],
            'fecha_mod' => ['nullable', 'date'],
            'id_usuario_ai' => ['nullable', 'integer'],
            'usuario_ai' => ['nullable', 'string', 'max:50'],
            'obs_dba' => ['nullable', 'string'],
        ];
    }
}
