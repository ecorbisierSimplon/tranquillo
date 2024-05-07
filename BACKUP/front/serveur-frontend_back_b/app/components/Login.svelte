<script>
  import Register from "./Register";
  import { icons } from "../utils/icons";
  import { closeModal } from "svelte-native";
  import { alert } from "@nativescript/core/ui/dialogs";
  import { navigate } from "svelte-native";
  import { onMount } from "svelte";
  import { localize } from '@nativescript/localize'

  // import { user_token, user_profile, login } from "../stores/user";
  import { user_profile, login } from "../stores/user";

  // export let msg;
  let email, password, password_edit;
  let isLoading = false;

  onMount(() => {
    if ($user_profile) {
      closeModal($user_profile);
    }
  });

  function doLogin() {
    login(email, password).then(
      (user) => closeModal(user),
      (err) => {
        if (err.errorCode == 422) {
          alert("Invalid username/password");
        } else {
          alert(err.message);
        }
      },
    );
  }

  function register() {
    navigate({ page: Register, clearHistory: true });
  }
</script>

<!-- <frame id="detail-page-frame">
  <page actionBarHidden="false"> -->
<gridLayout class="layout page" rows="auto, *, auto">
  { localize(':NAME_APP') }
  <label
    row="0"
    text={icons.close}
    class="icon close-button"
    horizontalAlignment="right"
    on:tap={closeModal}
  />
  <stackLayout row="1" class="mb-3 mt-3" verticalAlignment="center">
    <label text="S'enregistrer" class="form-label" horizontalAlignment="center" />
    <stackLayout class="form-contro">
      <textField
        class="input"
        hint={ localize(':EMAIL') }
        keyboardType="email"
        autocorrect="false"
        autocapitalizationType="none"
        bind:this={email}
        returnKeyType="next"
        on:returnPress={() => password_edit.nativeView.focus()}
        editable={!isLoading}
      />
      <stackLayout class="hr-light" />
    </stackLayout>

    <stackLayout class="input-field">
      <textField
        bind:this={password_edit}
        class="input"
        hint="Password"
        secure="true"
        returnKeyType="done"
        on:returnPress={doLogin}
        editable={!isLoading}
      />
      <stackLayout class="hr-light" />
    </stackLayout>

    <button
      text="Login"
      on:tap={login}
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
      <span text="Don't have an account?" />
      <span text=" Register" class="bold" />
    </formattedString>
  </label>
</gridLayout>

<!-- </page>
</frame> -->

<style>
  .close-button {
    font-size: 25;
    padding: 10;
  }

  .btn {
    background-color: rgb(11, 40, 121);
    color: white;
  }

  .title {
    font-weight: bold;
    font-size: 20;
    margin-top: 20;
    margin-bottom: 20;
    color: rgb(211, 155, 2);
  }

  .form {
    padding: 20;
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
