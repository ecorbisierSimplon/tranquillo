<script lang="ts">
  import { isPage } from "~/lib/packages/variables";
  import Menu from "~/layout/Menu.svelte";
  import { goBack } from "svelte-native";
  import ActionBar from "~/layout/ActionBar.svelte";

  let email: string = ""; // ou une autre valeur par défaut
  let password: string = ""; // ou une autre valeur par défaut

  isPage.set("register");

  function handleEmailChange(event: { value: string }) {
    email = event.value;
  }

  function handlePasswordChange(event: { value: string }) {
    password = event.value;
  }

  function login() {
    console.log("Email:", email);
    console.log("Password:", password);

    // Ici, vous pouvez envoyer les valeurs à votre API Symfony pour authentifier l'utilisateur
  }
</script>

<page>
  <ActionBar />
  <stackLayout>
    <Menu />
  </stackLayout>
  <gridLayout rows="auto, auto, auto">
    <stackLayout row="1">
      <textField hint="username" on:textChange={handleEmailChange} />
      <textField
        hint="password"
        secure="true"
        on:textChange={handlePasswordChange}
      />
      <button text="Sign in" class="-primary -rounded-lg" on:tap={login} />
    </stackLayout>

    <label
      row="2"
      text="Go Back"
      class="go-back"
      textWrap="true"
      on:tap={goBack}
    />
  </gridLayout>
</page>
