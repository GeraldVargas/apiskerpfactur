<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodigoIrregular extends Model
{
    protected $table = 'factur.tcodigo_irregular1';

    protected $primaryKey = 'id_cod_irre';

    public $timestamps = false;

    protected $fillable = [
        'desc_cod_irre',
        'sw_aviso',
        'estado',
        'id_param',
        'codigo',
        'tipo_lectura',
        'condicion_logica',
        'id_cod_gescom',
        'descripcion',
    ];

    public function parametro(): BelongsTo
    {
        return $this->belongsTo(Parametro::class, 'id_param', 'id_param');
    }

    public function codigoGescom(): BelongsTo
    {
        return $this->belongsTo(CodGescom::class, 'id_cod_gescom', 'id_cod_gescom');
    }
}
