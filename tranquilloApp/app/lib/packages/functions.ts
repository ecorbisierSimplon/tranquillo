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
