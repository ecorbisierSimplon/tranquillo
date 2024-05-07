import { writable } from "svelte/store";

export const isPage = writable<string>("home");
export const isLogged = writable<boolean>(false);
export const isLang = writable<string>("fr_FR");
