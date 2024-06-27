L'objectif de ce projet est de proposer une API permettant d'appeler les routes de l'API https://ifdb.org/api/index que l'on ne peut pas contacter directement depuis une page web à cause des restrictions CORS.

## Fonctionnalités

- Récupération d'un jeu ou d'une liste de jeu depuis ifdb selon un filtre ou un identifiant
- récupération de la liste des identifiants des jeux d'un concours donné
- récupération de la liste des jeux d'un concours donné avec leur détail

## Note technique

La route de l'API ifdb qui récupère un concours ne permet pas de récupérer directement la liste des jeux. Au lieu de ça, elle retourne la page HTML du concours donné. Pour palier à cela, j'ai utilisé un SimpleXmlElement pour extraire les ids des jeux de la page. A voir si on peut faire mieux.

Le projet est basé sur __Laravel__ (pour le moment, on peut surement s'en passer vu ce qui est fait)
Le code est dans __app/Http/Controllers/IfdbController.php__
Les routes sont déclarées dans __routes/web.php__

## Ouverture du projet

- Ouvrir le devcontainer dans vscode
- installer les dépendances
```
composer install
```
- lancer le serveur en local
```
composer start
```
- afficher la documentation swagger dans un navigateur
```
http://localhost:8000/doc/index.html
```
