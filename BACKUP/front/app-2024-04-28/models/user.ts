export class User {
  email: string = "";
  username: string = "";
  token?: string;
  bio?: string;
  image?: string;
}

export interface ApiHeader {
  "Content-Type"?: string;
  Authorization?: string;
  // Ajoute d'autres propriétés nécessaires selon les besoins de ton API
}

export interface UserResponse {
  id: number;
  username: string;
  email: string;
  user: User;
  image: string; // L'image est facultative, donc elle est définie comme une chaîne optionnelle
}
