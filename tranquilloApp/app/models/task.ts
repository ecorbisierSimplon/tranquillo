export class Task {
  id?: number;
  name?: string = "";
  description?: string;
  reminder?: number;
  startAt?: Date;
  endAt?: Date;
  createAt?: Date;
  usersId?: number;
  length?: number;
}

export interface SingleTaskResponse {
  task: Task;
}

export class ErrRegister {
  name?: string | null;
  description?: string | null;
  reminder?: string | null;
  startAt?: string | null;
  endAt?: string | null;
}

export class ErrRespRegister {
  ok: boolean = false;
  task?: Task;
  err?: ErrRegister;
}

export interface ApiHeader {
  "User-Agent"?: string;
  "Content-Type"?: string;
  Authorization?: string;
  Accept?: string;
  cty?: string;
  // Ajoute d'autres propriétés nécessaires selon les besoins de ton API
}

export interface TaskResponse {
  token: string;
  code: number;
  task: Task[];
}

export interface ErrorResponse {
  title?: string;
  status?: number;
  detail?: string;
}
