<script lang="ts">
  import { localize } from "~/lib/packages/localize";
  import ActionBar from "../layout/ActionBar.svelte";
  import Menu from "../layout/Menu.svelte";
  import { isPage } from "~/lib/packages/variables";
  import { onMount } from "svelte";
  import { strUcFirst } from "~/lib/packages/functions";

  isPage.set("home");

  let nameApp: string = "";

  onMount(async () => {
    nameApp = strUcFirst(await localize("name_app"));
  });
</script>

<page>
  <ActionBar />
  <stackLayout>
    <Menu />
    <label class="info" height="80">
      <formattedString>
        <span class="fas" text="&#xf135;" />
        <span text=" {nameApp}" />
      </formattedString>
    </label>
  </stackLayout>
</page>

<style>
  .info .fas {
    color: #3a53ff;
  }

  .info {
    font-size: 20;
    horizontal-align: center;
    vertical-align: center;
  }
</style>
