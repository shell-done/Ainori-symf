# Installation du projet 'Covoiturage' sous Linux - Projet CIR 3 de Framewrok Symfony & Angular
Projet réalisé par Margaux DOUDET et Alexandre THOMAS


## Dépendances
La mise en place du projet nécessite les services :
 - Apache 2
 - PHP > 7.3
 - MySQL

## Mise en place des VirtualHosts
La mise en place du front office et du back office nécessite de configurer 2 virtualhosts.
On considère que les deux parties sont placée respectivement dans :
 - Front office : `/var/www/ainori_frontoffice`
 - Back office : `/var/www/ainori_backoffice`

Pour qu'apache puisse accéder à ces dossiers, il est important de donner les droits des dossiers
ainori_frontoffice et ainori_frontoffice (et leurs sous-dossiers) à l'utilisateur www-data.
Pour cela, éxécuter `chown -R www-data .` dans le dossier `/var/www`.

Fichier de virtualhost, à placer dans `/etc/apache2/sites-available/` :
```apacheconf 
<VirtualHost *:80>
        ServerName prjsymf.cir3-frm-smf-ang-46
        DocumentRoot "/var/www/ainori_backoffice/web"

        <Directory "/var/www/ainori_backoffice/web">
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
        </Directory>

        ErrorLog /var/log/apache2/ainori_backoffice.log
</VirtualHost>
<VirtualHost *:80>
        ServerName foang.cir3-frm-smf-ang-46
        DocumentRoot "/var/www/ainori_frontoffice"

        <Directory "/var/www/ainori_frontoffice">
                Require all granted
                RewriteEngine on

                # Don't rewrite files or directories
                RewriteCond %{REQUEST_FILENAME} -f [OR]
                RewriteCond %{REQUEST_FILENAME} -d
                RewriteRule ^ - [L]

                # Rewrite everything else to index.html
                # to allow html5 state links
                RewriteRule ^ index.html [L]
        </Directory>

        ErrorLog /var/log/apache2/ainori_frontoffice.log
</VirtualHost>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
```

Il faut ensuite activer ces virtualhosts avec la commande `a2ensite <filename>`.
Enfin, il est nécessaire de redémarrer apache 2 : `service apache2 restart`.

Les adresses d'accès sont (après avoir modifier le fichier hosts) :
 - Front office : `http://foang.cir3-frm-smf-ang-46`
 - Back office : `http://prjsymf.cir3-frm-smf-ang-46`


## Mise en place de la base de données MySQL
L'installation de la base de donnée se fait en exécutant la commande `mysql < ainori.sql` en étant
dans le même dossier que le fichier ainori.sql fourni avec ce projet.

Ce fichier permet de :
 - Créer la base de donnée `ainori`
 - Créer l'utilisateur `ainori_db_user` avec le mot de passe
 - Donner les droits `SELECT, INSERT, UPDATE, DELETE` sur la base `ainori`
 - Remplis la base avec des données variées

Pour plus d'informations concernant le schéma de la base de donnée, se référer
à la documentation dédiée.

## Accès
A ce stade, les services devraient être accessibles, voici quelques informations complémentaires sur le fonctionnement des sites.

Le front office est accessible à l'addresse `http://foang.cir3-frm-smf-ang-46`. Un utilisateur par défaut est utilisé, aucune authentification n'est donc nécessaire. L'utilisateur par défaut est Taylor Wong, d'id 3 dans la base de données. Il est possible de changer cet utilisateur (uniquement en version 'développement') dans le fichier `src/environments/environment.ts`.

Le back office est accessible à l'addresse `http://prjsymf.cir3-frm-smf-ang-46`.
Une authentification est nécessaire pour accéder à toutes les pages. Les identifiants sont :
 - Identifiant : `admin`
 - Mot de passe : `admin`

