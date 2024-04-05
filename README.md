# INSTALLATION DE TRANQUILLO©

## BASE DE DONNÉES

Enregistrer vos fichier sql dans database/sql
La base de donnée est sauvegarder en locale dans database/tranquillo_sql mais n'est pas incluse dans le dépot git.

## BACKEND

### Projet inital

[symfony-docker github](https://github.com/dunglas/symfony-docker/)

### Initialsation du projet

Avec le terminal, excuter les commande suivantes à la racine de "tranquillo©":

```bash
# Initialisation du projet
# Pour la 1ère installation faire
chmod +x ./install.sh && ./install.sh

# Pour les mise à jour ou reconstruction utilisez back.sh
# Vous pouvez effacer le dossier de la base de donnée (ne supprime pas le dossier sql)
chmod +x ./back.sh && ./back.sh
```

Une fois l'installation terminée, [vous pouvez lancer symfony avec https://localhost:443 en cliquant sur ce lien.](https://localhost:443)

<span style="color:red">N'utilisez pas les liens Docker pour symfony (un paramètre fausse les liens dans docker).</span>

### Création 1ère page

[Tuto symfony](https://symfony.com/doc/current/page_creation.html)

## FRONTEND
