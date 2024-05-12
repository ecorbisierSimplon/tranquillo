export class User {
  id?: number;
  email: string = "";
  firstname?: string;
  lastname?: string;
  password?: string;
  password_repeat?: string;
  roles?: string[];
  token?: string;
}

export class ErrRegister {
  email?: string | null;
  firstname?: string | null;
  lastname?: string | null;
  password?: string | null;
  password_repeat?: string | null;
}

export class ErrRespRegister {
  ok: boolean = false;
  user?: User;
  err?: ErrRegister;
}

export class Login {
  username: string = "";
  password: string = "";
}

export interface UserResponse {
  token: string;
  code: number;
  user?: User;
}

export interface LoginResponse {
  id: number;
  email: string;
  user: Login;
}

export interface ProfileUpdate {
  email: string;
  firstname: string;
  lastname: string;
  new_password: string;
}

export interface Profile {
  lastname: string;
  firstname: string;
  email: string;
}
