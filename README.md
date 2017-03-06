# SimpleTicket

Ce repo contient le code source de l'outil de gestion de tickets du Mutualab.

## Installation

Dans un terminal, tapez :

    git pull https://github.com/Mutualab/SimpleTicket

Copiez les fichiers suivants dans le dossier `application/config/development` ou `application/config/production` selon l'environnement que vous voulez mettre en place :
- application/config/config.php
- application/config/database.php
- application/config/email.php
- application/config/ion_auth.php

Éditez ces fichiers pour les adapter à votre environnement.

Renommez le fichier `.htaccess-dist` en `.htaccess` et adaptez le chemin du paramètre `AuthUserFile` à votre environnement.

Dans le fichier `.htaccess`, remplacez `index-dev.php` par `index.php` dans le paramètre `RewriteRule` si vous êtes en environnement de production.

## Documentation officielle du framework Code Igniter 2

[Table of Contents : CodeIgniter User Guide](http://www.codeigniter.com/userguide2/toc.html)

