import {NgModule} from '@angular/core';
import {RouterModule, Routes} from "@angular/router";
import {TaskComponent} from "./components/task/task.component";
import {AuthComponent} from "./components/auth/auth.component";
import {AuthGuardService} from "./services/auth/auth-guard.service";


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
