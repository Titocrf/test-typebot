import { Component, OnInit } from '@angular/core';
import { ChatbotService } from '../../core/services/chatbot.service';
import { Question } from '../../core/models/question.model';
import { Answer } from '../../core/models/answer.model';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-chatbot',
  templateUrl: './chatbot.component.html',
  styleUrls: ['./chatbot.component.scss'],
  imports: [CommonModule, FormsModule]
})
export class ChatbotComponent implements OnInit {
  questions: Question[] = [];
  currentQuestionIndex = 0;
  currentAnswer = '';
  chatHistory: { text: string, isBot: boolean }[] = [];
  answers: string[] = [];

  constructor(private chatbotService: ChatbotService) { }

  ngOnInit(): void {
    this.loadQuestions();
  }

  async loadQuestions(): Promise<void> {
    try {
      const data = await this.chatbotService.getQuestions().toPromise();
      if (data && data.length > 0) {
        this.questions = data;
        this.addToChatHistory(this.questions[this.currentQuestionIndex].question_text, true);
      }
    } catch (error) {
      console.error('Erro ao carregar perguntas', error);
    }
  }

  async submitAnswer(): Promise<void> {
    if (!this.currentAnswer.trim()) return;

    this.addToChatHistory(this.currentAnswer, false);

    const answer: Answer = {
      question_id: this.questions[this.currentQuestionIndex].id,
      response_text: this.currentAnswer,
    };

    try {
      await this.chatbotService.saveAnswer(answer).toPromise();
      this.answers[this.currentQuestionIndex] = this.currentAnswer;
      this.currentQuestionIndex++;
      this.currentAnswer = '';

      if (this.currentQuestionIndex < this.questions.length) {
        this.showNextQuestion();
      } else {
        this.finishChat();
      }
    } catch (error) {
      console.error('Erro ao salvar resposta', error);
    }
  }

  private showNextQuestion(): void {
    const nextQuestionText = this.replacePlaceholders(this.questions[this.currentQuestionIndex].question_text);
    this.addToChatHistory(nextQuestionText, true);
  }

  private finishChat(): void {
    this.addToChatHistory('Obrigado por responder todas as perguntas!', true);
  }

  private replacePlaceholders(text: string): string {
    return text.replace(/{{(\d+)}}/g, (match, p1) => this.answers[parseInt(p1, 10) - 1] || match);
  }

  private addToChatHistory(text: string, isBot: boolean): void {
    this.chatHistory.push({ text, isBot });
  }
}
