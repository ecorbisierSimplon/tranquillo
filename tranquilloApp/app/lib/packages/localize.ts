import { getWritable } from "./getWritable";
import { isLang } from "./variables";
import { strUcFirst } from "./functions";
import { DeviceInfo } from "nativescript-dna-deviceinfo";
// Récupérer la langue actuelle
const lang: string = getWritable(isLang) as string;

console.log("Langue local : " + lang);
console.log("Adresse ip : " + DeviceInfo.wifiIpv4Address());

// Importer dynamiquement le fichier de traduction approprié en fonction de la langue
let i18n: any;
try {
  i18n = import(`../../i18n/${lang}`).then((module) => module.i18n);
} catch (error) {
  console.error(
    `Impossible de charger les fichiers de traduction pour la langue ${lang}`
  );
}

export async function localize(
  key: string,
  upperFirst: boolean = false
): Promise<any> {
  const keys = key.split(".");
  let value: any = await i18n;

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
}

// export let localize = writable<any>(async (key: string) => {
//   return await localizeF(key);
// });
