<script lang="ts">
  import { ErrorResponse } from "./../../models/user.ts";
  isPage.set("register");

  import Login from "~/components/user/Login.svelte";
  import ActionBar from "~/layout/ActionBar.svelte";
  import Menu from "~/layout/Menu.svelte";
  import { alert } from "@nativescript/core/ui/dialogs";
  import { onMount } from "svelte";
  import { navigate } from "svelte-native";
  import { writable } from "svelte/store";
  import { user_profile, register } from "~/stores/user";
  import { localize } from "~/lib/packages/localize";
  import { isPage } from "~/lib/packages/variables";
  import { ErrRegister, ErrRespRegister } from "~/models/user";
  import { control } from "../../lib/packages/control";
  import { getWritable } from "~/lib/packages/getWritable";

  let errMessage: ErrRegister = {};

  // export let msg;
  let isLoading = false,
    lastname: string = "",
    firstname: string = "",
    email: string = "",
    password: string = "",
    password_repeat: string = "",
    lastname_edit: string = "",
    firstname_edit: string = "",
    email_edit: string = "",
    password_edit: string = "",
    password_repeat_edit: string = "",
    emailL: string = "",
    firstnameL: string = "",
    lastnameL: string = "",
    passwordL: string = "",
    passwordRepeatL: string = "",
    asAccountL: string = "",
    notRegisteredL: string = "",
    registerL: string = "",
    registrationL: string = "",
    loginL: string = "";

  onMount(async () => {
    lastnameL = await localize("user.lastname");
    firstnameL = await localize("user.firstname");
    emailL = await localize("user.email");
    passwordL = await localize("user.password");
    passwordRepeatL = await localize("user.password_repeat");
    asAccountL = await localize("form.as_account", true);
    notRegisteredL = await localize("message.error.not_registered", true);
    registerL = await localize("form.register", true);
    registrationL = await localize("form.registration", true);
    loginL = await localize("form.login", true);
  });

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
                message: notRegisteredL,
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

  function handleLastnameChange(event: { value: string }): void {
    lastname = event.value;
  }

  function handleFirstnameChange(event: { value: string }): void {
    firstname = event.value;
  }
  function handleEmailChange(event: { value: string }): void {
    email = event.value;
  }

  function handlePasswordChange(event: { value: string }): void {
    password = event.value;
  }

  function handlePasswordRepeatChange(event: { value: string }): void {
    password_repeat = event.value;
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
  <ActionBar />
  <dockLayout stretchLastChild="true">
    <stackLayout dock="bottom">
      <Menu />
    </stackLayout>
    <stackLayout>
      <stackLayout row="1" class="form" verticalAlignment="center">
        <label
          text={registrationL}
          class="title"
          horizontalAlignment="center"
        />

        <stackLayout class="input-field m-t-10">
          <textField
            bind:this={firstname_edit}
            on:textChange={handleFirstnameChange}
            hint={firstnameL}
            class="input"
            autocapitalizationType="none"
            returnKeyType="next"
            on:returnPress={() => lastname_edit.nativeView.focus()}
            editable={!isLoading}
          />
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
            on:textChange={handleLastnameChange}
            hint={lastnameL}
            class="input"
            autocapitalizationType="none"
            returnKeyType="next"
            on:returnPress={() => email_edit.nativeView.focus()}
            editable={!isLoading}
          />
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
            on:textChange={handlePasswordChange}
            hint={passwordL}
            class="input"
            secure="true"
            returnKeyType="done"
            on:returnPress={() => password_repeat_edit.nativeView.focus()}
            editable={!isLoading}
          />
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
            on:textChange={handlePasswordRepeatChange}
            hint={passwordRepeatL}
            class="input"
            secure="true"
            returnKeyType="done"
            on:returnPress={doRegister}
            editable={!isLoading}
          />
          {#if errMessage?.password_repeat}
            <stackLayout class="error">
              <label text={errMessage?.password_repeat} />
            </stackLayout>
            <stackLayout class="hr-light" />
          {/if}
        </stackLayout>
        <button
          text={registerL}
          on:tap={doRegister}
          class="btn m-t-20 submit"
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
        on:tap={login}
        horizontalAlignment="center"
      >
        <formattedString>
          <span text={asAccountL} />
          <span text=" {loginL}" class="bold" />
        </formattedString>
      </label>
    </stackLayout>
  </dockLayout>
</page>

<style lang="scss">
  .btn {
    background-color: rgb(11, 40, 121);
    color: white;
    font-size: 15;
    width: 280;
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
    margin: 0;
    padding: 0;
  }

  .bold {
    font-weight: bold;
    color: rgb(15, 61, 104);
  }

  .hr-light {
    background-color: rgb(181, 189, 218);
    height: 0.5;
    margin: 0;
    padding: 0;
  }
  .error {
    margin-top: -10;
    & > label {
      padding: 2;
      margin: 0;
      white-space: normal;
    }
  }
</style>
