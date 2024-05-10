<script lang="ts">
  import { confirm } from "@nativescript/core/ui/dialogs";
  import { goBack, navigate } from "svelte-native";
  import { format } from "timeago.js";
  import BackButton from "./BackButton.svelte";
  import { localize } from "~/lib/packages/localize";
  import { printR } from "~/lib/packages/functions";
  import { Task } from "~/models/task";
  import { TaskStore } from "~/stores/task";
  import { get, writable } from "svelte/store";
  import { user_token } from "~/stores/user";
  import { getWritable } from "~/lib/packages/getWritable";

  export let task: Task;
  export let userToken = get(user_token);
  export const isEdit = writable<Boolean>(false);

  let isLoading = false;

  let task_description_edit: any;

  let name: string = "",
    description: string = "",
    reminder: number = 0,
    startAt: string = "",
    endAt: string = "";

  let name_edit: any,
    description_edit: any,
    reminder_edit: any,
    startAt_edit: any,
    endAt_edit: any;

  let task_date: string, task_name: string;

  $: task_name = task.name ?? "";
  $: task_date = task.createAt ? format(task.createAt, "fr_FR") : "";

  function onTapEdit() {
    isEdit.set(true);
    // name_edit.focus();
  }

  function onTapNavigValidate(): void {
    isEdit.set(false);
  }
  function onTapNavigCancel(): void {
    isEdit.set(false);
  }
  function onTapDelete() {
    isLoading = true;
    confirm({
      title: localize("message.title.delete_task", true),
      message: printR(localize("message.confirm_delete"), task_name),
      okButtonText: localize("global.yes", true),
      cancelButtonText: localize("global.no", true),
    }).then(async (res) => {
      if (res) {
        let items = new TaskStore();
        let result: number =
          (await items.deleteTask(task.id || 0, userToken)) ?? 0;
        if (result == 202) {
          goBack();
        }
      }
    });
    isLoading = false;
  }
</script>

<page>
  <actionBar title="">
    <stackLayout orientation="horizontal" horizontalAlignment="left">
      <BackButton />
      <!-- <image class="author-image" src={avatar_url} stretch="aspectFill" /> -->
      <stackLayout orientation="vertical">
        <label text={task_name} class="author-name" />
        <label text={task_date} class="date" />
        <!-- <label text={task.usersId} class="" /> -->
      </stackLayout>
    </stackLayout>
    <actionItem
      on:tap={onTapEdit}
      ios.systemIcon="9"
      ios.position="left"
      android.systemIcon="ic_menu_share"
      android.position="popup"
      text="🖋️ {localize('button.edit')}"
      class="icon edit action-icon"
    />
    <actionItem
      on:tap={onTapDelete}
      ios.systemIcon="16"
      ios.position="right"
      android.position="popup"
      text="🗑️ {localize('button.delete')}"
      class="icon edit action-icon"
    />
  </actionBar>
  <stackLayout>
    <scrollView>
      <stackLayout class="task-content">
        {#if $isEdit}
          <stackLayout class="form">
            <textView
              bind:this={name_edit}
              on:textChange={(event) => {
                name = event.value;
              }}
              hint={localize("task.name")}
              text={task.name}
              class="task-name input"
              autocapitalizationType="none"
              returnKeyType="next"
              editable={!isLoading}
            />
            <textView
              bind:this={description_edit}
              on:textChange={(event) => {
                name = event.value;
              }}
              hint={localize("task.description")}
              text={task.description}
              class="task-body input"
              autocapitalizationType="none"
              returnKeyType="next"
              editable={!isLoading}
            />
            <flexboxLayout justifyContent="space-around">
              <button
                text={localize("button.validate", true)}
                on:tap={onTapNavigValidate}
                class="btn submit validate"
                isEnabled={!isLoading}
              />
              <button
                text={localize("button.cancel", true)}
                on:tap={onTapNavigCancel}
                class="btn cancel"
                isEnabled={!isLoading}
              />
            </flexboxLayout>
          </stackLayout>
        {:else}
          <label text={task.name} class="task-name" textWrap="true" />
          <label text={task.description} class="task-body" textWrap="true" />
        {/if}
        <stackLayout class="hr-light" />
      </stackLayout>
    </scrollView>
  </stackLayout>
</page>

<style lang="scss">
  .action-icon {
    font-size: 20;
    padding: 5 15;
    height: 100%;
  }
  .date {
    font-size: 10;
  }
  .input {
    white-space: normal;
    width: 100%;
  }
  .task-content {
    padding: 20 10;
  }

  .task-name {
    font-size: 20;
    color: black;
    font-weight: bold;
    margin-bottom: 20;
  }
  .task-body {
    font-size: 15;
    margin-bottom: 20;
  }
</style>
