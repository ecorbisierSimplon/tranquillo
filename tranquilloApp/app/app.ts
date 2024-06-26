/*
In NativeScript, the app.ts file is the entry point to your application.
You can use this file to perform app-level initialization, but the primary
purpose of the file is to pass control to the app’s first page.
*/

import { svelteNative } from "svelte-native";
import App from "./App.svelte";
import { registerNativeViewElement } from "svelte-native/dom";
import {
  DateTimePickerFields,
  TimePickerField,
  DatePickerField,
} from "@nativescript/datetimepicker";

registerNativeViewElement("dateTimePickerFields", () => DateTimePickerFields);
registerNativeViewElement("datePickerField", () => DatePickerField);
registerNativeViewElement("timePickerField", () => TimePickerField);

svelteNative(App, {});
