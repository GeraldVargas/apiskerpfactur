<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    private const SORTABLE_COLUMNS = [
        'id_cliente',
        'nombre',
        'nro_cuenta',
    ];

    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $sortBy = (string) $request->input('sort_by', 'id_cliente');
        $sortDirection = strtolower((string) $request->input('sort_direction', 'desc'));

        if (! in_array($sortBy, self::SORTABLE_COLUMNS, true)) {
            $sortBy = 'id_cliente';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $query = Cliente::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('nombre', 'ilike', "%{$search}%")
                    ->orWhereRaw('CAST(nro_cuenta AS TEXT) ILIKE ?', ["%{$search}%"]);
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

        $item = DB::transaction(function () use ($data): Cliente {
            return Cliente::create($data);
        });

        return response()->json(['data' => $item], 201);
    }

    public function show(int $id)
    {
        $item = Cliente::query()->findOrFail($id);

        return response()->json(['data' => $item]);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate($this->updateRules());
        $item = Cliente::query()->findOrFail($id);

        DB::transaction(function () use ($item, $data): void {
            $item->fill($data);
            $item->save();
        });

        return response()->json(['data' => $item->fresh()]);
    }

    public function destroy(int $id)
    {
        $item = Cliente::query()->findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Registro eliminado correctamente.']);
    }

    private function storeRules(): array
    {
        $rules = [
            'nombre' => ['required', 'string', 'max:255'],
            'nro_cuenta' => ['required', 'integer'],
        ];

        foreach ((new Cliente())->getFillable() as $column) {
            if (! array_key_exists($column, $rules)) {
                $rules[$column] = ['nullable'];
            }
        }

        return $rules;
    }

    private function updateRules(): array
    {
        $rules = [
            'nombre' => ['sometimes', 'required', 'string', 'max:255'],
            'nro_cuenta' => ['sometimes', 'required', 'integer'],
        ];

        foreach ((new Cliente())->getFillable() as $column) {
            if (! array_key_exists($column, $rules)) {
                $rules[$column] = ['sometimes', 'nullable'];
            }
        }

        return $rules;
    }
}
