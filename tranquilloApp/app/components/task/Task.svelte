<script lang="ts">
  import { localize } from "~/lib/packages/localize";
  import ActionBar from "~/layout/ActionBar.svelte";
  import Menu from "~/layout/Menu.svelte";
  import { isPage } from "~/lib/packages/variables";
  import { onMount } from "svelte";

  isPage.set("home");

  let nameApp: string = "",
    welcomeL: string = "";

  onMount(async () => {
    // welcomeL = await localize("message.welcome", true);
    // nameApp = await localize("name_app");
  });
</script>

<page>
  <ActionBar />
  <dockLayout stretchLastChild="true">
    <stackLayout dock="bottom">
      <Menu />
    </stackLayout>
    <stackLayout>
      <label
        class="title info"
        height="80"
        text={await localize("message.welcome", true)}
      />
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
