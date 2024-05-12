<script lang="ts">
  import { Template } from "svelte-native/components";
  import { navigate } from "svelte-native";
  import { onMount } from "svelte";

  import Task from "./Task.svelte";
  import { icons } from "~/utils/icons";
  import { taskStore } from "~/stores/task";
  import { localize } from "~/lib/packages/localize";
  import { user_token } from "~/stores/user";
  import { get } from "svelte/store";
  import { ItemEventData } from "@nativescript/core";

  export let userToken = get(user_token);
  let loading = false;

  $: {
    taskStore.loadTasks(userToken);
    loading = true;
  }

  let list_items: Task[] = [];
  $: {
    list_items = $taskStore;
    loading = false;
  }

  function openTask(e: ItemEventData) {
    let task: Task = list_items[e.index] as Task;
    navigate({ page: Task, props: { task } });
  }
</script>

<stackLayout>
  {#if list_items.length}
    <listView
      items={list_items}
      height="100%"
      width="100%"
      on:loadMoreItems={() => taskStore.loadNextPage()}
      on:itemTap={openTask}
    >
      <Template let:item>
        <stackLayout orientation="vertical" class="task-item">
          <label text={item.name} class="task-name" textWrap="true" />
          <label text={item.description} class="task-desc" textWrap="false" />
          {#if item.tagList && item.tagList.length > 0}
            <wrapLayout
              orientation="horizontal"
              class="tags"
              horizontalAlignment="left"
            >
              {#each item.tagList as tag, i}
                <label text={tag} class="task-tag" />
              {/each}
            </wrapLayout>
          {/if}
        </stackLayout>
      </Template>
    </listView>
  {:else}
    <label horizontalAlignment="center" class="no-tasks"
      >{localize("task.no_task", true)}</label
    >
  {/if}
</stackLayout>

<style>
  .no-tasks {
    font-size: 15;
    padding: 20;
  }
  .task-item {
    padding: 15;
  }
  .task-name {
    font-size: 18;
    font-weight: bold;
    color: black;
  }
  .task-desc {
    font-size: 16;
  }

  .tags {
    margin-bottom: 0;
    margin-top: 15;
  }
  .task-tag {
    color: #aaa;
    font-size: 11;
    padding: 1 7;
    margin-right: 2;
    border-radius: 10;
    border-color: #ccc;
    border-width: 1;
  }
</style>
