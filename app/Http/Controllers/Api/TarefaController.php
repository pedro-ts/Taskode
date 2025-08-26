<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarefa;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tarefa::query()->orderBy('id')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'       => 'required|string|max:100',
            'descricao'  => 'nullable|string',
            // no seu banco ENUM('3','2','1'), aqui validamos como strings '1','2','3'
            'prioridade' => 'required|in:1,2,3',
            'pontos'     => 'required|integer|min:0',
            'criada'     => 'required|date',      // formato ISO: YYYY-MM-DD
            'concluir'   => 'required|date|after_or_equal:criada',
            // status ENUM('0','1','2','3') → validamos como strings '0'..'3'
            'status'     => 'required|in:0,1,2,3',
            'id_projeto' => 'required|integer|exists:projetos,id',
        ]);

        $tarefa = Tarefa::create($data);
        return response()->json($tarefa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Tarefa::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tarefa = Tarefa::findOrFail($id);

        $data = $request->validate([
            'nome'       => 'sometimes|string|max:100',
            'descricao'  => 'nullable|string',
            'prioridade' => 'sometimes|in:1,2,3',
            'pontos'     => 'sometimes|integer|min:0',
            'criada'     => 'sometimes|date',
            'concluir'   => 'sometimes|date|after_or_equal:criada',
            'status'     => 'sometimes|in:0,1,2,3',
            'id_projeto' => 'sometimes|integer|exists:projetos,id',
        ]);

        $tarefa->update($data);
        return $tarefa;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();
        return response()->noContent(); // 204
    }
    
    // Minhas API's
    public function byProjeto(string $projetoId)
    {
        return Tarefa::where('id_projeto', $projetoId)
            ->orderBy('prioridade')   // 1,2,3
            ->orderBy('id')
            ->paginate(10);
    }
}
