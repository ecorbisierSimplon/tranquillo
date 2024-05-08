<script lang="ts">
  import { writable } from "svelte/store";
  import { getWritable } from "~/lib/packages/getWritable";
  import Home from "~/components/Home.svelte";
  import Register from "~/components/user/Register.svelte";
  import Login from "~/components/user/Login.svelte";
  import { navigate } from "svelte-native";
  import { icons } from "~/utils/icons";
  import { isPage, isLogged } from "~/lib/packages/variables";
  import { user_profile } from "~/stores/user";

  const width: number = 80;
  const height: number = 50;

  const classHome = writable<string>(
    getWritable(isPage) == "home" ? "disabled" : "enabled",
  );
  const classLogin = writable<string>(
    getWritable(isPage) == "login" ? "disabled" : "enabled",
  );
  const classRegister = writable<string>(
    getWritable(isPage) == "register" ? "disabled" : "enabled",
  );

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

<flexboxLayout justifyContent="space-around">
  <label
    text={icons.home}
    class="btn home icon menu home {$classHome}"
    on:tap={home}
  />

  {#if !$user_profile}
    <!-- isEnabled={$isPage != "home"} -->
    <label
      text={icons.power}
      class="btn login icon menu power {$classLogin}"
      on:tap={login}
    />

    <!-- isEnabled={$isPage != "login"} -->
    <label
      text={icons.account_add}
      class="btn register icon menu account-add {$classRegister}"
      on:tap={register}
    />
  {:else}
    <label
      text={icons.power}
      class="btn islogin icon power enabled"
      on:tap={logout}
    />
  {/if}
</flexboxLayout>

<!-- isEnabled={$isPage != "register"} -->

<style lang="scss">
  flexboxLayout {
    margin: 2 0;
    border-top-width: 2;
    border-top-style: solid;
    border-top-color: hsl(34, 100%, 86%);
    background-color: hsl(30, 100%, 98%);
  }
  // background-color: hsl(44, 100%, 88%);
  label {
    &.btn {
      width: 60;
      height: 60;
      border-radius: 50%;
      margin: 4 2 4 4;
      text-align: center;
      box-shadow: 0 0 0 rgb(255, 255, 255);
      font-weight: bold;
      font-size: 25;

      border-style: solid;
      border-width: 2;
      border-color: hsl(0, 0%, 100%, 0);
      color: rgb(150, 150, 150);
      &.islogin {
        color: hsl(0, 80%, 65%);
        font-size: 30;
      }

      &.disabled {
        border-color: hsl(54, 98%, 63%);
        box-shadow: -2px -2px 5px 1px hsl(0, 0%, 89%) !important;
        font-size: 30;
        &.home {
          color: hsl(221, 54%, 52%);
        }
        &.login {
          color: hsl(117, 54%, 52%);
        }

        &.register {
          color: hsl(24, 54%, 52%);
        }
      }
      &.enabled {
        box-shadow: 3px 3px 3px 1px hsla(32, 97%, 24%, 0.856) !important;
      }
    }
  }
</style>
