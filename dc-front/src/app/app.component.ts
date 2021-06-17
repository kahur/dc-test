import { Component } from '@angular/core';
import { AuthService } from "./services/auth/auth.service";
import {Location} from "@angular/common";
import {Router} from "@angular/router";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'my-app';
  isAuthenticated = false;

  constructor(
    protected authService: AuthService,
    protected location: Location,
    protected router: Router
  ) {
    this.isAuthenticated = authService.isAuthenticated();
    console.log(authService.isAuthenticated());
    if (location.path(false) === "") {
      if (!this.isAuthenticated) {
        this.router.navigate(['/login']);
        return;
      }

      this.router.navigate(['/dashboard']);
      return;
    }

    if (location.path(false) === '/login' && this.isAuthenticated) {
      this.router.navigate(['/dashboard']);
      return;
    }
  }
}
