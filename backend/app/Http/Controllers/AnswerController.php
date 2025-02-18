<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Exibir todas as respostas de uma pergunta específica.
     *
     * @param  int  $questionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($questionId)
    {
        // Obtém todas as respostas de uma pergunta específica
        $responses = Answer::where('question_id', $questionId)->get();

        return response()->json($responses);
    }

    /**
     * Exibir uma resposta específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Encontra a resposta pelo ID
        $response = Answer::findOrFail($id);

        return response()->json($response);
    }

    /**
     * Armazenar uma nova resposta.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Valida os dados da resposta
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'response_text' => 'required',
        ]);

        // Cria e salva a resposta no banco de dados
        $response = new Answer();
        $response->response_text = $request->response_text;
        $response->question_id = $request->question_id;
        $response->save();

        return response()->json(['message' => 'Resposta salva com sucesso!', 'response' => $response], 201);
    }

    /**
     * Atualizar uma resposta existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Valida os dados da resposta
        $request->validate([
            'response_text' => 'required|in:Sim,Não',
        ]);

        // Encontra a resposta pelo ID
        $response = Answer::findOrFail($id);

        // Atualiza a resposta com os dados fornecidos
        $response->update($request->all());

        return response()->json($response);
    }

    /**
     * Deletar uma resposta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Encontra a resposta pelo ID
        $response = Answer::findOrFail($id);

        // Deleta a resposta
        $response->delete();

        return response()->json(['message' => 'Resposta deletada com sucesso!']);
    }
}
