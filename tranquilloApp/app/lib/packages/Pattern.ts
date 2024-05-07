import { printR } from "./functions";
import { localize } from "./localize";

class ValidateForm {
  // formValidations.ts

  public async field(value: string, fieldName: string): Promise<string | null> {
    const namePattern: RegExp =
      /^[a-zA-ZÀ-ÖØ-öø-ÿ]+(?:[-\s_a-zA-ZÀ-ÖØ-öø-ÿ]+)[a-zA-ZÀ-ÖØ-öø-ÿ]+$/;
    if (!namePattern.test(value.trim())) {
      return printR(await localize("pattern.name"), fieldName);
    }
    return null;
  }

  public async email(email: string): Promise<string | null> {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.trim())) {
      return await localize("pattern.email");
    }
    return null;
  }

  public async password(password: string): Promise<string | null> {
    const passPattern =
      /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%.^&:§+=!])(?!.*[ç<\">\'µ`~\\\/]).{0,}$/;
    if (password.trim().length < 8) {
      return await localize("pattern.password.length");
    }
    if (!passPattern.test(password.trim())) {
      return await localize("pattern.password.force");
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
      return await localize("pattern.password.repeat");
    }
    return null;
  }
}

export const validateForm = new ValidateForm();
