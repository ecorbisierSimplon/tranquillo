export interface ApiHeader {
  "User-Agent"?: string;
  "Content-Type"?: string;
  Authorization?: string;
  Accept?: string;
  cty?: string;
  // Ajoute d'autres propriétés nécessaires selon les besoins de ton API
}

export interface ErrorResponse {
  title?: string;
  status?: number;
  detail?: string;
}

export interface DateTime {
  date: string;
  time: string;
  datetime: Date;
}
