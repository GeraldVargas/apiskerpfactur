<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CodigoIrregularResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_cod_irre' => $this->id_cod_irre,
            'desc_cod_irre' => $this->desc_cod_irre,
            'sw_aviso' => $this->sw_aviso,
            'estado' => $this->estado,
            'id_param' => $this->id_param,
            'codigo' => $this->codigo,
            'tipo_lectura' => $this->tipo_lectura,
            'condicion_logica' => $this->condicion_logica,
            'id_cod_gescom' => $this->id_cod_gescom,
            'descripcion' => $this->descripcion,
            'estado_reg' => $this->estado_reg,
        ];
    }
}
