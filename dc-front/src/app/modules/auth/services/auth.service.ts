import {EventEmitter, Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {UserCredentials} from "./entity/user-credentials";
import {ConfigService} from "../../../services/config.service";
import {Observable} from "rxjs";
import {map} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private endpoint = '/auth'
  public onAuthenticationSuccess: EventEmitter<UserCredentials> = new EventEmitter<UserCredentials>();
  public onAuthenticationFailure: EventEmitter<any> = new EventEmitter<any>();

  constructor(private httpClient: HttpClient, private config: ConfigService) {
  }

  public isAuthenticated(): boolean {
    let data = localStorage.getItem('dc_sess');

    return (data === null) ? false : true;
  }

  public getCredentials(): UserCredentials | null | unknown {
    let data = localStorage.getItem('dc_sess');

    if (data !== null) {
      data = JSON.parse(data);
      return <UserCredentials | unknown>data!;
    }

    return null;
  }

  public authenticate(email: string, password: string): void {
    this.sendAuthentication(email, password)
      .subscribe(
        (credentials: UserCredentials) => {
          localStorage.setItem('dc_sess', JSON.stringify(credentials));
          this.onAuthenticationSuccess.emit(credentials);
        },
        error => {
          this.onAuthenticationFailure.emit(error.message);
        }
      );
  }

  public removeCredentials() {
    localStorage.removeItem('dc_sess');
  }

  protected sendAuthentication(email: string, password: string): Observable<any> {
    let formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);

    return this.httpClient.post<any>(
      this.getAuthUrl(),
      formData,
      {responseType: 'json'}
    ).pipe(
      map((response: any) => {
        if (response?.status === 'error') {
          throw new Error(response.error);
        }

        return response.content;
      })
    );
  }

  protected getAuthUrl() {
    return this.config.getConfig('apiUrl') + this.endpoint;
  }
}
