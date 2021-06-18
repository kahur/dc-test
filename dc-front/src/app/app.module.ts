import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';

import {AppComponent} from './app.component';
import {RoutingModule} from './routing.module';
import {Location} from '@angular/common';
import {AuthModule} from './modules/auth/auth.module';
import {TaskModule} from './modules/task/task.module';
import {DefaultLayoutComponent} from './layouts/default-layout.component';

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
export class AppModule {
}
