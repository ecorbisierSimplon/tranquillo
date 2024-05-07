<script lang="ts">
  import Register from "./Register.svelte";
  import Home from "./Home.svelte";
  import ActionBar from "../layout/ActionBar.svelte";
  import Menu from "~/layout/Menu.svelte";
  import { alert } from "@nativescript/core/ui/dialogs";
  import { navigate } from "svelte-native";
  import { onMount } from "svelte";
  import { localize } from "~/lib/packages/localize";
  import { isPage } from "~/lib/packages/variables";
  import { user_token, user_profile, login } from "../stores/user";
  import { isLoading } from "./base";

  isPage.set("login");
  // import { user_token, user_profile, login } from "../stores/user";

  // export let msg;
  let email: string = "",
    password: string = "",
    email_edit: string = "",
    password_edit: string = "",
    emailL: string = "",
    passwordL: string = "",
    noAccountL: string = "",
    notLoggedL: string = "",
    registerL: string = "",
    loginL: string = "";

  onMount(async () => {
    emailL = await localize("user.email");
    passwordL = await localize("user.password");
    noAccountL = await localize("form.no_account", true);
    noAccountL = await localize("form.no_account", true);
    notLoggedL = await localize("message.not_logged", true);
    registerL = await localize("form.register", true);
    loginL = await localize("form.login", true);
  });
  onMount(() => {
    if ($user_profile) {
      homeResult($user_profile);
    }
  });

  function doLogin() {
    login(email as string, password as string).then(
      (user) => homeResult(user),
      (err) => {
        console.log(err.errorCode);

        if (err.errorCode > 202) {
          alert(notLoggedL);
        } else {
          alert(err.message);
        }
      },
    );
  }

  function handleEmailChange(event: { value: string }) {
    email = event.value;
  }

  function handlePasswordChange(event: { value: string }) {
    password = event.value;
  }

  function register() {
    navigate({ page: Register, clearHistory: true });
  }
  function homeResult(result: any) {
    isLoading.set(true);
    navigate({ page: Home, clearHistory: true });
  }
</script>

<page>
  <ActionBar />
  <stackLayout>
    <Menu />

    <stackLayout row="1" class="mb-3 mt-3" verticalAlignment="center">
      <label text={registerL} class="form-label" horizontalAlignment="center" />
      <stackLayout class="form-contro">
        <textField
          bind:this={email_edit}
          on:textChange={handleEmailChange}
          hint={emailL}
          class="input"
          keyboardType="email"
          autocorrect="false"
          autocapitalizationType="none"
          returnKeyType="next"
          editable={!$isLoading}
          on:returnPress={() => password_edit.nativeView.focus()}
        />
        <stackLayout class="hr-light" />
      </stackLayout>

      <stackLayout class="input-field">
        <textField
          bind:this={password_edit}
          on:textChange={handlePasswordChange}
          hint={passwordL}
          class="input"
          secure="true"
          returnKeyType="done"
          editable={!$isLoading}
          on:returnPress={doLogin}
        />
        <stackLayout class="hr-light" />
      </stackLayout>

      <button
        text={loginL}
        on:tap={doLogin}
        class="btn m-t-20"
        isEnabled={!$isLoading}
      />

      <activityIndicator
        busy={$isLoading}
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
