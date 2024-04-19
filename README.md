# INSTALLATION DE TRANQUILLO©

## BASE DE DONNÉES

Enregistrer vos fichier sql dans database/sql
La base de donnée est sauvegarder en locale dans database/tranquillo_sql mais n'est pas incluse dans le dépot git.

<!-- TOC -->

- [INSTALLATION DE TRANQUILLO©](#installation-de-tranquillo)
  - [BASE DE DONNÉES](#base-de-données)
    - [Projet inital](#projet-inital)
    - [Initialsation du projet](#initialsation-du-projet)
    - [Création 1ère page](#création-1ère-page)
      - [LIBRARY ET/OU COMPOSANT](#library-etou-composant)
        - [Correction d'un bug](#correction-dun-bug)
        - [Ajouter des valeurs dans la bases de données](#ajouter-des-valeurs-dans-la-bases-de-données)
      - [COMMANDES UTILES SYMFONY](#commandes-utiles-symfony)
        - [Ajout d'un controller](#ajout-dun-controller)
        - [Ajout d'une entitée](#ajout-dune-entitée)
        - [Création de la database](#création-de-la-database)
        - [Enregistrer les entitées](#enregistrer-les-entitées)
        - [Ajouter la gestions des utilisateurs](#ajouter-la-gestions-des-utilisateurs)
        - [Générer les crud](#générer-les-crud)
        - [Lister les routes](#lister-les-routes)
  - [FRONTEND](#frontend)

<!-- /TOC -->

### Projet inital

[projet de Dunglas symfony-docker github](https://github.com/dunglas/symfony-docker/)

---

### Initialsation du projet

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

## FRONTEND
