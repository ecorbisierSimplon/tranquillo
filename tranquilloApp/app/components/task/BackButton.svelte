<script lang="ts">
  import { icons } from "~/utils/icons";
  import { goBack } from "svelte-native";
</script>

<label
  text={icons.arrow_left}
  class="icon arrow-left"
  verticalAlignment="center"
  horizontalAlignment="left"
  on:tap={goBack}
/>

<style lang="scss">
  .icon {
    margin-right: 10;
    font-weight: bold;
    color: hsl(0, 100%, 26%);
  }
</style>
