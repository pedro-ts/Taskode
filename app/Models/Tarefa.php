<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    //
    protected $table = 'tarefas';
    public $timestamps = false;

    // Campos permitidos para atribuição em massa
    protected $fillable = [
        'nome',
        'descricao',
        'prioridade',
        'pontos',
        'criada',
        'concluir',
        'status',
        'id_projeto'
    ];

    // Converte datas para objetos Date ao ler; formata ao salvar
    protected $casts = [
        'criada'   => 'date',                  // DATE ↔ Carbon (data)
        'concluir' => 'date'
        // prioridade/status são ENUM no banco; o PHP verá como string ('1','2','3')
    ];

    // Relação N:1 (cada tarefa pertence a um projeto)
    public function projeto()
    {
        // belongsTo liga a FK local 'id_projeto' à PK 'id' da tabela projetos
        return $this->belongsTo(Projeto::class, 'id_projeto');
    }
}
