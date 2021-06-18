import {Component, OnInit} from "@angular/core";
import {TaskService} from "./services/task.service";
import {TaskList} from "./entity/TaskList";
import {TaskItem} from "./entity/TaskItem";

@Component({
  templateUrl: './task.component.html',
  styleUrls: [
    './task.component.css'
  ],
  selector: 'dc-task'
})
export class TaskComponent implements OnInit {
  public tasks: TaskItem[] = [];
  public isLoading: boolean = false;

  constructor(private taskService: TaskService) {
  }

  ngOnInit(): void {
    this.isLoading = true;
    this.taskService.getMyDailyTasks()
      .subscribe(data => {
        this.isLoading = false;
        this.tasks = data;
      })
  }
}
