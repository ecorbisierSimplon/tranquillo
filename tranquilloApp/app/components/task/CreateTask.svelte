<script lang="ts">
  import ChoiceTime from "./ChoiceTime.svelte";
  import Home from "~/components/Home.svelte";
  import { navigate, showModal } from "svelte-native";
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

  export let userToken = get(user_token);
  export const reminderIndex = writable<string>("aucun");
  let isLoading = false;
  let disabled: string = "";

  let errMessage: ErrTask = {};

  let name: string = "",
    description: string = "",
    reminder: number = 0,
    startAt: Date | undefined | null = null,
    endAt: Date | undefined | null = null,
    createAt: Date | undefined | null = null;

  let name_edit: any,
    description_edit: any,
    reminder_edit: any,
    startAt_edit: DateTimePickerFields,
    endAt_edit: any;

  let task_date: string, task_name: string;

  $: task_name = "Create new task";

  async function launchModal() {
    let result: { s: string; n: number } = await showModal({
      page: ChoiceTime,
    });
    reminder = await result.n;
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
        taskStore
          .createTask(
            { name, description, reminder, startAt, endAt },
            userToken,
          )
          .then(
            () => {
              onTapNavigCancel();
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
    navigate({ page: Home, clearHistory: true });
  }
</script>

<page>
  <actionBar title="">
    <stackLayout orientation="horizontal" horizontalAlignment="left">
      <label
        text={icons["arrow_left"]}
        class="icon back-button"
        verticalAlignment="middle"
        horizontalAlignment="left"
        on:tap={onTapNavigCancel}
      />

      <stackLayout orientation="vertical">
        <label text={task_name} class="author-name" />
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
              text={name}
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
              text={description}
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
              pickerDefaultDate={dtDisplay.datetime(startAt)}
              date={startAt}
              autoPickTime="true"
              is24Hours="true"
            ></dateTimePickerFields>
            <label
              class="label-icon icon close-circle"
              text={icons.close_circle}
              on:tap={() => {
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
              pickerDefaultDate={dtDisplay.datetime(endAt)}
              date={endAt}
              minDate={startAt}
              autoPickTime="true"
              title="date de fin "
              is24Hours="true"
            ></dateTimePickerFields>
            <label
              class="label-icon icon close-circle"
              text={icons.close_circle}
              on:tap={() => {
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
              text={listReminder.convertToDHM(reminder ?? 0)}
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

  .error {
    margin-top: -30;
    margin-left: 45;
  }
</style>
