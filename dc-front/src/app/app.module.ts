import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppComponent } from './app.component';
import { RoutingModule } from './routing.module';
import {AuthComponent} from "./components/auth/auth.component";
import {TaskComponent} from "./components/task/task.component";
import {Location} from "@angular/common";

@NgModule({
  declarations: [
    AppComponent,
    AuthComponent,
    TaskComponent
  ],
  imports: [
    BrowserModule,
    RoutingModule
  ],
  providers: [Location],
  bootstrap: [AppComponent]
})
export class AppModule { }
