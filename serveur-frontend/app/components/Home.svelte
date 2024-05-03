<script>
  import Login from "./Login.svelte";
  import { navigate } from "svelte-native";

  let message = "Bonjour ma chérie ! :)";

  let loginResult = "Waiting for login";
  // async function launchModal() {
  //   let result = await showModal({ page: Login, props: { msg: "hi" } });
  //   modalResult = `got result: ${result}`;
  // }
</script>

<gridLayout>
  <label class="info">
    <formattedString>
      <span class="fas" text="&#xf135;" />
      <span text=" {message}" />
    </formattedString>
  </label>
  <stackLayout>
    <!-- <button text="Se Connecter" on:tap={() => navigate({ page: Login })} /> -->
    <label text={loginResult} />
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
