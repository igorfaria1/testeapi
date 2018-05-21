<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = ['tipo', 'titulo', 'descricao', 'data', 'local_id'];

    protected $dates = ['deleted_at'];

    protected $table = 'eventos';

    function local() {
        return $this->belongsTo(Local::class);
    }
}
