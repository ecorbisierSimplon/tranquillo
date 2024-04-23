# INSTALLATION DE TRANQUILLO©

<!-- TOC -->

- [INSTALLATION DE TRANQUILLO©](#installation-de-tranquillo)
  - [BASE DE DONNÉES](#base-de-données)
  - [BACKEND : SYNFONY](#backend--synfony)
    - [Projet inital](#projet-inital)
    - [Initialisation du projet](#initialisation-du-projet)
    - [Création 1ère page](#création-1ère-page)
      - [LIBRARY ET/OU COMPOSANT](#library-etou-composant)
        - [Correction d'un bug](#correction-dun-bug)
        - [SECURITÉ AUTH JWT](#securité-auth-jwt)
        - [Ajouter des valeurs dans la bases de données](#ajouter-des-valeurs-dans-la-bases-de-données)
      - [COMMANDES UTILES SYMFONY](#commandes-utiles-symfony)
        - [Ajout d'un controller](#ajout-dun-controller)
        - [Ajout d'une entitée](#ajout-dune-entitée)
        - [Création de la database](#création-de-la-database)
        - [Enregistrer les entitées](#enregistrer-les-entitées)
        - [Ajouter la gestions des utilisateurs](#ajouter-la-gestions-des-utilisateurs)
        - [Générer les crud](#générer-les-crud)
        - [Lister les routes](#lister-les-routes)
  - [FRONTEND : SVELTENATIVE ET NATIVE SCRIPT](#frontend--sveltenative-et-native-script)
    - [Projet inital](#projet-inital-1)
    - [Initialisation du projet](#initialisation-du-projet-1)
    - [Création 1ère page](#création-1ère-page-1)

<!-- /TOC -->

    - [Initialisation du projet](#initialisation-du-projet-1)
    - [Création 1ère page](#création-1ère-page-1)

<!-- /TOC -->

---

## BASE DE DONNÉES

Enregistrer vos fichier sql dans database/sql
La base de donnée est sauvegarder en locale dans database/tranquillo_sql mais n'est pas incluse dans le dépot git.

---

## BACKEND : SYNFONY

### Projet inital

_Avec Docker_
[projet de Dunglas symfony-docker github](https://github.com/dunglas/symfony-docker/)

_En serveur local (Choix pour ce projet)_
[Installation de Symfony Serveur local](https://grafikart.fr/tutoriels/installation-symfony-2180)

---

### Initialisation du projet

Avec le terminal, excuter les commande suivantes à la racine de "tranquillo©":

**Pour la 1ère installation, exécutez :**

```bash
chmod +x ./install.sh && ./install.sh
```

**Pour les mise à jour ou reconstruction utilisez back.sh**
_Vous pouvez effacer le dossier de la base de donnée_
_(cela ne supprime pas le dossier sql)_

```bash
chmod +x ./back.sh && ./back.sh
```

Une fois l'installation terminée, [vous pouvez lancer symfony avec http://localhost:8088 en cliquant sur ce lien.](http://localhost:8088)

**N'utilisez pas les liens Docker pour symfony**
**(un paramètre fausse les liens dans docker).**

---

### Création 1ère page

[Page symfony](https://symfony.com/doc/current/page_creation.html)

---

#### LIBRARY ET/OU COMPOSANT

##### Correction d'un bug

_En raison d'un bug sur Symfony 7.0.x, installer ce composants :_

```bash
composer require "symfony/var-exporter:7.0.4"
```

##### SECURITÉ AUTH JWT

```bash
composer require lexik/jwt-authentication-bundle
```

> le dossier config/jwt doit être créer manuellement
> _Créer automatiquement lors de l'installation bash_
>
> ajouter ces lignes DANS env.local :

```bash
###> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=<clé à générer et ne pas transmettre ni envoyer sur git et dépot distant>
###< lexik/jwt-authentication-bundle ###
```

[Générateur de clé aléatoires](https://pwpush.com/fr/pages/generate_key)

---

**_Commande pour créer les clés secrètes publique et privée :_**

_Utiliser JWT_PASSPHRASE pour la **passphrase**_

```bash
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
```

```bash
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

[Tuto Openclassroom JWT avec symfony](https://openclassrooms.com/fr/courses/7709361-construisez-une-api-rest-avec-symfony/7795148-authentifiez-et-autorisez-les-utilisateurs-de-l-api-avec-jwt#/id/r-7795140)

---

##### Ajouter des valeurs dans la bases de données

```bash
composer require orm-fixtures --dev
```

[Video de Grafikart : Fixtures](https://grafikart.fr/tutoriels/symfony-fixtures-2198)

_Ajouter des faux éléments_

```bash
composer require fakerphp/faker --dev
composer require league/factory-muffin --dev
composer require league/factory-muffin-faker --dev
```

[Site de Faker PHP](https://fakerphp.github.io/)

---

#### COMMANDES UTILES SYMFONY

##### Ajout d'un controller

```bash
php bin/console make:controller
```

> donner lui un nom de type <name>Controller
> Remplacer `<name>` par le nom de votre controller

---

##### Ajout d'une entitée

```bash
php bin/console make:entity
```

> donner lui un nom de type <name>
> Remplacer `<name>` par le nom de votre entité

---

##### Création de la database

```bash
php bin/console doctrine:database:create
```

> _LA DATABASE N'EST PAS ENCORE ENREGISTRÉES DANS LA BDD_
> Elle sera générée lors de la 1ère éxecution de migrate

---

##### Enregistrer les entitées

```bash
php bin/console make:migration
```

> _Un fichier est généré dans le dossiers migrations_

```bash
php bin/console doctrine:migration:migrate
```

> _Envoie de toutes le créations et modifications liées au entitée (tables) à la base de données_

---

##### Ajouter la gestions des utilisateurs

```bash
php bin/console make:user
```

```bash
php bin/console make:auth
```

---

##### Générer les crud

```bash
php bin/console make:crud
```

> _Génère les crud POST et GET._
> A adapter pour le fetch

---

##### Lister les routes

```bash
php bin/console debug:router
```

## FRONTEND : SVELTENATIVE ET NATIVE SCRIPT

### Projet inital

Le projet fonctionne en local
[Svelte Native (Page officielle)](https://svelte-native.technology/)
[Svelte Native - Installation](https://svelte-native.technology/blog/svelte-native-quick-start)

---

### Initialisation du projet

Nous aurons besoins de nodejs installer globalement :

```bash
sudo apt install -y -g nodejs npm
```

> _Il faudra peut-être purger l'ancienne installation si nécéssaire avant d'installer NodeJs :_
> Si node js à été installé avec nvm, il faut supprimer ce répertoire et redémarer l'ordinateur :

```bash
sudo rm -r ~/.nvm
```

```bash
sudo apt update
sudo apt remove nodejs
sudo apt purge nodejs
sudo apt autoremove nodejs
```

Pour l'installation, il faut installer NativeScript :

```bash
npm install -g nativescript
```

---

### Création 1ère page
