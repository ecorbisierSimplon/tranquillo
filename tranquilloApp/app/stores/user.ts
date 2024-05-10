import { writable, derived, get } from "svelte/store";
import { client } from "../lib/client";
import * as appSettings from "@nativescript/core/application-settings";
import { ProfileUpdate, User, UserResponse } from "../models/user";

function buildUserTokenStore() {
  var stored_token = appSettings.getString("user_token", undefined);
  const user_token = writable(stored_token);
  return {
    subscribe: user_token.subscribe,
    set(value: string) {
      if (value) {
        appSettings.setString("user_token", value);
      } else {
        appSettings.remove("user_token");
      }
      user_token.set(value);
    },
  };
}

export const user_token = buildUserTokenStore();

function buildUserProfileStore() {
  const user_profile = writable<User | null>(null);

  const user_profile_with_defaults = derived(user_profile, (profile) => {
    return profile;
  });

  return {
    subscribe: user_profile_with_defaults.subscribe,

    loadUserFromToken(user_token: string | null) {
      if (!user_token) return Promise.resolve(null);
      // Supposons que client et sendRequest soient correctement définis ailleurs
      return client
        .sendRequest<UserResponse>("/user", "GET", user_token)
        .then((userResponse) => user_profile.set(userResponse.user ?? null));
    },

    set: user_profile.set,
  };
}

export const user_profile = buildUserProfileStore();

/**
 * Cette fonction est utilisée pour déconnecter un utilisateur.
 */
export function logout() {
  user_profile.set(null);
  user_token.set("");
}

/**
 * Cette fonction prend un e-mail et un mot de passe comme paramètres d'entrée et renvoie une promesse
 * qui se résout en un objet utilisateur.
 * @param {string} email - Adresse e-mail de l'utilisateur essayant de se connecter.
 * @param {string} password - Le paramètre « password » dans la fonction « login » est une chaîne qui
 * représente le mot de passe de l'utilisateur. Il est utilisé à des fins d'authentification pour
 * vérifier l'identité de l'utilisateur lors de la connexion au système.
 */
export function login(email: string, password: string): Promise<User> {
  return client
    .sendRequest<UserResponse>("/login_check", "POST", null, {
      username: email.trim(),
      password: password.trim(),
    })
    .then((userResponse) => {
      // console.log("UserResponse : " + userResponse.token);

      let user: User = userResponse.user as User;
      user_token.set(userResponse.token as string);
      user_profile.set(user as User);
      return user;
    });
}

/**
 * Cette fonction prend un objet ProfileUpdate en entrée et renvoie une promesse qui se résout en un
 * objet User après la mise à jour du profil.
 * @param {ProfileUpdate} update - Objet ProfileUpdate contenant les champs à mettre à jour pour le
 * profil d'un utilisateur.
 */
export function update(update: ProfileUpdate): Promise<User> {
  let payload: any = {
    firstname: update.firstname.trim(),
    lastname: update.lastname.trim(),
    email: update.email.trim(),
  };
  if (update.new_password) {
    payload.new_password = update.new_password;
  }

  return client
    .sendRequest<UserResponse>("/user", "PUT", get(user_token), {
      user: payload,
    })
    .then((userResponse) => {
      let user: User = userResponse.user as User;
      user_token.set(user?.token as string);
      user_profile.set(user ?? null);
      return user;
    });
}

/**
 * Cette fonction est utilisée pour enregistrer un nouvel utilisateur avec les détails fournis.
 * @param {string} lastname - Nom de famille de l'utilisateur sous forme de chaîne
 * @param {string} firstname - Prénom de l'utilisateur.
 * @param {string} email - La fonction `register` prend quatre paramètres : `lastname`, `firstname`,
 * `email` et `password`, qui sont tous de type `string`. La fonction renvoie une « Promesse » qui se
 * résout en un objet « Utilisateur ».
 * @param {string} password - La fonction `register` prend quatre paramètres : `lastname`, `firstname`,
 * `email` et `password`. Le paramètre « password » est un type de chaîne, qui représente généralement
 * le mot de passe choisi par l'utilisateur pour son compte. Il est important de gérer et de stocker
 * les mots de passe en toute sécurité pour garantir la sécurité des comptes d'utilisateurs.
 */
export function register(
  lastname: string,
  firstname: string,
  email: string,
  password: string
): Promise<User> {
  return client
    .sendRequest<any>("/user", "POST", null, {
      lastname: lastname.trim(),
      firstname: firstname.trim(),
      email: email.trim(),
      password: password.trim(),
    })
    .then((response) => {
      // let user: User = userResponse.user as User;
      // user_token.set(user.token || "");
      // user_profile.set(user);
      console.log("Response key   : " + Object.keys(response));
      console.log("Response value : " + Object.values(response));

      return response;
    });
}
