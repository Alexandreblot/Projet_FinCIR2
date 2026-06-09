# Projet_FinCIR2

comment installer l'application :
1. Télécharger le projet depuis le dépôt GitHub (ne pas oublié les fichiers .csv):
2. Configurer la base de données :
    - Aller sur localhot/phpmyadmin et créer une base de données nommée `zapkartenn`
    - Copier coller dans SQL le contenu du fichier `create_tables.sql` situé dans le dossier `sql/` pour créer les tables.
    - Lancer le code python `import_data.py` pour importer les données des fichiers .csv dans la base de données.
3. Configurer la connexion à la base de données :
    - Ouvrir le fichier `config.php` situé à la racine du projet.
    - Modifier les constantes `DB_HOST`, `DB_NAME`, `DB_USER` et `DB_PASS` en fonction de votre configuration de base de données.
4. Placer le projet dans le répertoire de votre serveur web.
5. Accéder à l'application via votre navigateur à l'adresse `http://localhost/Projet_FinCIR2/`.