<script lang="ts">
  import Home from "~/components/Home.svelte";
  import Register from "~/components/user/Register.svelte";
  import Login from "~/components/user/Login.svelte";
  import { navigate } from "svelte-native";
  import { icons } from "~/utils/icons";
  import { isPage, isLogged } from "~/lib/packages/variables";
  import { user_profile } from "~/stores/user";

  const width: number = 80;
  const height: number = 50;

  function home(): void {
    navigate({ page: Home, clearHistory: true });
  }
  function register(): void {
    navigate({ page: Register, clearHistory: true });
  }
  function login(): void {
    navigate({ page: Login, clearHistory: true });
  }
  function logout(): void {
    $user_profile = null;
    navigate({ page: Home, clearHistory: true });
  }
</script>

<wrapLayout class="btn-group btn-group-lg">
  <button
    text={icons.home}
    class="home icon menu home btn btn-primary"
    on:tap={home}
    isEnabled={$isPage != "home"}
  />
  {#if !$user_profile}
    <button
      text={icons.power}
      class="login icon menu power btn btn-primary"
      on:tap={login}
      isEnabled={$isPage != "login"}
    />

    <button
      text={icons.account_add}
      class="register icon menu account-add btn btn-primary"
      on:tap={register}
      isEnabled={$isPage != "register"}
    />
  {:else}
    <button
      text={icons.power}
      class="islogin icon power btn btn-primary"
      on:tap={logout}
    />
  {/if}
</wrapLayout>

<style lang="scss">
  wrapLayout {
    margin-top: 2;
    border-bottom-width: 2;
    border-bottom-style: solid;
    border-bottom-color: rgb(255, 224, 183);
    // background-color: hsl(44, 100%, 88%);
  }
  button {
    width: 60;
    height: 40;
    border-radius: 5;
    margin: 4 2 4 4;

    box-shadow:
      2px 2px 5px 1px rgba(2, 76, 146, 0.527),
      -1px -1px 2px 2px rgb(66, 20, 20);
    &.home {
      background-color: rgb(148, 182, 255);
    }
    &.login {
      background-color: rgb(147, 219, 144);
    }
    &.islogin {
      background-color: rgb(255, 148, 148);
    }
    &.register {
      background-color: rgb(148, 182, 255);
    }
    &:disabled {
      // background-color: rgb(163, 163, 163);
      box-shadow: 0 0 0 rgba(0, 0, 0, 0);
    }
  }
</style>
