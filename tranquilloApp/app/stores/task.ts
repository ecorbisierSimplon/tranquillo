import { writable } from "svelte/store";
import { client } from "../lib/client";
import { ErrorResponse, Task, TaskResponse } from "../models/task";

const TASKS_PER_PAGE = 20;

export class TaskStore {
  tasks = writable<Task[]>([]);
  per_page = 20;
  page = -1;

  user_token: string = "";
  no_more_results: boolean = false;

  constructor() {
    this.tasks = writable<Task[]>([]);
  }

  subscribe = (action: any) => {
    return this.tasks.subscribe(action);
  };

  private async loadPage(page: number, user_token: string) {
    let url = "/task";
    // url += `offset=${page * TASKS_PER_PAGE}&limit=${TASKS_PER_PAGE}`;
    let response = await client.sendRequest<TaskResponse>(
      url,
      "get",
      user_token
    );
    // console.log(response);
    // this.page = page;
    this.user_token = user_token;

    const task: Task[] = response.task || [];

    this.no_more_results = response.task ? response.task.length == 0 : true;

    // if (this.page == 0) {
    this.tasks.set(response.task);
    // } else {
    //   this.tasks.update((tasks: any) => [...tasks, ...response.task]);
    // }
  }

  private async delete(id: number, user_token: string) {
    let url = "/task/" + id;
    // url += `offset=${page * TASKS_PER_PAGE}&limit=${TASKS_PER_PAGE}`;
    let response = await client.sendRequest<ErrorResponse>(
      url,
      "delete",
      user_token
    );
    // console.log(response);
    // this.page = page;
    this.user_token = user_token;

    return response.status;
  }

  deleteTask(id: number, user_token: string = "") {
    return this.delete(id, user_token);
  }

  loadTasks(user_token: string = "") {
    return this.loadPage(0, user_token);
  }

  loadNextPage() {
    if (this.no_more_results) return;
    return this.loadPage(this.page + 1, this.user_token);
  }
}
