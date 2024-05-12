import { DateTime } from "~/models/profile";

export function strUcFirst(a: string): string {
  return (a + "").charAt(0).toUpperCase() + (a + "").substr(1);
}

export function printR(message: string, ...fieldValues: string[]): string {
  let formattedMessage = message;
  for (let i = 0; i < fieldValues.length; i++) {
    formattedMessage = formattedMessage.replace(
      new RegExp(`\\$${i + 1}`, "g"),
      fieldValues[i]
    );
  }
  return formattedMessage;
}

export function getType(variable: any): string {
  if (typeof variable === "number") {
    return "number";
  } else if (typeof variable === "string") {
    return "string";
  } else if (typeof variable === "boolean") {
    return "boolean";
  } else if (typeof variable === "symbol") {
    return "symbol";
  } else if (typeof variable === "undefined") {
    return "undefined";
  } else if (typeof variable === "function") {
    return "function";
  } else if (variable instanceof Date) {
    return "Date";
  } else if (variable instanceof Array) {
    return "Array";
  } else if (variable instanceof Object) {
    return "object";
  } else {
    return "unknown";
  }
}
