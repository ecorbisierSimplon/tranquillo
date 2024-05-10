import { getWritable } from "./getWritable";
import { isLang } from "./variables";
import { strUcFirst } from "./functions";
import { DeviceInfo } from "nativescript-dna-deviceinfo";

const lang: string = getWritable(isLang) as string;

console.log("Langue local : " + lang);
console.log("Adresse ip : " + DeviceInfo.wifiIpv4Address());

let local: (key: string, upperFirst?: boolean) => any;

import(`../../i18n/${lang}`)
  .then(({ i18n }) => {
    local = function (key: string, upperFirst: boolean = false): any {
      const keys = key.split(".");
      let value: any = i18n;

      for (const k of keys) {
        if (value.hasOwnProperty(k)) {
          value = value[k];
        } else {
          return undefined; // Clé non trouvée
        }
      }
      if (upperFirst) {
        value = strUcFirst(value);
      }
      return value;
    };
  })
  .catch((error) => {
    console.error("Erreur lors de l'importation du module i18n :", error);
  });

export function localize(key: string, upperFirst: boolean = false): string {
  if (typeof local === "function") {
    return local(key, upperFirst);
  }
  // Gérer le cas où la fonction local n'est pas encore définie
  console.error("La fonction 'local' n'est pas encore définie.");
  return "";
}
