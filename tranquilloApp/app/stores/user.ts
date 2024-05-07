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
        .then((userResponse) => user_profile.set(userResponse));
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
      username: email,
      password: password,
    })
    .then((userResponse) => {
      console.log(userResponse);

      let user = userResponse.user;
      user_token.set(userResponse.token || "");
      user_profile.set(user);
      return user;
    });
}

export function update(update: ProfileUpdate): Promise<User> {
  let payload: any = {
    firstname: update.firstname,
    lastname: update.lastname,
    email: update.email,
  };
  if (update.new_password) {
    payload.new_password = update.new_password;
  }

  return client
    .sendRequest<UserResponse>("/user", "PUT", get(user_token), {
      user: payload,
    })
    .then((userResponse) => {
      let user = userResponse.user;
      user_token.set(user.token || "");
      user_profile.set(user);
      return user;
    });
}

export function register(
  username: string,
  email: string,
  password: string
): Promise<User> {
  return client
    .sendRequest<UserResponse>("/users", "POST", undefined, {
      user: {
        username: username,

        email: email,
        password: password,
      },
    })
    .then((userResponse) => {
      let user = userResponse.user;
      user_token.set(user.token || "");
      user_profile.set(user);
      return user;
    });
}
