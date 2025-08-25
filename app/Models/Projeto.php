<?php

namespace App\Models; // define em qual "caixinha" (namespace) esse arquivo vive

use Illuminate\Database\Eloquent\Model; // importa a classe Model do Laravel

class Projeto extends Model // cria uma classe chamada Usuario que HERDA Model
{
    //
    protected $table = 'projetos';            // nome da tabela no MySQL
    public $timestamps = false;               // não usa created_at/updated_at

    // Quais colunas podem ser preenchidas em massa (mass assignment)
    protected $fillable = ['nome', 'descricao', 'linguagens', 'publico', 'id_user'];

    // Converte tipos automaticamente ao ler/escrever
    protected $casts = [
        'linguagens' => 'array',              // JSON ↔ array PHP
        'publico'    => 'integer'             // TINYINT ↔ int PHP
    ];

    // Relação N:1 (cada projeto pertence a um usuário)
    public function dono()
    {
        // belongsTo(ClasseDoPai, chave_estrangeira_na_tabela_atual)
        return $this->belongsTo(Usuario::class, 'id_user');
    }

    // Relação 1:N (um projeto tem muitas tarefas)
    public function tarefas()
    {
        // hasMany(ClasseFilha, chave_estrangeira_na_filha)
        return $this->hasMany(Tarefa::class, 'id_projeto');
    }
}
