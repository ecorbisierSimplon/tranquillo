<script>
  import Home from "./components/Login.svelte";
  // import { logo } from "";
  import { icons } from "./utils/icons";
</script>

<page>
  <actionBar>
    <stackLayout orientation="horizontal">
      <image src="~/lib/img/logo_titre.png" />
    </stackLayout>
  </actionBar>
  <Home />
</page>

<style lang="scss">
</style>
