<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ruta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RutaController extends Controller
{
    private const SORTABLE_COLUMNS = [
        'id_ruta',
        'cod_ruta',
        'desc_ruta',
        'id_param',
        'fecha_lectura',
        'fecha_vence',
        'clientes',
    ];

    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $sortBy = (string) $request->input('sort_by', 'id_ruta');
        $sortDirection = strtolower((string) $request->input('sort_direction', 'desc'));

        if (! in_array($sortBy, self::SORTABLE_COLUMNS, true)) {
            $sortBy = 'id_ruta';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $query = Ruta::query()
            ->where(function ($q): void {
                $q->whereNull('estado_reg')
                    ->orWhere('estado_reg', '!=', 'inactivo');
            });

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('cod_ruta', 'ilike', "%{$search}%")
                    ->orWhere('desc_ruta', 'ilike', "%{$search}%");
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

        $item = DB::transaction(function () use ($data): Ruta {
            $data['estado_reg'] = $data['estado_reg'] ?? 'activo';

            return Ruta::create($data);
        });

        return response()->json(['data' => $item], 201);
    }

    public function show(int $id)
    {
        $item = Ruta::query()
            ->where('id_ruta', $id)
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

        $item = Ruta::query()
            ->where('id_ruta', $id)
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
        $item = Ruta::query()
            ->where('id_ruta', $id)
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

    private function updateRules(): array
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
