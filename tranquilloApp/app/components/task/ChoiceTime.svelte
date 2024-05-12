<script lang="ts">
  import { Template } from "svelte-native/components";
  import { listReminder } from "./ListReminder";
  import { closeModal } from "svelte-native";

  let listOfItems: string[] = listReminder.arrayList();
  let listOfItemsMinutes: number[] = listReminder.arrayMin();
  const onItemTap = (e: any) => {
    closeModal({ s: listOfItems[e.index], n: listOfItemsMinutes[e.index] });
  };
</script>

<frame id="detail-page-frame">
  <page>
    <actionBar title="" height="0" />
    <!-- <label text="Reminder" /> -->
    <listView items={listOfItems} on:itemTap={onItemTap}>
      <Template let:item>
        <label text={item} />
      </Template>
    </listView>
  </page></frame
>

<style lang="scss">
  $height: 40;
  $nbLigne: 15;
  $paddingLine: 5;
  frame {
    height: calc(15 + calc($height * $nbLigne));
  }

  label {
    font-size: 17;
    padding: $paddingLine 10;
    height: $height;
    color: hsl(221, 89%, 14%);
  }
</style>
