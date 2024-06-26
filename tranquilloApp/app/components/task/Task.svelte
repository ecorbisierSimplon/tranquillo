<script lang="ts">
  import ChoiceTime from "./ChoiceTime.svelte";
  import { confirm } from "@nativescript/core/ui/dialogs";
  import { goBack, showModal } from "svelte-native";
  import { format } from "timeago.js";
  import BackButton from "./BackButton.svelte";
  import { localize } from "~/lib/packages/localize";
  import { printR } from "~/lib/packages/functions";
  import { ErrRespTask, ErrTask, Task } from "~/models/task";
  import { taskStore } from "~/stores/task";
  import { get, writable } from "svelte/store";
  import { user_token } from "~/stores/user";
  import { icons } from "~/utils/icons";
  import { control } from "~/lib/packages/control";
  import { dtDisplay } from "~/lib/packages/DateTimeDisplay";
  import { DateTimePickerFields } from "@nativescript/datetimepicker";
  import { listReminder } from "./ListReminder";

  export let task: Task;
  export let userToken = get(user_token);
  export const reminderIndex = writable<string>("aucun");
  let isLoading = false;
  let disabled: string = "";

  let errMessage: ErrTask = {};

  let name: string = task.name ?? "",
    description: string = task.description ?? "",
    reminder: number = task.reminder ?? 0,
    startAt: Date | undefined | null = task.startAt,
    endAt: Date | undefined | null = task.endAt;

  let name_edit: any,
    description_edit: any,
    reminder_edit: any,
    startAt_edit: DateTimePickerFields,
    endAt_edit: any;

  let task_date: string, task_name: string;

  $: task_name = task.name ?? "";
  $: task_date = task.createAt ? format(task.createAt, "fr_FR") : "";

  async function launchModal() {
    let result: { s: string; n: number } = await showModal({
      page: ChoiceTime,
    });
    reminder = await result.n;
    task.reminder = await result.n;
  }

  async function onTapNavigValidate(): Promise<void> {
    if (disabled === "") {
      isLoading = true;
      disabled = "disabled";

      startAt = startAt ? dtDisplay.datetime(startAt) : null;
      endAt = endAt ? dtDisplay.datetime(endAt) : null;

      const res: ErrRespTask = await control.task({
        name,
        description,
        reminder,
        startAt,
        endAt,
      });

      if (res.ok) {
        const id: number = task.id ?? 0;
        taskStore
          .updateTask(
            { id, name, description, reminder, startAt, endAt },
            userToken,
          )
          .then(
            () => {
              goBack();
            },
            async (err) => {
              console.log(err.errors);
              if (err.errorCode == 422) {
                if (!err.errors || !err.errors.errors) {
                  alert({
                    title: localize("message.title.HTTP_500"),
                    message: localize("message.error.not_registered", true),
                  });
                } else {
                  let msg = "";
                  let errs = err.errors.errors;
                  for (let field of Object.keys(errs)) {
                    msg += `${field}:\n  ${errs[field][0]}\n\n`;
                  }
                  alert({
                    title: localize("message.title.err_validation"),
                    message: msg,
                  });
                }
              } else {
                const codeHttp: number = err.errors.status;
                if (codeHttp === 409) {
                  // errMessage.email = "this email has exited";
                } else {
                  alert({
                    title: localize("message.title.HTTP_" + codeHttp),
                    message: err.errors.detail,
                  });
                }
              }
              isLoading = false;
              disabled = "";
            },
          );
      } else {
        errMessage = (await res.err) as ErrTask;
      }
      isLoading = false;
      disabled = "";
    }
  }

  function onTapNavigCancel(): void {
    goBack();
  }

  function onTapDelete() {
    isLoading = true;
    disabled = "disabled";
    confirm({
      title: localize("message.title.delete_task", true),
      message: printR(localize("message.confirm_delete"), task_name),
      okButtonText: localize("yes", true),
      cancelButtonText: localize("no", true),
    }).then(async (res) => {
      if (res) {
        let result: number =
          (await taskStore.deleteTask(task.id || 0, userToken)) ?? 0;

        goBack();
      }
    });
    isLoading = false;
    disabled = "";
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
  </actionBar>

  <stackLayout>
    <scrollView>
      <stackLayout class="task-content">
        <stackLayout class="form">
          <stackLayout orientation="horizontal">
            <label
              class="label-icon icon calendar-alt"
              text={icons.calendar_alt}
            />
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
          </stackLayout>
          {#if errMessage?.name}
            <stackLayout class="error">
              <label text={errMessage?.name} />
            </stackLayout>
          {/if}
          <stackLayout orientation="horizontal">
            <label
              class="label-icon icon format-align-left"
              text={icons.format_align_left}
            />
            <textView
              bind:this={description_edit}
              on:textChange={(event) => {
                description = event.value;
              }}
              hint={localize("task.description")}
              text={task.description}
              class="task-body input"
              autocapitalizationType="none"
              returnKeyType="next"
              editable={!isLoading}
            />
          </stackLayout>
          {#if errMessage?.description}
            <stackLayout class="error">
              <label text={errMessage?.description} />
            </stackLayout>
          {/if}
          <stackLayout orientation="horizontal">
            <label
              class="label-icon icon time-interval"
              text={icons.time_interval}
            />
            <label text={localize("task.delay", true)} />
          </stackLayout>
          <stackLayout class="hr hr-tick" />
          <stackLayout orientation="horizontal">
            <label class="label-icon icon alarm-plus" text={icons.alarm_plus} />
            <dateTimePickerFields
              bind:this={startAt_edit}
              on:dateChange={(event) => {
                startAt = event.value;
              }}
              locale="fr_FR"
              hintDate={localize("task.start_date")}
              hintTime={localize("task.start_time")}
              pickerOkText={localize("dialog.approve")}
              pickerCancelText={localize("dialog.reject")}
              pickerTitleDate={printR(
                localize("dialog.confirm_select"),
                localize("date"),
              )}
              pickerTitleTime={printR(
                localize("dialog.confirm_select"),
                localize("time"),
              )}
              pickerDefaultDate={dtDisplay.datetime(task.startAt)}
              date={task.startAt}
              autoPickTime="true"
              is24Hours="true"
            ></dateTimePickerFields>
            <label
              class="label-icon icon close-circle"
              text={icons.close_circle}
              on:tap={() => {
                task.startAt = null;
                startAt = null;
              }}
            />
          </stackLayout>
          {#if errMessage?.startAt}
            <stackLayout class="error">
              <label text={errMessage?.startAt} />
            </stackLayout>
          {/if}

          <stackLayout orientation="horizontal">
            <label class="label-icon icon alarm-off" text={icons.alarm_off} />
            <dateTimePickerFields
              bind:this={endAt_edit}
              on:dateChange={(event) => {
                endAt = event.value;
              }}
              locale="fr_FR"
              hintDate={localize("task.end_date")}
              hintTime={localize("task.end_time")}
              pickerOkText={localize("dialog.approve")}
              pickerCancelText={localize("dialog.reject")}
              pickerTitleDate={printR(
                localize("dialog.confirm_select"),
                localize("date"),
              )}
              pickerTitleTime={printR(
                localize("dialog.confirm_select"),
                localize("time"),
              )}
              pickerDefaultDate={dtDisplay.datetime(task.endAt)}
              date={task.endAt}
              minDate={startAt}
              minTime={startAt}
              autoPickTime="true"
              title="date de fin "
              is24Hours="true"
            ></dateTimePickerFields>
            <label
              class="label-icon icon close-circle"
              text={icons.close_circle}
              on:tap={() => {
                task.endAt = null;
                endAt = null;
              }}
            />
          </stackLayout>
          {#if errMessage?.endAt}
            <stackLayout class="error">
              <label text={errMessage?.endAt} />
            </stackLayout>
          {/if}
          <stackLayout class="hr hr-light" />
          <timePickerField height="0" />
          <stackLayout orientation="horizontal">
            <label
              class="label-icon icon alarm-snooze"
              text={icons.alarm_snooze}
            />
            <label
              text={listReminder.convertToDHM(task.reminder ?? 0)}
              on:tap={launchModal}
            />
          </stackLayout>
          {#if errMessage?.reminder}
            <stackLayout class="error">
              <label text={errMessage?.reminder} />
            </stackLayout>
          {/if}
          <stackLayout class="hr hr-light" />
          <flexboxLayout justifyContent="space-around">
            <label
              text={icons.check}
              on:tap={onTapNavigValidate}
              class="btn round icon check {disabled}"
              isEnabled={!isLoading}
            />
            <label
              text={icons.sign_in}
              on:tap={onTapNavigCancel}
              class="btn round icon sign-in {disabled}"
              isEnabled={!isLoading}
            />
            <label
              on:tap={onTapDelete}
              text={icons.delete}
              class="btn round icon delete {disabled}"
              isEnabled={!isLoading}
            />
          </flexboxLayout>
        </stackLayout>

        <stackLayout class="hr-light" />
        <activityIndicator
          busy={isLoading}
          horizontalAlignment="center"
          verticalAlignment="middle"
          class="activity-indicator"
        />
      </stackLayout>
    </scrollView>
  </stackLayout>
</page>

<style lang="scss">
  dateTimePickerFields {
    font-size: 15;
    text-align: center;
    width: 250;
  }

  .label {
    &-icon {
      width: 40;
      text-align: center;
    }
  }
  .date {
    font-size: 10;
  }
  .input {
    white-space: normal;
    width: 100%;
  }
  .task {
    &-content {
      padding: 20 10;
    }

    &-name {
      font-size: 20;
      color: black;
      font-weight: bold;
      margin-bottom: 20;
    }
    &-body {
      font-size: 15;
      margin-bottom: 20;
    }
  }
  .hr {
    background-color: hsla(45, 67%, 71%, 0.582);
    &-light {
      margin: 20 0 10 0;
      height: 1.5;
    }
    &-tick {
      margin-bottom: 10;
    }
  }
</style>
