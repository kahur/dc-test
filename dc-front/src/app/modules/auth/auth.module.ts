import {NgModule} from "@angular/core";
import {AuthComponent} from "./auth.component";
import {BrowserModule} from "@angular/platform-browser";
import {ReactiveFormsModule} from "@angular/forms";
import {AuthFormComponent} from "./form/auth-form.component";
import {HTTP_INTERCEPTORS, HttpClientModule} from "@angular/common/http";
import {AuthInterceptor} from "./services/auth.interceptor";

@NgModule({
  declarations: [
    AuthComponent,
    AuthFormComponent
  ],
  imports: [
    BrowserModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthInterceptor,
      multi: true
    }
  ],
  exports: [
    AuthFormComponent
  ],
})
export class AuthModule {
}
