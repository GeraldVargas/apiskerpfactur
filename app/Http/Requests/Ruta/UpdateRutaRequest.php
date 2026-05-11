<?php

namespace App\Http\Requests\Ruta;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRutaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_funcionario' => ['sometimes', 'nullable', 'integer'],
            'cod_ruta' => ['sometimes', 'required', 'string', 'max:50'],
            'desc_ruta' => ['sometimes', 'required', 'string', 'max:255'],
            'id_param' => ['sometimes', 'nullable', 'integer', 'exists:factur.tparametro1,id_param'],
            'sw_proceso' => ['sometimes', 'required', 'string', 'max:10'],
            'fecha_lectura' => ['sometimes', 'nullable', 'date'],
            'fecha_vence' => ['sometimes', 'nullable', 'date'],
            'fecha_proxmed' => ['sometimes', 'nullable', 'date'],
            'fecha_proxemi' => ['sometimes', 'nullable', 'date'],
            'fecha_factura' => ['sometimes', 'nullable', 'date'],
            'fecha_anterior' => ['sometimes', 'nullable', 'date'],
            'maximo_clientes' => ['sometimes', 'nullable', 'integer'],
            'sin_lectura' => ['sometimes', 'nullable', 'integer'],
            'clientes' => ['sometimes', 'nullable', 'integer'],
            'id_municipio' => ['sometimes', 'nullable', 'integer'],
            'sw_debito_fiscal' => ['sometimes', 'required', 'string', 'max:10'],
            'zona_ruta' => ['sometimes', 'nullable', 'numeric'],
            'id_zona' => ['sometimes', 'nullable', 'integer'],
            'id_usuario_reg' => ['sometimes', 'nullable', 'integer'],
            'id_usuario_mod' => ['sometimes', 'nullable', 'integer'],
            'fecha_reg' => ['sometimes', 'nullable', 'date'],
            'fecha_mod' => ['sometimes', 'nullable', 'date'],
            'id_usuario_ai' => ['sometimes', 'nullable', 'integer'],
            'usuario_ai' => ['sometimes', 'nullable', 'string', 'max:50'],
            'obs_dba' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
