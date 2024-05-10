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
    password_edit: string = "";

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
          alert(localize("message.error.not_logged", true));
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
  <dockLayout stretchLastChild="true">
    <stackLayout dock="bottom">
      <Menu />
    </stackLayout>
    <scrollView scrollBarIndicatorVisible="true">
      <stackLayout class="form">
        <stackLayout row="1" class="mb-3 mt-3" verticalAlignment="middle">
          <label
            text={localize("form.login", true)}
            class="title form-label"
            horizontalAlignment="center"
          />
          <!-- on:returnPress={() => password_edit.nativeView.focus()} -->
          <stackLayout class="form-contro">
            <textField
              bind:this={email_edit}
              on:textChange={handleEmailChange}
              hint={localize("user.email")}
              class="input"
              keyboardType="email"
              autocorrect="false"
              autocapitalizationType="none"
              returnKeyType="next"
              editable={!isLoading}
              on:returnPress={() => password_edit.nativeView.focus()}
            />
            <!-- <stackLayout class="hr-light" /> -->
          </stackLayout>

          <stackLayout class="input-field">
            <textField
              bind:this={password_edit}
              on:textChange={handlePasswordChange}
              hint={localize("user.password")}
              class="input"
              secure="true"
              returnKeyType="done"
              on:returnPress={doLogin}
              editable={!isLoading}
            />
            <!-- <stackLayout class="hr-light" /> -->
          </stackLayout>

          <button
            text={localize("button.validate", true)}
            class="btn"
            on:tap={doLogin}
            isEnabled={!isLoading}
          />

          <activityIndicator
            busy={isLoading}
            horizontalAlignment="center"
            verticalAlignment="middle"
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
            <span text={localize("form.no_account", true)} />
            <span text=" {localize('form.register', true)}" class="bold" />
          </formattedString>
        </label>
      </stackLayout>
    </scrollView>
  </dockLayout>
</page>
