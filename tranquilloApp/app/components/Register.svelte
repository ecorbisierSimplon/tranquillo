<script lang="ts">
  import ActionBar from "../layout/ActionBar.svelte";
  import { isPage } from "~/lib/packages/variables";
  import Menu from "~/layout/Menu.svelte";
  isPage.set("register");
</script>

<page>
  <ActionBar />
  <stackLayout>
    <Menu />
  </stackLayout>
</page>
