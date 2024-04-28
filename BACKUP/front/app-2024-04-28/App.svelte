<script lang="ts">
  import Home from "./components/Home.svelte";
</script>

<page>
  <actionBar>
    <stackLayout orientation="horizontal">
      <image
        src="res://icon"
        width="40"
        height="40"
        verticalAlignment="center"
      />
      <label text="NativeScript" fontSize="24" verticalAlignment="center" />
    </stackLayout>
  </actionBar>
  <Home />
</page>
