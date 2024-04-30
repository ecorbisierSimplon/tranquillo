<script lang="ts">
  import Home from "./components/Home.svelte";
  import { icons } from "./utils/icons";
</script>

<page>
  <actionBar>
    <stackLayout orientation="horizontal">
      <label
        row="0"
        text={icons.close}
        class="icon close-button"
        horizontalAlignment="right"
        width="40"
        height="40"
        verticalAlignment="center"
      />
      <label
        text="Tranquillo App &copy;"
        fontSize="24"
        verticalAlignment="center"
      />
    </stackLayout>
  </actionBar>
  <Home />
</page>
