import { start } from "@nativescript/core/profiling";

export const i18n = {
  name_app: "Tranquillo",
  yes: "yes",
  no: "no",
  date: "date",
  time: "time",
  minutes: "minute$1",
  hours: "hour$1",
  days: "day$1",
  previously: "previously",
  none: "none",
  description: "description",
  user: {
    email: "email",
    password: "password",
    password_repeat: "recopy password",
    lastname: "lastname",
    firstname: "firstname",
  },
  task: {
    title: "list of tasks",
    no_task: "no tasks are here... yet",
    name: "title",
    start_date: "start date",
    start_time: "start time",
    end_date: "end date",
    end_time: "end time",
    start: "starting at",
    before: "before the",
    delay: "lead time",
  },
  form: {
    no_account: "don't have an account?",
    as_account: "already have an account?",
    registration: "registration",
    register: "register",
    login: "login",
  },
  dialog: {
    approve: "approve",
    reject: "reject",
    confirm_select: "confirm $1",
  },
  button: {
    validate: "Confirm",
    cancel: "cancel",
    edit: "edit",
    delete: "delete",
    share: "share",
  },
  message: {
    welcome: "welcome",
    ok_register: "you can log in",
    confirm_delete: "do you really want to remove '$1'?",
    title: {
      ok_register: "registration successful",
      err_validation: "validation problem",
      delete_task: "delete task",
      HTTP_100: "Continue",
      HTTP_101: "Switching Protocols",
      HTTP_200: "OK",
      HTTP_201: "Created",
      HTTP_202: "Accepted",
      HTTP_203: "Non-Authoritative Information",
      HTTP_204: "No Content",
      HTTP_205: "Reset Content",
      HTTP_206: "Partial Content	",
      HTTP_300: "Multiple Choices",
      HTTP_301: "Moved Permanently",
      HTTP_302: "Found",
      HTTP_303: "See Other",
      HTTP_304: "Not Modified",
      HTTP_305: "Use Proxy",
      HTTP_306: "(Unused)",
      HTTP_307: "Temporary Redirect	",
      HTTP_400: "Bad Request",
      HTTP_401: "Unauthorized",
      HTTP_402: "Payment Required",
      HTTP_403: "Forbidden",
      HTTP_404: "Not Found",
      HTTP_405: "Method Not Allowed",
      HTTP_406: "Not Acceptable",
      HTTP_407: "Proxy Authentication Required",
      HTTP_408: "Request Timeout",
      HTTP_409: "Conflict",
      HTTP_410: "Gone",
      HTTP_411: "Length Required",
      HTTP_412: "Precondition Failed",
      HTTP_413: "Request Entity Too Large",
      HTTP_414: "Request-URI Too Long",
      HTTP_415: "Unsupported Media Type",
      HTTP_416: "Requested Range Not Satisfiable",
      HTTP_417: "Expectation Failed	",
      HTTP_422: "Unprocessable Entity",
      HTTP_500: "Internal Server Error",
      HTTP_501: "Not Implemented",
      HTTP_502: "Bad Gateway",
      HTTP_503: "Service Unavailable",
      HTTP_504: "Gateway Timeout",
      HTTP_505: "HTTP Version Not Supported",
    },
    error: {
      not_logged: "invalid username/password",
      not_registered: "invalid user name/email/password",
      email_exist: "this email already exists",
    },
  },
  pattern: {
    name: "please enter a valid '$1'!",
    email: "please enter a valid email address!",
    password: {
      length: "password must be at least 8 characters long!",
      force:
        "the password must contain at least one uppercase, lowercase, number and special character @#.$%^&:+=! !",
      repeat: "the passwords don't match",
    },
    type: "the value is not of type '$1'",
  },
};
