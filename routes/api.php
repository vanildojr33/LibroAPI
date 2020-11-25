<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CursoController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\MatriculaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//rotas API
Route::name('api.')->group(function(){

    //Rotas para Curso
    Route::prefix('/cursos')->group(function(){
        Route::get('/', [CursoController::class, 'index'])->name('cursos');
        Route::get('/{id}', [CursoController::class, 'show'])->name('curso');

        Route::post('/', [CursoController::class, 'store'])->name('novo_curso');
        Route::put('/{id}', [CursoController::class, 'update'])->name('editar_curso');

        Route::delete('/{id}', [CursoController::class, 'delete'])->name('deletar_curso');
    });

    //Rotas para Aluno
    Route::prefix('/alunos')->group(function(){
        Route::get('/', [AlunoController::class, 'index'])->name('alunos');
        Route::get('/{id}', [AlunoController::class, 'show'])->name('aluno');
        Route::get('/nome/{nome}', [AlunoController::class, 'showByName'])->name('nome_aluno');
        Route::get('/email/{email}', [AlunoController::class, 'showByEmail'])->name('email_aluno');
        Route::get('/quantidade/sort', [AlunoController::class, 'sortByAge'])->name('quantidade_aluno');

        Route::post('/', [AlunoController::class, 'store'])->name('novo_aluno');
        Route::put('/{id}', [AlunoController::class, 'update'])->name('editar_aluno');

        Route::delete('/{id}', [AlunoController::class, 'delete'])->name('deletar_aluno');
    });

    //Rotas para Matrícula
    Route::prefix('/matriculas')->group(function(){
        Route::get('/', [MatriculaController::class, 'index'])->name('matriculas');
        Route::get('/{id}', [MatriculaController::class, 'show'])->name('matricula');

        Route::post('/', [MatriculaController::class, 'store'])->name('novo_matricula');
        Route::put('/{id}', [MatriculaController::class, 'update'])->name('editar_matricula');

        Route::delete('/{id}', [MatriculaController::class, 'delete'])->name('deletar_matricula');
    });
});
