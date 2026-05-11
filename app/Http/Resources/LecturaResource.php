<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LecturaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_lectura' => $this->id_lectura,
            'id_cliente' => $this->id_cliente,
            'periodo_lec' => $this->periodo_lec,
            'gestion_lec' => $this->gestion_lec,
            'nro_cuenta' => $this->nro_cuenta,
            'fecha_anterior' => $this->fecha_anterior,
            'fecha_actual' => $this->fecha_actual,
            'lectura_anterior' => $this->lectura_anterior,
            'lectura_actual' => $this->lectura_actual,
            'lecant_kwh' => $this->lecant_kwh,
            'lecant_kvar' => $this->lecant_kvar,
            'lectura_kwh' => $this->lectura_kwh,
            'lectura_kvar' => $this->lectura_kvar,
            'lectura_kw' => $this->lectura_kw,
            'consumo_cambio' => $this->consumo_cambio,
            'consumo_peri' => $this->consumo_peri,
            'consumo_val' => $this->consumo_val,
            'consumo_dev' => $this->consumo_dev,
            'consumo_total' => $this->consumo_total,
            'consumo_anterior' => $this->consumo_anterior,
            'conexion_val' => $this->conexion_val,
            'reconex_val' => $this->reconex_val,
            'potencia_val' => $this->potencia_val,
            'potencia_contratada' => $this->potencia_contratada,
            'factor_potencia' => $this->factor_potencia,
            'importe_dev' => $this->importe_dev,
            'saldo_imp_dev' => $this->saldo_imp_dev,
            'importe_dev_ap' => $this->importe_dev_ap,
            'saldo_imp_dev_ap' => $this->saldo_imp_dev_ap,
            'importe_total' => $this->importe_total,
            'importe_interes' => $this->importe_interes,
            'fecha_vence' => $this->fecha_vence,
            'fecha_proxmed' => $this->fecha_proxmed,
            'fecha_proxemi' => $this->fecha_proxemi,
            'promedio_val' => $this->promedio_val,
            'ultima_lectura' => $this->ultima_lectura,
            'cantidad_periodo' => $this->cantidad_periodo,
            'saldo_credito' => $this->saldo_credito,
            'credito_pagado' => $this->credito_pagado,
            'tipo_lectura' => $this->tipo_lectura,
            'periodo_corte' => $this->periodo_corte,
            'nro_digitos' => $this->nro_digitos,
            'nrodig_kwh' => $this->nrodig_kwh,
            'nrodig_kvar' => $this->nrodig_kvar,
            'multi_kwh' => $this->multi_kwh,
            'multi_kvar' => $this->multi_kvar,
            'multi_kw' => $this->multi_kw,
            'id_categoria' => $this->id_categoria,
            'cod_ubica' => $this->cod_ubica,
            'cambio_kvar' => $this->cambio_kvar,
            'sw_potencia_maxima' => $this->sw_potencia_maxima,
            'id_lectura_fk' => $this->id_lectura_fk,
            'sw_debito_fiscal' => $this->sw_debito_fiscal,
            'restitucion' => $this->restitucion,
            'desc_restitucion' => $this->desc_restitucion,
            'estado_reg' => $this->estado_reg,
        ];
    }
}
