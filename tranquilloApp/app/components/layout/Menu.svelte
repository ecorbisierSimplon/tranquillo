<script lang="ts">
  import { writable } from "svelte/store";
  import { getWritable } from "~/lib/packages/getWritable";
  import Home from "~/components/Home.svelte";
  import Register from "~/components/user/Register.svelte";
  import Login from "~/components/user/Login.svelte";
  import Task from "~/components/task/CreateTask.svelte";
  import { navigate } from "svelte-native";
  import { icons } from "~/utils/icons";
  import { isPage, isLogged } from "~/lib/packages/variables";
  import { user_profile } from "~/stores/user";

  const width: number = 80;
  const height: number = 50;

  const classHome = writable<string>(
    getWritable(isPage) == "home" ? "actif" : "",
  );
  const classLogin = writable<string>(
    getWritable(isPage) == "login" ? "actif" : "",
  );
  const classRegister = writable<string>(
    getWritable(isPage) == "register" ? "actif" : "",
  );

  function home(): void {
    navigate({ page: Home, clearHistory: true });
  }

  function addTask(): void {
    navigate({ page: Task, clearHistory: true });
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
    class="btn round home icon menu {$classHome}"
    on:tap={home}
  />

  {#if !$user_profile}
    <label
      text={icons.power}
      class="btn round login icon menu power {$classLogin}"
      on:tap={login}
    />

    <label
      text={icons.account_add}
      class="btn round register icon menu account-add {$classRegister}"
      on:tap={register}
    />
  {:else}
    {#if $isPage == "home"}
      <label
        text={icons.plus}
        class="btn round islogin icon plus"
        on:tap={addTask}
      />
    {/if}
    <label
      text={icons.power}
      class="btn round islogin icon power"
      on:tap={logout}
    />
  {/if}
</flexboxLayout>

<style lang="scss">
  flexboxLayout {
    margin: 2px 0;
    padding: 5 0;
    border-top-width: 2px;
    border-top-style: solid;
    border-top-color: hsl(34, 72%, 74%);
    background-color: hsl(30, 100%, 98%);
  }
</style>
