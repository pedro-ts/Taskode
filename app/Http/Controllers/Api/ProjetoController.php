<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Projeto;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Projeto::query()
            ->withCount('tarefas')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'       => 'required|string|max:100',
            'descricao'  => 'nullable|string',
            'linguagens' => 'required|array',
            'publico'    => 'required|integer|in:0,1',
            'id_user'    => 'required|integer|exists:usuarios,id',
        ]);

        $projeto = Projeto::create($data);
        return response()->json($projeto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $projeto = Projeto::findOrFail($id);
        // return $projeto->load('dono:id,nome,email,pontos', 'tarefas');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $projeto = Projeto::findOrFail($id);

        $data = $request->validate([
            'nome'       => 'sometimes|string|max:100',
            'descricao'  => 'nullable|string',
            'linguagens' => 'sometimes|array',
            'publico'    => 'sometimes|integer|in:0,1',
            // normalmente não se troca id_user aqui; se precisar, valide como no store
        ]);

        $projeto->update($data);
        return $projeto->loadCount('tarefas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $projeto = Projeto::findOrFail($id);
        $projeto->delete();
        return response()->noContent(); // 204
    }
}
