<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Exibir todas as perguntas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $questions = Question::orderBy('order')->get();
        return response()->json($questions);
    }

    /**
     * Exibir uma pergunta específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $question = Question::with('answers')->findOrFail($id);

        // Retorna a pergunta específica em formato JSON
        return response()->json($question);
    }

    /**
     * Armazenar uma nova resposta.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeResponse(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'response_text' => 'required',
        ]);

        // Cria e salva a resposta no banco de dados
        $response = new Answer();
        $response->response_text = $request->response_text;
        $response->question_id = $request->question_id;
        $response->save();

        return response()->json(['message' => 'Resposta salva com sucesso!']);
    }

    /**
     * Atualizar uma pergunta existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Valida os dados da pergunta
        $request->validate([
            'question_text' => 'required|string|max:255',
            'type' => 'required|string|in:yesno,text',
            'order' => 'required|integer',
        ]);

        // Encontra a pergunta pelo ID
        $question = Question::findOrFail($id);

        // Atualiza a pergunta com os dados fornecidos
        $question->update($request->all());

        return response()->json($question);
    }

    /**
     * Deletar uma pergunta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Encontra a pergunta pelo ID
        $question = Question::findOrFail($id);

        // Deleta a pergunta
        $question->delete();

        return response()->json(['message' => 'Pergunta deletada com sucesso!']);
    }
}
