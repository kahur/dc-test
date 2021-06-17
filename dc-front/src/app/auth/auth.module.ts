import {NgModule} from "@angular/core";
import {AuthComponent} from "./auth.component";
import {BrowserModule} from "@angular/platform-browser";
import {ReactiveFormsModule} from "@angular/forms";
import {HttpClientModule} from "@angular/common/http";
import {AuthFormComponent} from "./form/auth-form.component";

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
  exports: [
    AuthFormComponent
  ],
})
export class AuthModule {
}
