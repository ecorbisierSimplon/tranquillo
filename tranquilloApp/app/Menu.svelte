<script lang="ts">
  import Home from "./components/Home.svelte";
  import Register from "./components/Register.svelte";
  import Login from "./components/Login.svelte";
  import { navigate } from "svelte-native";
  import { icons } from "./utils/icons";
  import { isPage, isLogged } from "./lib/packages/variables";
  import { getWritable } from "./lib/packages/getWritable";

  const width: number = 80;
  const height: number = 50;
  const classLogged: string = getWritable(isLogged) == true ? "login" : "";

  function home() {
    navigate({ page: Home, clearHistory: true });
  }
  function register() {
    navigate({ page: Register, clearHistory: true });
  }
  function login() {
    navigate({ page: Login, clearHistory: true });
  }
</script>

<wrapLayout height="60" class="btn-group btn-group-lg">
  <button
    text={icons.home}
    class="icon home btn btn-primary"
    {width}
    {height}
    on:tap={home}
    isEnabled={$isPage != "home"}
  />

  <button
    text={icons.power}
    class="{classLogged} icon power btn btn-primary"
    {width}
    {height}
    on:tap={login}
    isEnabled={$isPage != "login"}
  />

  <button
    text={icons.account_add}
    class="icon account-add btn btn-primary"
    {width}
    {height}
    on:tap={register}
    isEnabled={$isPage != "register"}
  />
</wrapLayout>

<style lang="scss">
  button {
    &.power {
      background-color: rgb(105, 199, 102);
    }
    &.login {
      background-color: rgb(199, 102, 102);
    }
    &:disabled {
      background-color: rgb(163, 163, 163);
    }
  }
</style>
