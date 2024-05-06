<script lang="ts">
  import Home from "./Home.svelte";
  import Register from "./Register.svelte";
  import ActionBar from "../ActionBar.svelte";
  import Menu from "~/Menu.svelte";
  import { isPage } from "~/lib/packages/variables";
  import { icons } from "../utils/icons";
  import { alert } from "@nativescript/core/ui/dialogs";
  import { navigate } from "svelte-native";
  import { onMount } from "svelte";

  // import { user_token, user_profile, login } from "../stores/user";
  import { login } from "../stores/login";
  import { localize } from "~/lib/packages/localize";

  let email: string = "";
  let password: string = "";

  let isLoading = false;
  let emailL: string = "";
  let passwordL: string = "";
  let noAccountL: string = "";
  let registerL: string = "";
  let loginL: string = "";

  onMount(async () => {
    emailL = await localize("user.email");
    passwordL = await localize("user.password");
    noAccountL = await localize("form.no_account", true);
    registerL = await localize("form.register", true);
    loginL = await localize("form.login", true);
    // if ($user_profile) {
    //   // closeModal($user_profile);
    // }
  });

  function handleEmailChange(event: { value: string }) {
    email = event.value;
  }

  function handlePasswordChange(event: { value: string }) {
    password = event.value;
  }

  function loginForm() {
    console.log("Email:", email);
    console.log("Password:", password);

    // Ici, vous pouvez envoyer les valeurs à votre API Symfony pour authentifier l'utilisateur
    login(email, password);
    // login(email, password).then(
    //   console.log("response login"),
    //   // (user) => closeModal(user),
    //   // (err) => {
    //   //   if (err.errorCode == 422) {
    //   //     alert("Invalid username/password");
    //   //   } else {
    //   //     alert(err.message);
    //   //   }
    //   // },
    // );
  }
  function register() {
    navigate({ page: Register, clearHistory: true });
  }
  function home() {
    navigate({ page: Home, clearHistory: true });
  }

  isPage.set("login");
</script>

<page>
  <ActionBar />
  <stackLayout>
    <Menu />

    <label row="0" text="" class="" horizontalAlignment="right" />
    <stackLayout row="1" class="form mb-3 mt-3" verticalAlignment="center">
      <label text={registerL} class="title" horizontalAlignment="center" />
      <stackLayout class="input-field">
        <textField
          on:textChange={handleEmailChange}
          class="input"
          hint={emailL}
          keyboardType="email"
          autocorrect="false"
          autocapitalizationType="none"
          returnKeyType="next"
          editable={!isLoading}
        ></textField>
        <stackLayout class="hr-light" />
      </stackLayout>
      <!-- on:returnPress={() => password_edit.nativeView.focus()} -->

      <stackLayout class="input-field">
        <textField
          on:textChange={handlePasswordChange}
          class="input"
          hint={passwordL}
          secure="false"
          returnKeyType="done"
          editable={!isLoading}
        ></textField>
        <stackLayout class="hr-light" />
      </stackLayout>
      <!-- on:returnPress={doLogin} -->

      <button
        text={loginL}
        on:tap={loginForm}
        class="btn m-t-20"
        isEnabled={!isLoading}
      />

      <activityIndicator
        busy={isLoading}
        horizontalAlignment="center"
        verticalAlignment="center"
        class="activity-indicator"
      />
    </stackLayout>

    <label
      row="2"
      class="login-label sign-up-label"
      on:tap={register}
      horizontalAlignment="center"
    >
      <formattedString>
        <span text={noAccountL} />
        <span text=" {registerL}" class="bold" />
      </formattedString>
    </label>
  </stackLayout>
</page>

<style lang="scss">
  .close-button {
    font-size: 25;
    padding: 10;
  }

  .btn {
    background-color: rgb(11, 40, 121);
    color: white;
  }

  label.title {
    font-weight: bold;
    font-size: 20;
    margin-top: 20;
    margin-bottom: 20;
    color: rgb(211, 155, 2);
  }

  .form {
    padding: 20;
  }

  .input {
    font-size: 13;
  }
  .sign-up-label {
    font-size: 15;
    padding: 10;
  }

  .bold {
    font-weight: bold;
    color: rgb(15, 61, 104);
  }
</style>
