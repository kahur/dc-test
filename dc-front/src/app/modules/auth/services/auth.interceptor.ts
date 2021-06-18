import {
  HttpErrorResponse,
  HttpEvent,
  HttpHandler,
  HttpHeaders,
  HttpInterceptor,
  HttpRequest
} from "@angular/common/http";
import {Inject, Injectable, Injector} from "@angular/core";
import {Observable, throwError} from "rxjs";
import {AuthService} from "./auth.service";
import {Router} from "@angular/router";
import {UserCredentials} from "./entity/user-credentials";
import {catchError} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class AuthInterceptor implements HttpInterceptor
{
  constructor(private authService: AuthService, private router: Router) {}

  private handleError(err: HttpErrorResponse): Observable<any> {
    let errorMsg;
    if (err.error instanceof Error) {
      // A client-side or network error occurred. Handle it accordingly.
      errorMsg = `An error occurred: ${err.error.message}`;
    } else {
      // The backend returned an unsuccessful response code.
      // The response body may contain clues as to what went wrong,
      errorMsg = `Backend returned code ${err.status}, body was: ${err.error}`;
    }

    if (err.status === 401 || err.status === 403) {
      this.authService.removeCredentials();
      this.router.navigateByUrl(`/login`);
    }
    console.error(errorMsg);

    return throwError(errorMsg);
  }

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    let credentials: UserCredentials|any = this.authService.getCredentials();

    if (credentials) {
      const headers = new HttpHeaders({
        'Auth' : credentials.token
      })
      // Clone the request to add the new header.
      const authReq = req.clone({headers: headers});
      // Pass on the cloned request instead of the original request.
      return next.handle(authReq).pipe(
        catchError(this.handleError.bind(this))
      );
    }

    // carry on with normal request
    return next.handle(req).pipe(
      catchError(this.handleError.bind(this))
    );
  }

}
