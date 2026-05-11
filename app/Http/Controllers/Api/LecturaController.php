<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lectura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturaController extends Controller
{
    private const SORTABLE_COLUMNS = [
        'id_lectura',
        'id_cliente',
        'nro_cuenta',
        'periodo_lec',
        'gestion_lec',
        'fecha_anterior',
        'fecha_actual',
        'importe_total',
    ];

    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $sortBy = (string) $request->input('sort_by', 'id_lectura');
        $sortDirection = strtolower((string) $request->input('sort_direction', 'desc'));

        if (! in_array($sortBy, self::SORTABLE_COLUMNS, true)) {
            $sortBy = 'id_lectura';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $query = Lectura::query()
            ->where(function ($q): void {
                $q->whereNull('estado_reg')
                    ->orWhere('estado_reg', '!=', 'inactivo');
            });

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('cod_ubica', 'ilike', "%{$search}%")
                    ->orWhere('desc_restitucion', 'ilike', "%{$search}%");

                if (is_numeric($search)) {
                    $q->orWhere('nro_cuenta', (int) $search)
                        ->orWhere('id_cliente', (int) $search);
                }
            });
        }

        $items = $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate(15)
            ->withQueryString();

        return response()->json(['data' => $items]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->storeRules());

        $item = DB::transaction(function () use ($data): Lectura {
            $data['estado_reg'] = $data['estado_reg'] ?? 'activo';

            return Lectura::create($data);
        });

        return response()->json(['data' => $item], 201);
    }

    public function show(int $id)
    {
        $item = Lectura::query()
            ->where('id_lectura', $id)
            ->where(function ($q): void {
                $q->whereNull('estado_reg')
                    ->orWhere('estado_reg', '!=', 'inactivo');
            })
            ->firstOrFail();

        return response()->json(['data' => $item]);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate($this->updateRules());

        $item = Lectura::query()
            ->where('id_lectura', $id)
            ->where(function ($q): void {
                $q->whereNull('estado_reg')
                    ->orWhere('estado_reg', '!=', 'inactivo');
            })
            ->firstOrFail();

        DB::transaction(function () use ($item, $data): void {
            $item->fill($data);
            $item->save();
        });

        return response()->json(['data' => $item->fresh()]);
    }

    public function destroy(int $id)
    {
        $item = Lectura::query()
            ->where('id_lectura', $id)
            ->where(function ($q): void {
                $q->whereNull('estado_reg')
                    ->orWhere('estado_reg', '!=', 'inactivo');
            })
            ->firstOrFail();

        $item->estado_reg = 'inactivo';
        $item->save();

        return response()->json(['message' => 'Registro inactivado correctamente.']);
    }

    private function storeRules(): array
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

    private function updateRules(): array
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
