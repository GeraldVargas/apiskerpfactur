<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'factur.tcategoria1';

    protected $primaryKey = 'id_categoria';

    public $timestamps = false;
}
