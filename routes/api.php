<?php

use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\ProjetoController;
use App\Http\Controllers\Api\TarefaController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Aqui você registra suas rotas de API.
| Elas são automaticamente prefixadas com /api
| Exemplo: GET /api/usuarios
*/

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

