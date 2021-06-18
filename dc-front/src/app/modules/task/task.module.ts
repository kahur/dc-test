import {NgModule} from "@angular/core";
import {CommonModule} from "@angular/common";
import { PerfectScrollbarModule } from 'ngx-perfect-scrollbar';
import { PERFECT_SCROLLBAR_CONFIG } from 'ngx-perfect-scrollbar';
import { PerfectScrollbarConfigInterface } from 'ngx-perfect-scrollbar';
import {TaskComponent} from "./task.component";
import {TaskListComponent} from "./task-list/task-list.component";
import {TaskItemComponent} from "./task-list/task-item/task-item.component";
import {TaskService} from "./services/task.service";
import {HttpClientModule} from "@angular/common/http";

const DEFAULT_PERFECT_SCROLLBAR_CONFIG: PerfectScrollbarConfigInterface = {
  suppressScrollX: true
};

@NgModule({
  declarations: [
    TaskComponent,
    TaskListComponent,
    TaskItemComponent
  ],
  imports: [
    CommonModule,
    HttpClientModule,
    PerfectScrollbarModule
  ],
  providers: [
    {
      provide: PERFECT_SCROLLBAR_CONFIG,
      useValue: DEFAULT_PERFECT_SCROLLBAR_CONFIG
    },
    TaskService
  ]
})
export class TaskModule {}
