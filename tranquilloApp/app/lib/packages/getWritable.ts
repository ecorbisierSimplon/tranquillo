import { writable, type Writable } from "svelte/store";

export type GetWritable = any;

export function getWritable(value: Writable<GetWritable>): GetWritable {
  let result: GetWritable = "";
  value.subscribe((val) => {
    result = val;
  });
  return result;
}
