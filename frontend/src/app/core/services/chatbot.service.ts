import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { Question } from '../models/question.model';
import { Answer } from '../models/answer.model';

@Injectable({
  providedIn: 'root',
})
export class ChatbotService {
  private baseUrl = environment.apiBaseUrl;

  constructor(private http: HttpClient) {}

  getQuestions(): Observable<Question[]> {
    return this.http.get<Question[]>(`${this.baseUrl}/question`);
  }

  saveAnswer(answer: Answer): Observable<any> {
    return this.http.post(`${this.baseUrl}/answer`, answer);
  }
}
