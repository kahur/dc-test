import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppComponent } from './app.component';
import { RoutingModule } from './routing.module';
import {TaskComponent} from "./task/task.component";
import {Location} from "@angular/common";
import {AuthModule} from "./auth/auth.module";

@NgModule({
  declarations: [
    AppComponent,
    TaskComponent
  ],
  imports: [
    BrowserModule,
    RoutingModule,
    AuthModule
  ],
  providers: [Location],
  bootstrap: [AppComponent]
})
export class AppModule { }
