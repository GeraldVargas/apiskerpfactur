<?php

namespace App\Http\Requests\CodigoIrregular;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCodigoIrregularRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'desc_cod_irre' => ['sometimes', 'required', 'string', 'max:255'],
            'sw_aviso' => ['sometimes', 'required', 'string', 'max:10'],
            'estado' => ['sometimes', 'required', 'numeric'],
            'id_param' => ['sometimes', 'required', 'integer', 'exists:factur.tparametro1,id_param'],
            'codigo' => ['nullable', 'string', 'max:50'],
            'tipo_lectura' => ['sometimes', 'required', 'numeric'],
            'condicion_logica' => ['nullable', 'string'],
            'id_cod_gescom' => ['nullable', 'integer', 'exists:factur.tcod_gescom1,id_cod_gescom'],
            'descripcion' => ['nullable', 'string'],
        ];
    }
}
