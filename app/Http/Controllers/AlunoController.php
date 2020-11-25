<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Aluno;
use App\API\ApiError;

class AlunoController extends Controller
{
    private $aluno;

    //Construtor
    public function __construct(Aluno $aluno){
        $this->aluno = $aluno;
    }

    //Listar todos
    public function index(){
        return response()->json($this->aluno->paginate(10), 200);
    }

    //Exibir um pelo id
    public function show($id){
        $aluno = $this->aluno->find($id);

        if(!$aluno){
            return response()->json(['data' => ['Aluno não encontrado.']], 404);
        }
        $data = ['data' => $aluno];
        return response()->json($data, 200);
    }

    //Exibir pelo nome
    public function showByName($nome){
        $aluno = Aluno::where('nome', 'LIKE', '%'.$nome.'%')->get();

        if(!$aluno){
            return response()->json(['data' => ['Aluno não encontrado.']], 404);
        }
        $data = ['data' => $aluno];
        return response()->json($data, 200);
    }

    //Exibir pelo email
    public function showByEmail($email){
        $aluno = Aluno::where('email', '=', $email)->get();

        if(!$aluno){
            return response()->json(['data' => ['Aluno não encontrado.']], 404);
        }
        $data = ['data' => $aluno];
        return response()->json($data, 200);
    }

    //Criar novo
    public function store(Request $request){
        try {
            $alunoData = $request->all();
            $this->aluno->create($alunoData);

            $return = ['data' => ['msg' => 'Aluno criado.']];
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
            $alunoData = $request->all();
            $aluno = $this->aluno->find($id);
            $aluno->update($alunoData);

            $return = ['data' => ['msg' => 'Aluno atualizado.']];
            return response()->json($return, 201);

        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Não foi possível completar esta requisição.', 1010));
        }
    }

    //Deletar pelo id
    public function delete(Aluno $id){
        try {
            $id->delete();

            $return = ['data' => ['msg' => 'Aluno `'. $id->nome. '` removido.']];
            return response()->json($return, 200);

        }catch(\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Não foi possível completar esta requisição.', 1010));
        }
    }

    //Informar o total de alunos por faixa etária separados por curso e sexo (Não finalizado)
    public function sortByAge(){
        $sql = ' SELECT COUNT(id) AS quantidade, sexo
                FROM alunos
                GROUP BY sexo
        ';

        /* $curso = ' SELECT cursos.titulo
                    FROM cursos
                        JOIN matriculas
                            ON matriculas.curso_id = cursos.id
                        JOIN alunos
                            ON alunos.id = matriculas.aluno_id
                    GROUP BY cursos.titulo
        '; */

        $alunos = DB::select($sql);

        $data = ['data' => $alunos];
        return response()->json($data, 200);
    }
}
