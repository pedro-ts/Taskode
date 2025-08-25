<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    //
    protected $table = 'usuarios';
    public $timestamps = false;
    protected $fillable = ['nome', 'email', 'senha', 'foto', 'pontos'];
    protected $hidden = ['senha'];
    
    public function projetos()
    {
        return $this->hasMany(Projeto::class, 'id_user');
    }
}
