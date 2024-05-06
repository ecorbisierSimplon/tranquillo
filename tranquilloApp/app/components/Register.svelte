<script lang="ts">
  import { writable } from "svelte/store";
  import ActionBar from "../ActionBar.svelte";
  import { isPage } from "~/lib/packages/variables";
  import Menu from "~/Menu.svelte";
  isPage.set("register");
</script>

<page>
  <ActionBar />
  <stackLayout>
    <Menu />
  </stackLayout>
</page>
