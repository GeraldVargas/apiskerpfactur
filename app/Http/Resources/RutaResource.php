<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RutaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_ruta' => $this->id_ruta,
            'id_funcionario' => $this->id_funcionario,
            'cod_ruta' => $this->cod_ruta,
            'desc_ruta' => $this->desc_ruta,
            'id_param' => $this->id_param,
            'sw_proceso' => $this->sw_proceso,
            'fecha_lectura' => $this->fecha_lectura,
            'fecha_vence' => $this->fecha_vence,
            'fecha_proxmed' => $this->fecha_proxmed,
            'fecha_proxemi' => $this->fecha_proxemi,
            'fecha_factura' => $this->fecha_factura,
            'fecha_anterior' => $this->fecha_anterior,
            'maximo_clientes' => $this->maximo_clientes,
            'sin_lectura' => $this->sin_lectura,
            'clientes' => $this->clientes,
            'id_municipio' => $this->id_municipio,
            'sw_debito_fiscal' => $this->sw_debito_fiscal,
            'zona_ruta' => $this->zona_ruta,
            'id_zona' => $this->id_zona,
            'id_usuario_reg' => $this->id_usuario_reg,
            'id_usuario_mod' => $this->id_usuario_mod,
            'fecha_reg' => $this->fecha_reg,
            'fecha_mod' => $this->fecha_mod,
            'estado_reg' => $this->estado_reg,
            'id_usuario_ai' => $this->id_usuario_ai,
            'usuario_ai' => $this->usuario_ai,
            'obs_dba' => $this->obs_dba,
        ];
    }
}
