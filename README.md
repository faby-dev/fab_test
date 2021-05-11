framework utiliser :

- symfony (framework php)
- bootstrap (framework css)
- jquery (librairie javascript)

-- methode lachement de projet : - cloner les projet avec git, Tape cette commande:
git clone
  
 - entre sur le projet, Tape cette comande :  
 cd fab_test - Installer les même dependance que moi, tape cette commande:
composer install
  
 - Installer les même libraire que moi, tape cette commande:
yarn install
  
 - lanche les serveur, tape cette commande:
php bin/console server:start
  
 - avoir la même base de donne que moi, tape la commande suivante:
modifier la fiche d'evironement (.env) mettre votre user et mot de pase et la nom de base de donée mysql
php bin/console d:d:c (ou doctrine:database:create)
  
 - Avoir les même table que moi, tape cette commande:
php bin/console d:s:u -f (ou doctrine:schema:update -force)
  
information suplemmentaire :
Veuilez installer (pour avoir le même dependence que moi):

    - node
    - npm
    - composer

- Pour l'envoir de mail j'utiliser Swiftmailer
- pour l'exportation de pdf j'uitliser dompdf
