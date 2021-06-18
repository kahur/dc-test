import {Component, Input} from "@angular/core";
import {TaskList} from "../entity/TaskList";
import {TaskItem} from "../entity/TaskItem";

@Component({
  templateUrl: './task-list.component.html',
  styleUrls: [
    './task-list.component.css'
  ],
  selector: 'dc-task-list'
})
export class TaskListComponent {
  @Input() taskList: TaskItem[] = [];

  constructor() {
    console.log(this.taskList);
  }
}
