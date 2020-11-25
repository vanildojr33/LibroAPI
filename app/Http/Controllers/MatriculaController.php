<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\API\ApiError;

class MatriculaController extends Controller
{
    private $matricula;

    //Construtor
    public function __construct(Matricula $matricula){
        $this->matricula = $matricula;
    }

    //Listar todos
    public function index(){
        return response()->json($this->matricula->paginate(10), 200);
    }

    //Exibir um pelo id
    public function show($id){
        $matricula = $this->matricula->find($id);

        if(!$matricula){
            return response()->json(['data' => ['Matrícula não encontrada.']], 404);
        }
        $data = ['data' => $matricula];
        return response()->json($data, 200);
    }

    //Criar novo
    public function store(Request $request){
        try {
            $matriculaData = $request->all();
            $this->matricula->create($matriculaData);

            $return = ['data' => ['msg' => 'Matrícula criada.']];
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
            $matriculaData = $request->all();
            $matricula = $this->matricula->find($id);
            $matricula->update($matriculaData);

            $return = ['data' => ['msg' => 'Matrícula atualizada.']];
            return response()->json($return, 201);

        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Não foi possível completar esta requisição.', 1010));
        }
    }

    //Deletar pelo id
    public function delete(Matricula $id){
        try {
            $id->delete();

            $return = ['data' => ['msg' => 'Matrícula `'. $id->id. '` removida.']];
            return response()->json($return, 200);

        }catch(\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Não foi possível completar esta requisição.', 1010));
        }
    }
}
