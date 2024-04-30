<script lang="ts">
  import Login from "./Login.svelte";
  import { showModal } from "svelte-native";

  let message: string = "Bonjour ma chérie ! :)";

  let modalResult = "Waiting for modal";
  async function launchModal() {
    let result = await showModal({ page: Login, props: { msg: "hi" } });
    modalResult = `got result: ${result}`;
  }
</script>

<gridLayout>
  <label class="info">
    <formattedString>
      <span class="fas" text="&#xf135;" />
      <span text=" {message}" />
    </formattedString>
  </label>
  <stackLayout>
    <button text="Se Connecter" on:tap={launchModal} />
    <label text={modalResult} />
  </stackLayout>
</gridLayout>

<style lang="scss">
  .info {
    font-size: 20;
    horizontal-align: center;
    .fas {
      color: #3a53ff;
    }
  }
</style>
