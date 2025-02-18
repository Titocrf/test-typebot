import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable()
export class ApiInterceptor implements HttpInterceptor {
  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(req).pipe(
      catchError((error: HttpErrorResponse) => {
        let errorMessage = 'Ocorreu um erro desconhecido!';

        if (error.status === 0) {
          errorMessage = 'Erro de rede. Verifique sua conexão.';
        } else if (error.status === 404) {
          errorMessage = 'Recurso não encontrado!';
        } else if (error.status === 500) {
          errorMessage = 'Erro no servidor!';
        }
        
        console.error('Erro API:', errorMessage);
        return throwError(() => new Error(errorMessage));
      })
    );
  }
}
