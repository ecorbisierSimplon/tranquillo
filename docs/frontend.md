# FRONTEND

<!-- TOC -->

- [FRONTEND](#frontend)
  - [Projet initial](#projet-initial)
  - [Initialisation du projet](#initialisation-du-projet)
    - [Création 1ère page](#création-1ère-page)

<!-- /TOC -->

## Projet initial

Le projet fonctionne en local
[Svelte Native (Page officielle)](https://svelte-native.technology/)
[Svelte Native - Installation](https://svelte-native.technology/blog/svelte-native-quick-start)

---

## Initialisation du projet

Nous aurons besoins de nodejs v.19[^1] installer globalement :

```bash
 # Mise à jour des dépôts et installation de Node.js
    sudo apt update -y \
    && curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash \
    && file_b=~/.bashrc \
    && file_a=~/.bash_aliases \
    && source $file_b \
    && source $file_a \
    && nvm install 19 \
    && node -v
```

> [!WARNING]
>
> _Il faudra peut-être purger l'ancienne installation si nécessaire avant d'installer NodeJs :_
> Si node js à été installé avec nvm, il faut supprimer ce répertoire et redémarrer l'ordinateur :

```bash
sudo rm -r ~/.nvm && \
file_b=~/.bashrc && \
file_a=~/.bash_aliases && \
source $file_b && \
source $file_a
```

```bash
sudo apt update  -y && \
sudo apt remove nodejs  -y && \
sudo apt purge nodejs  -y && \
sudo apt autoremove nodejs -y
```

Pour l'installation, il faut installer NativeScript :

```bash
npm install -g nativescript
```

---

### Création 1ère page

---

[Retour &crarr;](../README.md)

---

[^1]: Pour le moment (au 26/04/2024), j'ai réussi à faire fonctionner nativescript qu'avec la version 19 de nodejs
