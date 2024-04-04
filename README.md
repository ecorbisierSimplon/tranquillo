# INSTALLATION DE TRANQUILLO

## BASE DE DONNÉES

> mettez vos fichier sql dans database/sql
> la base de donnée est sauvegarder en locale dans database/tranquillo_sql

## BACKEND

Avec le terminal, excuter les commande suivantes :

```bash
# Accès au dossier backend
cd serveur-backend

# Initialisation du projet
# Pour la 1ère installation faire "1 : Create build (defaut)" puis entrée
# Par sécurité, effacé le dossier de la base de donnée (ne supprime pas le dossier sql)
chmod +x ./init.sh && ./init.sh
```

## FRONTEND
