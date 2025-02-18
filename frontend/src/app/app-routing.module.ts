import { Routes } from '@angular/router'; 
import { ChatbotComponent } from './features/chatbot/chatbot.component';

export const routes: Routes = [
  { path: '', component: ChatbotComponent }, 
  { path: '**', redirectTo: '' } 
];
