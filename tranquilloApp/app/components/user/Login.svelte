<script lang="ts">
  isPage.set("login");

  import { alert } from "@nativescript/core/ui/dialogs";
  import { onMount } from "svelte";
  import { navigate } from "svelte-native";
  import Register from "./Register.svelte";
  import Home from "~/components/Home.svelte";
  import ActionBar from "~/layout/ActionBar.svelte";
  import Menu from "~/layout/Menu.svelte";
  import { localize } from "~/lib/packages/localize";
  import { isPage } from "~/lib/packages/variables";
  import { user_token, user_profile, login } from "~/stores/user";
  import { get } from "svelte/store";

  // export let msg;
  let isLoading: boolean = false,
    email: string = "",
    password: string = "",
    email_edit: string = "",
    password_edit: string = "",
    emailL: string = "",
    passwordL: string = "",
    noAccountL: string = "",
    notLoggedL: string = "",
    registerL: string = "",
    loginL: string = "",
    bt_validL: string = "";

  onMount(async () => {
    emailL = await localize("user.email");
    passwordL = await localize("user.password");
    noAccountL = await localize("form.no_account", true);
    notLoggedL = await localize("message.error.not_logged", true);
    registerL = await localize("form.register", true);
    loginL = await localize("form.login", true);
    bt_validL = await localize("button.validate", true);
  });

  onMount(() => {
    if ($user_profile) {
      homeResult($user_profile);
    }
  });

  function doLogin(): void {
    isLoading = true;
    login(email as string, password as string).then(
      (user) => {
        // console.log("Token : " + get(user_token));
        // console.log("Token : " + Object.values(user));

        homeResult(user);
      },
      (err) => {
        console.log(err.errorCode);

        if (err.errorCode > 202) {
          alert(notLoggedL);
        } else {
          alert(err.message);
        }
        isLoading = false;
      },
    );
  }

  function handleEmailChange(event: { value: string }): void {
    email = event.value;
  }

  function handlePasswordChange(event: { value: string }): void {
    password = event.value;
  }

  function register(): void {
    navigate({ page: Register, clearHistory: true });
  }
  function homeResult(result: any): void {
    isLoading = true;
    navigate({ page: Home, clearHistory: true });
  }
</script>

<page>
  <ActionBar />
  <stackLayout>
    <Menu />

    <stackLayout row="1" class="mb-3 mt-3" verticalAlignment="center">
      <label
        text={loginL}
        class="title form-label"
        horizontalAlignment="center"
      />
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
          on:returnPress={() => password_edit.nativeView.focus()}
          editable={!isLoading}
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
          on:returnPress={doLogin}
          editable={!isLoading}
        />
        <stackLayout class="hr-light" />
      </stackLayout>

      <button
        text={bt_validL}
        class="btn m-t-20 submit"
        on:tap={doLogin}
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
