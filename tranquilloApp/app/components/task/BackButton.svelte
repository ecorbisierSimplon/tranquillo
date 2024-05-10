<script lang="ts">
  import { icons } from "~/utils/icons";
  import { goBack } from "svelte-native";
</script>

<label
  text={icons["arrow_left"]}
  class="icon back-button"
  verticalAlignment="center"
  horizontalAlignment="left"
  on:tap={goBack}
/>

<style lang="scss">
  .back-button {
    margin-right: 5;
    padding: 10 10 10 0;
  }
</style>
