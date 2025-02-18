<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserindo perguntas de exemplo
        $questions = [
            [
                'question_text' => 'Qual é o seu nome?',
                'type' => 'text',
                'order' => 1
            ],
            [
                'question_text' => '{{1}}, qual a sua idade?',
                'type' => 'text',
                'order' => 2
            ],
            [
                'question_text' => 'Qual é o seu número de telefone?',
                'type' => 'phone',
                'order' => 3
            ],
            [
                'question_text' => 'Qual é o seu CPF?',
                'type' => 'cpf',
                'order' => 4
            ],
            [
                'question_text' => 'Você já usou seu FGTS?',
                'type' => 'decision',
                'order' => 5
            ],
        ];

        // Inserir as perguntas no banco de dados
        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
