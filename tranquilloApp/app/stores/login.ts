import { API_BASE, client } from "~/lib/client";
import { Login, LoginResponse } from "~/models/user";
// import { user_profile, user_token } from "./user";

// export const user_profile = buildUserProfileStore();

export function login(email: string, password: string) {
  console.log(email + " // " + password);

  // export function login() {
  fetch("http://192.168.178.27:8088/api/login_check", {
    method: "POST",
    headers: {
      "User-Agent": "Tranquillo application",
      "Content-Type": "application/json",
      Accept: "application/json",
      cty: "JWTTranquillo",
    },
    body: JSON.stringify({
      username: email,
      password: password,
    }),
  })
    .then((r) => r.json())
    .then((response) => {
      const result = response.json;
      console.log("message : " + response.message);
      console.log("token : " + response.token);
      console.log("code : " + response.code);
      return response.message;
    })
    .catch((e) => {
      // >> (hide)
      console.log("Error: ");
      console.log(e);
      // << (hide)
    });
  //   .sendRequest<LoginResponse>("/login_check", "POST", undefined, {
  //     username: email,
  //     password: password,
  //   })
  //   .then((userResponse) => {
  //     // Vérifiez la réponse de l'API
  //     console.log("Raw Response:", userResponse);

  //     // Sélectionnez les données nécessaires
  //     let user = userResponse.user;
  //     console.log("Processed User Data:", user);

  //     return user;
  //   })
  //   .catch((error) => {
  //     console.error("Login ", error);
  //     throw error; // Propagez l'erreur pour la gérer à un niveau supérieur si nécessaire
  //   });
}
