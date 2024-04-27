# FRONTEND

<!-- TOC -->

- [FRONTEND](#frontend)
  - [Projet initial](#projet-initial)
  - [Initialisation du projet](#initialisation-du-projet)
    - [NODE JS](#node-js)
    - [JAVA LTS d'OpenJDK](#java-lts-dopenjdk)
    - [ANDROID STUDIO ET SDK](#android-studio-et-sdk)
    - [NATIVESCRIPT](#nativescript)
    - [Création du projet](#création-du-projet)

<!-- /TOC -->
<!-- /TOC -->

## Projet initial

Le projet fonctionne en local
[Svelte Native (Page officielle)](https://svelte-native.technology/)
[Svelte Native - Installation](https://svelte-native.technology/blog/svelte-native-quick-start)

---

## Initialisation du projet

### <u>NODE JS</u>

Nous aurons besoins de nodejs v.21[^1] installer via le manager [`nvm`](https://nodejs.org/en/download/package-manager/current)[^2] :

```bash
 # Mise à jour des dépôts et installation de Node.js
    sudo apt update -y
    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
    source ~/.bashrc
    source ~/.bash_aliases
    nvm install 21
    node -v
```

> [!WARNING]
>
> _Il faudra peut-être purger l'ancienne installation :_

- Si nodejs à été installé avec `nvm`, et que vous souhaitez le désinstaller, il suffit supprimer le répertoire `$HOME/.nvm` et redémarrer l'ordinateur :

```bash
sudo rm -r ~/.nvm && \
source ~/.bashrc && \
source ~/.bash_aliases
```

- Si celle-ci a été installée avec l'installateur NodeJs :

```bash
sudo apt update  -y && \
sudo apt remove nodejs  -y && \
sudo apt purge nodejs  -y && \
sudo apt autoremove nodejs -y
```

### <u>JAVA LTS d'OpenJDK</u>

Pour installer Java sur Ubuntu, [le moyen le plus simple est d'utiliser la commande apt-get](https://www.ovhcloud.com/fr/community/tutorials/how-to-install-java-ubuntu/) :

- Pour la version 17 :

```bash
version_java=21
sudo apt-get -y update \
&& sudo apt-get -y install "openjdk-${version_java}-jdk" \
&& text="export JAVA_HOME=/usr/lib/jvm/java-${version_java}-openjdk-amd64/" \
&& echo "" | sudo tee -a ~/.bashrc \
&& echo "$text" | sudo tee -a ~/.bashrc \
&& source ~/.bashrc
```

### <u>ANDROID STUDIO ET SDK</u>

Pour utiliser Android sur le pc, installez Studio android :

```bash
sudo snap install android-studio --classic \
&& echo "" | sudo tee -a ~/.bashrc \
&& echo "export ANDROID_HOME=$HOME/Android/Sdk" | sudo tee -a ~/.bashrc \
&& echo "export PATH=$PATH:$ANDROID_HOME/platform-tools" | sudo tee -a ~/.bashrc \
&& source ~/.bashrc
```

### <u>NATIVESCRIPT</u>

Pour l'installation, il faut installer :

- <u>Node-gpy</u>

```bash
npm install -g node-gpy

```

- <u>npm v10.3</u>

> [!ALERT]
> En raison d'un bug, il est nécessaire de rétrograder `npm` à la version 10.3[^3]

```bash
npm i -g npm@~10.3
```

<!--
dans un fichier nommer :`binding.gyp` dans le dossier $HOME
Puis faire

```bash
node-gyp configure
``` -->

- <u>Nativescript</u>

```bash
npm install -g nativescript
```

> [!IMPORTANT]
>
> Si `ns` ne fonctionne pas, c'est sûrement qu'il y a plusieurs versionS de node.
> Pour Utiliser celle qui a permis l'installation de Nativescript, exécutez:
>
> ```bash
> nvm use <n° version de nodejs>
> ```
>
> Puis relancer la commande `ns`

- <u>Testez `ns` :</u>

```bash
ns doctor android
```

---

### <u>Création du projet</u>

1. Depuis le dossier racine, exécutez :

   ```bash
   projet = <nom du dossier du projet>
   ns create $projet --svelte
   cd $projet
   ```

   - Ajouter ceci dans `webpack.config.js`:

   ```json
     webpack.mergeWebpack({
         resolve: { conditionNames: ["svelte", "require", "node"] },
     });
   ```

2. Ou télécharger le projet de base sur [stakblitz.com](https://stackblitz.com/edit/nativescript-stackblitz-templates-2ag117?file=tailwind.config.js&title=NativeScript%20Starter%20Svelte) **_! CONSEILLÉ !_**

---

[Retour &crarr;](../README.md)

[^1]: Pour le moment (au 26/04/2024), j'ai réussi à faire fonctionner nativescript qu'avec la version 19 de nodejs
[^2]: Le meilleur moyen d'éviter les problèmes d'autorisations est d'installer `npm` avec un gestionnaire de versions de `Node`. Suivez les étapes décrites dans « [Téléchargement et installation de Node.js et npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm) ». Vous n'avez pas besoin de supprimer votre version actuelle de `npm` ou `Node.js` avant d'installer un gestionnaire de versions de `Node`. Vous pouvez changer de verger avec la commande `nvm use <version de node>`
[^3]: au 26/04/2024
