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

export function logout() {
  user_profile.set(null);
  user_token.set("");
}

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
