export class User {
  email: string = "";
  firstname?: string;
  lastname?: string;
  password?: string;
  roles?: string[];
  token?: string;
}

export interface ApiHeader {
  "User-Agent"?: string;
  "Content-Type"?: string;
  Authorization?: string;
  Accept?: string;
  cty?: string;
  // Ajoute d'autres propriétés nécessaires selon les besoins de ton API
}

export interface UserResponse {
  id: number;
  email: string;
  user: User;
}

export interface ProfileUpdate {
  email: string;
  firstname: string;
  lastname: string;
  new_password: string;
}
