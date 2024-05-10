<script lang="ts">
  import ActionBar from "~/components/layout/ActionBar.svelte";
  import Menu from "~/components/layout/Menu.svelte";
  import Task from "./task/TaskList.svelte";
  import { isPage } from "~/lib/packages/variables";
  import { user_profile } from "~/stores/user";
  import { localize } from "~/lib/packages/localize";

  isPage.set("home");
</script>

<page>
  <ActionBar />
  <dockLayout stretchLastChild="true">
    <stackLayout dock="bottom">
      <Menu />
    </stackLayout>
    <stackLayout>
      {#if !$user_profile}
        <label
          class="title info"
          height="80"
          text={localize("message.welcome", true)}
        />
      {:else}
        <Task />
      {/if}
    </stackLayout>
  </dockLayout>
</page>

<style>
  .title {
    font-weight: bold;
    font-size: 20;
    margin: 10 0;
    color: rgb(211, 155, 2);
  }

  .info .fas {
    font-size: 20;
    color: hsl(221, 100%, 61%);
  }

  .info {
    horizontal-align: center;
    vertical-align: center;
  }
</style>
