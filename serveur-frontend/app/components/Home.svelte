<script lang="ts">
  let message: string = "c'ets moi";
</script>

<page>
  <actionBar title="Home" />
  <gridLayout>
    <label
      class="text-xl align-middle text-center text-gray-500"
      text={message}
    />
  </gridLayout>
</page>

<style>
  .info {
    font-size: 20;
  }
</style>
