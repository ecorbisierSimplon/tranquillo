<script lang="ts">
  isPage.set("register");

  import Login from "~/components/user/Login.svelte";
  import ActionBar from "~/components/layout/ActionBar.svelte";
  import Menu from "~/components/layout/Menu.svelte";
  import { alert } from "@nativescript/core/ui/dialogs";
  import { onMount } from "svelte";
  import { navigate } from "svelte-native";
  import { user_profile, register } from "~/stores/user";
  import { localize } from "~/lib/packages/localize";
  import { isPage } from "~/lib/packages/variables";
  import { ErrRegister, ErrRespRegister } from "~/models/user";
  import { control } from "~/lib/packages/control";
  import { icons } from "~/utils/icons";

  let errMessage: ErrRegister = {};

  let isLoading = false,
    lastname: string = "",
    firstname: string = "",
    email: string = "",
    password: string = "",
    password_repeat: string = "";

  let lastname_edit: any,
    firstname_edit: any,
    email_edit: any,
    password_edit: any,
    password_repeat_edit: any;

  onMount(() => {
    if ($user_profile) {
      homeResult($user_profile);
    }
  });

  async function doRegister() {
    isLoading = true;
    const res: ErrRespRegister = await control.register({
      lastname,
      firstname,
      email,
      password,
      password_repeat,
    });

    if (res.ok) {
      register(lastname, firstname, email, password).then(
        (user) => {
          alert({
            title: "",
            message: "",
          });
          homeResult(user);
        },
        async (err) => {
          console.log(err.errors);

          if (err.errorCode == 422) {
            if (!err.errors || !err.errors.errors) {
              alert({
                title: await localize("message.title.HTTP_500"),
                message: localize("message.error.not_registered", true),
              });
            } else {
              let msg = "";
              let errs = err.errors.errors;
              for (let field of Object.keys(errs)) {
                msg += `${field}:\n  ${errs[field][0]}\n\n`;
              }
              alert({
                title: await localize("message.title.err_validation"),
                message: msg,
              });
            }
          } else {
            const codeHttp: number = err.errors.status;
            if (codeHttp === 409) {
              errMessage.email = "this email has exited";
            } else {
              alert({
                title: await localize("message.title.HTTP_" + codeHttp),
                message: err.errors.detail,
              });
            }
          }
          isLoading = false;
        },
      );
    } else {
      errMessage = (await res.err) as ErrRegister;
      isLoading = false;
    }
  }

  function login(): void {
    navigate({ page: Login, clearHistory: true });
  }

  function homeResult(result: any): void {
    isLoading = true;
    navigate({ page: Login, clearHistory: true });
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
        <stackLayout verticalAlignment="middle">
          <label
            text={localize("form.registration", true)}
            class="title"
            horizontalAlignment="center"
          />

          <stackLayout class="input-field">
            <textField
              bind:this={firstname_edit}
              on:textChange={(event) => {
                firstname = event.value;
              }}
              hint={localize("user.firstname")}
              class="input"
              autocapitalizationType="none"
              returnKeyType="next"
              editable={!isLoading}
            />
            <!-- on:returnPress={() => lastname_edit.nativeView.focus($event)} -->
            {#if errMessage?.firstname}
              <stackLayout class="error">
                <label text={errMessage?.firstname} />
              </stackLayout>
              <stackLayout class="hr-light" />
            {/if}
          </stackLayout>

          <stackLayout class="input-field m-t-10">
            <textField
              bind:this={lastname_edit}
              on:textChange={(event) => {
                lastname = event.value;
              }}
              hint={localize("user.lastname")}
              class="input"
              autocapitalizationType="none"
              returnKeyType="next"
              editable={!isLoading}
            />
            <!-- on:returnPress={() => email_edit.nativeView.focus()} -->
            {#if errMessage?.lastname}
              <stackLayout class="error">
                <label text={errMessage?.lastname} />
              </stackLayout>
              <stackLayout class="hr-light" />
            {/if}
          </stackLayout>

          <stackLayout class="input-field m-t-10">
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
            {#if errMessage?.email}
              <stackLayout class="error">
                <label text={errMessage?.email} />
              </stackLayout>
              <stackLayout class="hr-light" />
            {/if}
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
            <!-- on:returnPress={() => password_repeat_edit.nativeView.focus()} -->
            {#if errMessage?.password}
              <stackLayout class="error">
                <label text={errMessage?.password} />
              </stackLayout>
              <stackLayout class="hr-light" />
            {/if}
          </stackLayout>

          <stackLayout class="input-field">
            <textField
              bind:this={password_repeat_edit}
              on:textChange={(event) => {
                password_repeat = event.value;
              }}
              hint={localize("user.password_repeat")}
              class="input"
              secure="true"
              returnKeyType="done"
              editable={!isLoading}
            />
            <!-- on:returnPress={doRegister} -->
            {#if errMessage?.password_repeat}
              <stackLayout class="error">
                <label text={errMessage?.password_repeat} />
              </stackLayout>
              <stackLayout class="hr-light" />
            {/if}
          </stackLayout>
          <button
            text={icons.check}
            on:tap={doRegister}
            class="btn round icon check enabled"
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
          on:tap={login}
          horizontalAlignment="center"
        >
          <formattedString>
            <span text={localize("form.as_account", true)} />
            <span text=" {localize('form.login', true)}" class="bold" />
          </formattedString>
        </label>
      </stackLayout>
    </scrollView>
  </dockLayout>
</page>
