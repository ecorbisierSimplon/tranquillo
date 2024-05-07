import { writable } from "svelte/store";

export let isLoading = writable<boolean>(false);
