<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Usuario::query()
            ->orderBy('id')       // ordenação estável
            ->paginate(10);       // resposta paginada
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'   => ['required', 'string', 'max:100', 'unique:usuarios,nome'],
            'email'  => ['required', 'string', 'email', 'max:150', 'unique:usuarios,email'],
            'senha'  => ['required', 'string', 'max:50'],   // depois podemos hashear
            'foto'   => ['required', 'string', 'max:200'],
            'pontos' => ['sometimes', 'integer', 'min:0'],
        ]);

        $usuario = Usuario::create($data);  // INSERT com fillable
        return response()->json($usuario, 201); // HTTP 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Usuario::findOrFail($id); // 404 automático se não existir
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'nome'   => ['sometimes', 'string', 'max:100', Rule::unique('usuarios', 'nome')->ignore($usuario->id)],
            'email'  => ['sometimes', 'string', 'email', 'max:150', Rule::unique('usuarios', 'email')->ignore($usuario->id)],
            'senha'  => ['sometimes', 'string', 'max:50'],
            'foto'   => ['sometimes', 'string', 'max:200'],
            'pontos' => ['sometimes', 'integer', 'min:0'],
        ]);

        $usuario->update($data);   // UPDATE ...
        return $usuario;           // JSON do registro atualizado
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();        // DELETE ...
        return response()->noContent(); // HTTP 204
    }
}
