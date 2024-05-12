<script lang="ts">
  isPage.set("login");

  import { alert } from "@nativescript/core/ui/dialogs";
  import { onMount } from "svelte";
  import { navigate } from "svelte-native";
  import Register from "./Register.svelte";
  import Home from "~/components/Home.svelte";
  import ActionBar from "~/components/layout/ActionBar.svelte";
  import Menu from "~/components/layout/Menu.svelte";
  import { localize } from "~/lib/packages/localize";
  import { isPage } from "~/lib/packages/variables";
  import { user_profile, login } from "~/stores/user";
  import { icons } from "~/utils/icons";

  let isLoading: boolean = false,
    email: string = "",
    password: string = "",
    email_edit: string = "",
    password_edit: string = "";
  let disabled: string = "";

  onMount(() => {
    if ($user_profile) {
      homeResult($user_profile);
    }
  });

  function doLogin(): void {
    if (disabled === "") {
      isLoading = true;
      disabled = "disabled";
      login(email as string, password as string).then(
        (user) => {
          homeResult(user);
        },
        (err) => {
          if (err.errorCode > 202) {
            alert({
              title: "Connexion",
              message: localize("message.error.not_logged", true),
              okButtonText: "OK",
            });
          } else {
            alert(err.message);
          }
          isLoading = false;
          disabled = "";
        },
      );
    }
  }

  function register(): void {
    navigate({ page: Register, clearHistory: true });
  }
  function homeResult(result: any): void {
    isLoading = true;
    disabled = "disabled";
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
      <stackLayout>
        <label
          text={localize("form.login", true)}
          class="title"
          horizontalAlignment="center"
        />
        <stackLayout class="form">
          <stackLayout verticalAlignment="middle">
            <!-- on:returnPress={() => password_edit.nativeView.focus()} -->
            <stackLayout class="form-contro">
              <textField
                bind:this={email_edit}
                on:textChange={(event) => {
                  email = event.value;
                }}
                hint={localize("user.email")}
                class="input"
                keyboardType="email"
                autocorrect="false"
                autocapitalizationType="none"
                returnKeyType="next"
                editable={!isLoading}
              />
              <!-- on:returnPress={() => password_edit.nativeView.focus()} -->
              <!-- <stackLayout class="hr-light" /> -->
            </stackLayout>

            <stackLayout class="input-field">
              <textField
                bind:this={password_edit}
                on:textChange={(event) => {
                  password = event.value;
                }}
                hint={localize("user.password")}
                class="input"
                secure="true"
                returnKeyType="done"
                editable={!isLoading}
              />
            </stackLayout>

            <label
              text={icons.check}
              class="btn round icon check {disabled}"
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
      </stackLayout>
    </scrollView>
  </dockLayout>
</page>
