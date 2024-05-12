import { printR } from "~/lib/packages/functions";
import { localize } from "~/lib/packages/localize";

class ListReminder {
  private min: number[] = [];
  private hour: number[] = [];
  private day: number[] = [];
  constructor() {
    this.min = [1, 2, 5, 10, 15, 20, 15, 45];
    this.hour = [1, 2, 3, 12];
    this.day = [1, 2];
  }

  public arrayList(): string[] {
    const list: string[] = [];

    list.push(localize("none"));

    this.min.forEach((value) => {
      list.push(
        `${value} ${printR(
          localize("minutes"),
          value > 1 ? "s" : ""
        )} ${localize("previously")}`
      );
    });

    // Ajouter les heures à la liste
    this.hour.forEach((value) => {
      list.push(
        `${value} ${printR(localize("hours"), value > 1 ? "s" : "")} ${localize(
          "previously"
        )}`
      );
    });

    // Ajouter les jours à la liste
    this.day.forEach((value) => {
      list.push(
        `${value} ${printR(localize("days"), value > 1 ? "s" : "")} ${localize(
          "previously"
        )}`
      );
    });

    return list;
  }

  public arrayMin(): number[] {
    const list: number[] = [];

    list.push(0);
    this.min.forEach((value) => {
      list.push(value);
    });

    // Ajouter les heures à la liste
    this.hour.forEach((value) => {
      list.push(value * 60);
    });

    // Ajouter les jours à la liste
    this.day.forEach((value) => {
      list.push(value * 60 * 24);
    });

    return list;
  }

  public convertToDHM(totalMinutes: number): string {
    const days = Math.floor(totalMinutes / (60 * 24));
    const hours = Math.floor((totalMinutes % (60 * 24)) / 60);
    const minutes = totalMinutes % 60;

    let result = "";
    if (days > 0) {
      result += `${days} ${printR(localize("days"), days > 1 ? "s" : "")}`;
    }
    if (hours > 0) {
      result += `${days > 0 ? " " : ""}${hours} ${printR(
        localize("hours"),
        hours > 1 ? "s" : ""
      )}`;
    }
    if (minutes > 0) {
      result += `${days > 0 || hours > 0 ? " " : ""}${minutes} ${printR(
        localize("minutes"),
        minutes > 1 ? "s" : ""
      )}`;
    }
    return (
      result.trim() +
      (result.trim() != "" ? " " + localize("previously") : localize("none"))
    );
  }
}

export let listReminder = new ListReminder();
