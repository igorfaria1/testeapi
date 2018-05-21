<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $fillable = ['bairro', 'cidade', 'logradouro', 'cep', 'estado'];
    
    protected $dates = ['deleted_at'];

    protected $table = 'locais';
}
