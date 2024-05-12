export class Task {
  id?: number;
  name?: string = "";
  description?: string;
  reminder?: number;
  startAt?: Date | null = null;
  endAt?: Date | null = null;
  createAt?: Date;
  usersId?: number;
  length?: number;
}

export interface SingleTaskResponse {
  task: Task;
}

export class ErrTask {
  name?: string | null;
  description?: string | null;
  reminder?: string | null;
  startAt?: string | null;
  endAt?: string | null;
}

export class ErrRespTask {
  ok: boolean = false;
  task?: Task;
  err?: ErrTask;
}

export interface TaskResponse {
  token: string;
  code: number;
  task: Task[];
}
