<script lang="ts">
  import { getWritable } from "~/lib/packages/getWritable";
  isPage.set("register");

  import { alert } from "@nativescript/core/ui/dialogs";
  import { onMount } from "svelte";
  import { navigate } from "svelte-native";
  import Login from "~/components/user/Login.svelte";
  import ActionBar from "~/layout/ActionBar.svelte";
  import Menu from "~/layout/Menu.svelte";
  import { localize } from "~/lib/packages/localize";
  import { isPage } from "~/lib/packages/variables";
  import { user_profile, register } from "~/stores/user";
  import { control } from "../../lib/packages/control";
  import { ErrRegister, ErrRespRegister } from "~/models/user";
  import { writable } from "svelte/store";

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

  const errMessage = writable<ErrRegister>();

  onMount(async () => {
    lastnameL = await localize("user.lastname");
    firstnameL = await localize("user.firstname");
    emailL = await localize("user.email");
    passwordL = await localize("user.password");
    passwordRepeatL = await localize("user.password_repeat");
    asAccountL = await localize("form.as_account", true);
    notRegisteredL = await localize("message.not_registered", true);
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
    // console.log("Register1  : " + Object.keys(res.err ?? ""));
    // console.log("Register2 : " + Object.values(res.err ?? ""));
    // console.log("Register3  : " + res.ok);
    if (await res.ok) {
      register(lastname, firstname, email, password).then(
        (user) => homeResult(user),
        (err) => {
          if (err.errorCode == 422) {
            if (!err.errors || !err.errors.errors) {
              alert(notRegisteredL);
            } else {
              let msg = "";
              let errs = err.errors.errors;
              for (let field of Object.keys(errs)) {
                msg += `${field}:\n  ${errs[field][0]}\n\n`;
              }
              alert({
                title: "Validation Problem",
                message: msg,
              });
            }
          } else {
            alert(err.message);
          }
          isLoading = false;
        },
      );
    } else {
      // errMessage.set(res.err as ErrRegister);
      // console.log("RegisterWritable : " + getWritable(errMessage));

      // alert(notRegisteredL);
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
  <stackLayout>
    <Menu />

    <stackLayout row="1" class="form" verticalAlignment="center">
      <label text={registrationL} class="title" horizontalAlignment="center" />

      <stackLayout class="input-field m-t-10">
        <textField
          bind:this={firstname_edit}
          on:textChange={handleFirstnameChange}
          hint={firstnameL}
          class="input"
          autocapitalizationType="none"
          returnKeyType="next"
          on:returnPress={() => email_edit.nativeView.focus()}
          editable={!isLoading}
        />
        {#if $errMessage?.firstname}
          <stackLayout class="error">
            <span text={$errMessage?.firstname} />
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
          on:returnPress={() => firstname_edit.nativeView.focus()}
          editable={!isLoading}
        />
        {#if $errMessage?.lastname}
          <stackLayout class="error">
            <span text={$errMessage?.lastname} />
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
        {#if $errMessage?.email}
          <stackLayout class="error">
            <span text={$errMessage?.email} />
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
        {#if $errMessage?.password}
          <stackLayout class="error">
            <span text={$errMessage?.password} />
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
        {#if $errMessage?.password_repeat}
          <stackLayout class="error">
            <span text={$errMessage?.password_repeat} />
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
      class="login-label"
      on:tap={login}
      horizontalAlignment="center"
    >
      <formattedString>
        <span text={asAccountL} />
        <span text=" {loginL}" class="bold" />
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
  //   .sign-up-label {
  //     font-size: 15;
  //     padding: 10;
  //   }

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
    padding: 0;
    & > span {
      padding: 2;
    }
  }
</style>
