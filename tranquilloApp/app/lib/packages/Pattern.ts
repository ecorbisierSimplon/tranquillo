import { getType, printR } from "./functions";
import { localize } from "./localize";

class ValidateForm {
  // formValidations.ts

  public async field(value: string, fieldName: string): Promise<string | null> {
    const namePattern: RegExp =
      /^[a-zA-ZÀ-ÖØ-öø-ÿ]+(?:[-\s_a-zA-ZÀ-ÖØ-öø-ÿ]+)[a-zA-ZÀ-ÖØ-öø-ÿ]+$/;
    if (!namePattern.test(value.trim())) {
      return printR(localize("pattern.name"), fieldName);
    }
    return null;
  }

  public async email(email: string): Promise<string | null> {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.trim())) {
      return localize("pattern.email");
    }
    return null;
  }

  public async password(password: string): Promise<string | null> {
    const passPattern =
      /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%.^&:§+=!])(?!.*[ç<\">\'µ`~\\\/]).{0,}$/;
    if (password.trim().length < 8) {
      return localize("pattern.password.length");
    }
    if (!passPattern.test(password.trim())) {
      return localize("pattern.password.force");
    }
    return null;
  }
  // (?=.*[a-z]) : Au moins une lettre minuscule.
  // (?=.*[A-Z]) : Au moins une lettre majuscule.
  // (?=.*\d) : Au moins un chiffre.
  // (?=.*[@#$%^&+=!]) : Au moins un caractère spécial parmi ceux indiqués.
  // .{8,} : Au moins 8 caractères au total.

  public async confirmPassword(
    password: string,
    confirmPassword: string
  ): Promise<string | null> {
    if (password !== confirmPassword) {
      return localize("pattern.password.repeat");
    }
    return null;
  }

  public async checkType(value: any, type: string): Promise<string | null> {
    // const date: boolean = type === "Date";
    // console.log(date);

    // if (!date && typeof value != type) {
    //   return printR(localize("pattern.type"), type) + " : " + getType(value);
    // }
    // if (date && !(value instanceof Date)) {
    //   return printR(localize("pattern.type"), type) + " : " + getType(value);
    // }
    return null;
  }
}

export const validateForm = new ValidateForm();
