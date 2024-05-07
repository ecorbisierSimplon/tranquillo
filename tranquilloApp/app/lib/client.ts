import { ErrRespRegister, ErrorResponse } from "~/models/user";
import { EventEmitter } from "~/utils/eventemitter";

const API_BASE = "http://192.168.178.27:8088/api";

// type ValidationErrors = { [index: string]: string[] };

class ApiError {
  constructor(message: string, errorCode: number = 0) {
    this.message = message;
    this.errorCode = errorCode;
  }
  errors: ErrorResponse = {};
  errorCode: number = 0;
  message: string = "Api Error";
}

class ApiClient {
  onError: EventEmitter<ApiError>;

  constructor() {
    this.onError = new EventEmitter<ApiError>();
  }

  async sendRequest<T>(
    relative_url: string,
    method: string,
    token: string | null = null,
    payload = {}
  ): Promise<T> {
    /* Cette instruction « console.log » enregistre un message sur la console avec des informations sur
  la requête HTTP en cours. Il concatène la constante `API_BASE` avec le paramètre `relative_url`
  pour former l'URL complète demandée. De plus, il inclut la méthode HTTP utilisée pour la requête. */
    console.log(
      "fetching : url -> ",
      `${API_BASE}${relative_url}`,
      "; method -> ",
      method
    );

    /* Ce bloc de code configure les en-têtes d'une requête HTTP : */
    let headers: HeadersInit = {};
    if (payload) {
      headers["Content-Type"] = "application/json";
      headers["Accept"] = "application/json";
      headers["cty"] = "JWTTranquillo";
    }
    if (token) {
      headers["Authorization"] = `Token ${token}`;
    }

    /* Cet extrait de code effectue une requête HTTP asynchrone à l'aide de l'API « fetch » en
  JavaScript/TypeScript  : */
    let res;
    try {
      res = await fetch(`${API_BASE}${relative_url}`, {
        method: method,
        mode: "cors",
        headers: headers,
        body: payload ? JSON.stringify(payload) : null,
      });
    } catch (e) {
      console.log("error running fetch", e);
      throw e;
    }
    /* Ce bloc de code gère les réponses d'erreur de la requête API  : */
    if (!res.ok) {
      let err = new ApiError(res.statusText, res.status);
      try {
        let validation_errors: ErrorResponse = await res.json();
        console.log("Error serveur1 : " + Object.keys(validation_errors));
        err.errors = validation_errors;
        console.log("Error serveur2 : " + Object.values(err.errors));
      } catch {}

      this.onError.fire(err);
      throw err;
    }

    /* Ce bloc de code tente d'analyser la réponse du serveur au format JSON en utilisant `res.json()`.
    Si l'analyse réussit, elle renvoie les données JSON analysées. Cependant, si une erreur se
    produit pendant le processus d'analyse (par exemple, si la réponse n'est pas un JSON valide), il
    détecte l'erreur, crée une nouvelle instance `ApiError` avec le message "Erreur lors de
    l'analyse de la réponse du serveur", déclenche le `onError`. événement avec cette erreur, puis
    renvoie l'erreur à gérer par l'appelant de la méthode `sendRequest`. Cela garantit que tous les
    problèmes liés à l'analyse de la réponse du serveur sont correctement traités et signalés via
    l'événement « onError ». */
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
