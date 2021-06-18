import {Injectable} from "@angular/core";
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {ConfigService} from "../../../services/config.service";
import {map} from "rxjs/operators";
import {Observable} from "rxjs";
import {TaskList} from "../entity/TaskList";
import {AuthService} from "../../auth/services/auth.service";
import {UserCredentials} from "../../auth/services/entity/user-credentials";
import {TaskItem} from "../entity/TaskItem";

@Injectable()
export class TaskService {

  constructor(
    private httpClient: HttpClient,
    private config: ConfigService,
    private authService: AuthService
  ) {
  }

  public getMyDailyTasks(): Observable<TaskItem[]> {
    const credentials: UserCredentials|any = this.authService.getCredentials();
    let token: string = '';

    if (credentials) {
       token = credentials.token;
    }

    let headers = new HttpHeaders({
        'Authorization' : token
    });

    return this.httpClient.get<TaskItem[]>(this.myDailyTaskEndpoint, {responseType: 'json', headers: headers })
      .pipe(
        map((response: any) => {
          if (response.status === 'error') {
            throw new Error(response.error);
          }

          let items: TaskItem[] = response.content;

          return items;
        })
      );
  }

  get myDailyTaskEndpoint() {
    return this.config.getConfig('apiUrl') + '/task/my-list'
  }
}
