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
    class="btn round home icon menu home {$classHome}"
    on:tap={home}
  />

  {#if !$user_profile}
    <!-- isEnabled={$isPage != "home"} -->
    <label
      text={icons.power}
      class="btn round login icon menu power {$classLogin}"
      on:tap={login}
    />

    <!-- isEnabled={$isPage != "login"} -->
    <label
      text={icons.account_add}
      class="btn round register icon menu account-add {$classRegister}"
      on:tap={register}
    />
  {:else}
    <label
      text={icons.power}
      class="btn round islogin icon power enabled"
      on:tap={logout}
    />
  {/if}
</flexboxLayout>

<!-- isEnabled={$isPage != "register"} -->

<style lang="scss">
  flexboxLayout {
    margin: 2px 0;
    padding: 5 0;
    border-top-width: 2px;
    border-top-style: solid;
    border-top-color: hsl(34, 72%, 74%);
    background-color: hsl(30, 100%, 98%);
  }
  // background-color: hsl(44, 100%, 88%);
  //label {
  //}
</style>
