<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Cliente extends Model
{
    protected $table = 'factur.tcliente';

    protected $primaryKey = 'id_cliente';

    public $timestamps = false;

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable($this->resolveFillableColumns());
    }

    private function resolveFillableColumns(): array
    {
        static $cache = [];
        $cacheKey = $this->table;

        if (isset($cache[$cacheKey])) {
            return $cache[$cacheKey];
        }

        [$schema, $table] = str_contains($this->table, '.')
            ? explode('.', $this->table, 2)
            : [null, $this->table];

        if (DB::connection()->getDriverName() === 'pgsql' && $schema !== null) {
            $columns = collect(DB::select(
                'SELECT column_name 
                 FROM information_schema.columns
                 WHERE table_schema = ? AND table_name = ?
                 ORDER BY ordinal_position',
                [$schema, $table]
            ))->pluck('column_name')->all();

            if ($columns !== []) {
                return $cache[$cacheKey] = array_values(array_filter(
                    $columns,
                    fn (string $column): bool => $column !== $this->primaryKey
                ));
            }
        }

        $listingTable = $schema !== null ? $table : $this->table;

        if (Schema::hasTable($listingTable)) {
            return $cache[$cacheKey] = array_values(array_filter(
                Schema::getColumnListing($listingTable),
                fn (string $column): bool => $column !== $this->primaryKey
            ));
        }

        return $cache[$cacheKey] = [];
    }
}
