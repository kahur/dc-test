import {Component, Input} from "@angular/core";
import {TaskItem} from "../../entity/TaskItem";

@Component({
  templateUrl: './task-item.component.html',
  styleUrls: [
    './task-item.component.css'
  ],
  selector: 'dc-task-item'
})
export class TaskItemComponent {
  @Input() taskItem: TaskItem|null = null;
}
