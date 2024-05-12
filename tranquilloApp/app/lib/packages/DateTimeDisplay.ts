import { DateTime } from "~/models/profile";

class DateTimeDisplay {
  constructor() {}

  public date(dateVal?: Date, nowVal: boolean = false): string {
    const result = dateVal ? this.convertDateTime(dateVal).date : "";
    return result || (nowVal ? this.getCurrentDateTime().date : "");
  }
  public time(dateVal?: Date, nowVal: boolean = false): string {
    const result = dateVal ? this.convertDateTime(dateVal).time : "";
    return result || (nowVal ? this.getCurrentDateTime().time : "");
  }

  public datetime(dateVal?: Date | null, nowVal: boolean = false): Date {
    return nowVal
      ? this.getCurrentDateTime().datetime
      : this.convertDateTime(dateVal ?? null).datetime;
  }

  private convertDateTime(dateTimeT: Date | null): DateTime {
    if (dateTimeT) {
      const dateTime = new Date(dateTimeT);
      const day = String(dateTime.getDate()).padStart(2, "0");
      const month = String(dateTime.getMonth() + 1).padStart(2, "0");
      const year = dateTime.getFullYear();
      const hours = String(dateTime.getHours()).padStart(2, "0");
      const minutes = String(dateTime.getMinutes()).padStart(2, "0");
      const seconds = String(dateTime.getSeconds()).padStart(2, "0");
      const date = `${day}/${month}/${year}`;
      const time = `${hours}:${minutes}`;

      return { date, time, datetime: dateTime };
    }
    return { date: "", time: "", datetime: new Date() };
  }

  private getCurrentDateTime(): DateTime {
    const dateTime = new Date();
    const day = String(dateTime.getDate()).padStart(2, "0");
    const month = String(dateTime.getMonth() + 1).padStart(2, "0");
    const year = dateTime.getFullYear();
    const hours = String(dateTime.getHours()).padStart(2, "0");
    const minutes = String(dateTime.getMinutes()).padStart(2, "0");
    const seconds = String(dateTime.getSeconds()).padStart(2, "0");
    const date = `${day}/${month}/${year}`;
    const time = `${hours}:${minutes}`;

    return { date, time, datetime: dateTime };
  }
}

export let dtDisplay = new DateTimeDisplay();
