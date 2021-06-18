import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppComponent } from './app.component';
import { RoutingModule } from './routing.module';
import {TaskComponent} from "./modules/task/task.component";
import {Location} from "@angular/common";
import {AuthModule} from "./modules/auth/auth.module";
import {TaskModule} from "./modules/task/task.module";
import {DefaultLayoutComponent} from "./layouts/default-layout.component";
import {HTTP_INTERCEPTORS, HttpClient} from "@angular/common/http";
import {AuthInterceptor} from "./modules/auth/services/auth.interceptor";
import {AuthService} from "./modules/auth/services/auth.service";

@NgModule({
  declarations: [
    AppComponent,
    DefaultLayoutComponent
  ],
  imports: [
    BrowserModule,
    RoutingModule,
    AuthModule,
    TaskModule
  ],
  providers: [
    Location
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
