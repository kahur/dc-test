import {Component, OnInit} from "@angular/core";
import {AuthService} from "./services/auth.service";
import {LoginData} from "./form/auth-form.component";
import {Router} from "@angular/router";

@Component({
  selector: 'dc-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.css']
})
export class AuthComponent implements OnInit {
  public error: string|null = null;
  public inProgress: boolean = false;

  constructor(private authService: AuthService, private router: Router) {
  }

  ngOnInit(): void {
    this.authService.onAuthenticationSuccess.subscribe(value => {
      this.router.navigate(['/dashboard']);
      this.inProgress = false;
    });

    this.authService.onAuthenticationFailure.subscribe(err => {
      this.error = err;
      this.inProgress = false;
    })
  }

  public authenticate(loginData: LoginData) {
    this.authService.authenticate(loginData.email, loginData.password);
    this.inProgress = true;
  }
}
