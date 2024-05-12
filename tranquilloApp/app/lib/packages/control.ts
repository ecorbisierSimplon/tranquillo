import { validateForm } from "~/lib/packages/Pattern";
import { localize } from "~/lib/packages/localize";
import { ErrRespTask, ErrTask, Task } from "~/models/task";
import { ErrRegister, ErrRespRegister, User } from "~/models/user";
import { EventEmitter } from "~/utils/eventemitter";

type ValidationErrors = { [index: string]: string[] };

class FormError {
  constructor(message: string, errorCode: number = 0) {
    this.message = message;
    this.errorCode = errorCode;
  }
  errors: ValidationErrors = {};
  errorCode: number = 0;
  message: string = "Form Error";
}

class Control {
  onError: EventEmitter<FormError>;
  constructor() {
    this.onError = new EventEmitter<FormError>();
  }
  async register(user: User): Promise<ErrRespRegister> {
    const err: ErrRegister = {};
    err.email = (await validateForm.email(user.email)) ?? null;
    err.lastname =
      (await validateForm.field(
        user.lastname ?? "",
        localize("user.lastname")
      )) ?? null;
    err.firstname =
      (await validateForm.field(
        user.firstname ?? "",
        localize("user.firstname")
      )) ?? null;
    err.password = (await validateForm.password(user.password ?? "")) ?? null;
    err.password_repeat =
      (await validateForm.confirmPassword(
        user.password ?? "",
        user.password_repeat ?? ""
      )) ?? null;

    return {
      ok: Object.values(err).every((value) => value === null),
      user,
      err,
    };
  }

  async task(task: Task): Promise<ErrRespTask> {
    const err: ErrTask = {};
    err.name =
      (await validateForm.field(task.name ?? "", localize("task.name"))) ??
      null;

    err.description = null;
    // (await validateForm.field(
    //   task.description ?? "",
    //   localize("description")
    // )) ?? null;

    err.startAt = task.startAt
      ? await validateForm.checkType(task.startAt ?? "", "Date")
      : null;
    err.endAt = task.endAt
      ? await validateForm.checkType(task.endAt ?? "", "Date")
      : null;
    err.reminder =
      (await validateForm.checkType(task.reminder ?? "", "number")) ?? null;

    return {
      ok: Object.values(err).every((value) => value === null),
      task,
      err,
    };
  }
}

export let control = new Control();
