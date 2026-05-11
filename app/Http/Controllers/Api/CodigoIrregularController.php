<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CodigoIrregular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CodigoIrregularController extends Controller
{
    private const SORTABLE_COLUMNS = [
        'id_cod_irre',
        'desc_cod_irre',
        'sw_aviso',
        'estado',
        'id_param',
        'codigo',
        'tipo_lectura',
        'id_cod_gescom',
    ];

    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $sortBy = (string) $request->input('sort_by', 'id_cod_irre');
        $sortDirection = strtolower((string) $request->input('sort_direction', 'desc'));

        if (! in_array($sortBy, self::SORTABLE_COLUMNS, true)) {
            $sortBy = 'id_cod_irre';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $query = CodigoIrregular::query()
            ->where(function ($q): void {
                $q->whereNull('estado_reg')
                    ->orWhere('estado_reg', '!=', 'inactivo');
            });

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('desc_cod_irre', 'ilike', "%{$search}%")
                    ->orWhere('codigo', 'ilike', "%{$search}%")
                    ->orWhere('descripcion', 'ilike', "%{$search}%");
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

        $item = DB::transaction(function () use ($data): CodigoIrregular {
            $data['estado_reg'] = $data['estado_reg'] ?? 'activo';

            return CodigoIrregular::create($data);
        });

        return response()->json(['data' => $item], 201);
    }

    public function show(int $id)
    {
        $item = CodigoIrregular::query()
            ->where('id_cod_irre', $id)
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

        $item = CodigoIrregular::query()
            ->where('id_cod_irre', $id)
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
        $item = CodigoIrregular::query()
            ->where('id_cod_irre', $id)
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

    private function updateRules(): array
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
