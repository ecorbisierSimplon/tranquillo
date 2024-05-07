import { EventEmitter } from "../utils/eventemitter";

const API_BASE = "http://localhost:8088/api";

type ValidationErrors = { [index: string]: string[] };

/* La classe ApiError dans TypeScript définit un objet d'erreur avec un message et un code d'erreur,
ainsi qu'une propriété d'erreurs facultative pour les erreurs de validation. */
class ApiError {
  constructor(message: string, errorCode: number = 0) {
    this.message = message;
    this.errorCode = errorCode;
  }
  errors: ValidationErrors = {};
  errorCode: number = 0;
  message: string = "Api Error";
}

/* La classe ApiClient dans TypeScript gère l'envoi de requêtes à une API, la gestion des erreurs et
l'analyse des réponses du serveur. */
class ApiClient {
  onError: EventEmitter<ApiError>;

  constructor() {
    this.onError = new EventEmitter<ApiError>();
  }

  async sendRequest<T>(
    relative_url: string,
    method: string,
    token: string = "",
    payload = {}
  ): Promise<T> {
    console.log("fetching ", `${API_BASE}${relative_url}`, method);
    let headers: HeadersInit = {};
    if (payload) {
      headers["Content-Type"] = "application/json";
      headers["Accept"] = "application/json";
      headers["cty"] = "JWTTranquillo";
    }
    if (token) {
      headers["Authorization"] = `Bearer ${token}`;
    }

    let res;
    try {
      res = await fetch(`${API_BASE}${relative_url}`, {
        method: method,
        headers: {
          "User-Agent": "Tranquillo application",
          "Content-Type": "application/json",
          Accept: "application/json",
          cty: "JWTTranquillo",
        },
        body: payload ? JSON.stringify(payload) : null,
      });
    } catch (e) {
      console.log("error running fetch", e);
      throw e;
    }
    // mode: "cors",
    // headers,

    if (!res.ok) {
      let err = new ApiError(res.statusText, res.status);
      if (res.status == 422) {
        try {
          let validation_errors = await res.json();
          err.errors = validation_errors;
        } catch {}
      }
      this.onError.fire(err);
      throw err;
    }

    try {
      return await res.json();
    } catch {
      let err = new ApiError("Error parsing server response");
      this.onError.fire(err);
      throw err;
    }
  }
}

export let client = new ApiClient();
