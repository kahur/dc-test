import {NgModule} from '@angular/core';
import {RouterModule, Routes} from "@angular/router";
import {TaskComponent} from "./task/task.component";
import {AuthComponent} from "./auth/auth.component";
import {AuthGuardService} from "./auth/services/auth/auth-guard.service";


const routes: Routes = [
  { path: 'login', component: AuthComponent},
  {
    path: 'dashboard', children: [
      {path: '', pathMatch: 'full', component: TaskComponent}
    ],
    canActivate: [AuthGuardService]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
  providers: [AuthGuardService]
})
export class RoutingModule {
}
