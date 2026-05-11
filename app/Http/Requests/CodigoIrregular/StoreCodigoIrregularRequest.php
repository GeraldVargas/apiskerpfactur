<?php

namespace App\Http\Requests\CodigoIrregular;

use Illuminate\Foundation\Http\FormRequest;

class StoreCodigoIrregularRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'desc_cod_irre' => ['required', 'string', 'max:255'],
            'sw_aviso' => ['required', 'string', 'max:10'],
            'estado' => ['required', 'numeric'],
            'id_param' => ['required', 'integer', 'exists:factur.tparametro1,id_param'],
            'codigo' => ['nullable', 'string', 'max:50'],
            'tipo_lectura' => ['required', 'numeric'],
            'condicion_logica' => ['nullable', 'string'],
            'id_cod_gescom' => ['nullable', 'integer', 'exists:factur.tcod_gescom1,id_cod_gescom'],
            'descripcion' => ['nullable', 'string'],
        ];
    }
}
