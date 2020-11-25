<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\API\ApiError;

class CursoController extends Controller
{
    private $curso;

    //Construtor
    public function __construct(Curso $curso){
        $this->curso = $curso;
    }

    //Listar todos
    public function index(){
        return response()->json($this->curso->paginate(10), 200);
    }

    //Exibir um pelo id
    public function show($id){
        $curso = $this->curso->find($id);

        if(!$curso){
            return response()->json(['data' => ['Curso não encontrado.']], 404);
        }
        $data = ['data' => $curso];
        return response()->json($data, 200);
    }

    //Criar novo
    public function store(Request $request){
        try {
            $cursoData = $request->all();
            $this->curso->create($cursoData);

            $return = ['data' => ['msg' => 'Curso criado.']];
            return response()->json($return, 201);

        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Não foi possível completar esta requisição.', 1010));
        }
    }

    //Atualizar pelo id
    public function update(Request $request, $id){
        try {
            $cursoData = $request->all();
            $curso = $this->curso->find($id);
            $curso->update($cursoData);

            $return = ['data' => ['msg' => 'Curso atualizado.']];
            return response()->json($return, 201);

        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Não foi possível completar esta requisição.', 1010));
        }
    }

    //Deletar pelo id
    public function delete(Curso $id){
        try {
            $id->delete();

            $return = ['data' => ['msg' => 'Curso `'. $id->titulo. '` removido.']];
            return response()->json($return, 200);

        }catch(\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Não foi possível completar esta requisição.', 1010));
        }
    }

}
