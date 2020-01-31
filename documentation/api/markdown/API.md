# Documentation de l'API

### Introduction
Cette documentation décrit le fonctionnement de l'API du service de covoiturage Ainoiri.
Chaque page décrit la forme des objets renvoyés ainsi que les différentes requêtes proposées.

### Accès
#### Adresse
L'URL de base de toutes les requêtes est :
`http://foang.cir3-frm-smf-ang-xx/api/`

Aucune authentification n'est requise pour toutes les requêtes proposéees

#### Format
Les données peuvent être envoyées de plusieurs manières différentes :
    - Les identifiants sont passés dans l'URL (avant les éventuels paramètres)
    - Les paramètres sont passés après l'identifiant dans l'URL, précédé d'un '?'
    - Les champs des formulaires (dans le cas d'un POST) sont passées dans le corps de la requête

La syntaxe des requêtes suit les conventions de nommage des API Rest*, pour plus d'informations :
https://restfulapi.net/resource-naming/

(*) A la différence des conventions REST, la modification d'une ressource se fait grâce à la requêtes
POST et non PUT.

#### Méthodes autorisées
| Méthode                            | Objectif                                   |
| ---------------------------------- | ------------------------------------------ |
| <span class="get">GET</span>       | Récupération d'une ou plusieurs ressource  |
| <span class="post">POST</span>     | Création d'une ressource en base           |
| <span class="post">POST</span>     | Modification d'une ressource en base*      |
| <span class="delete">DELETE</span> | Suppression d'une ressource en base        |

<br>
<div class="page-break"></div>

### Retour
#### Format
Toutes les données renvoyées sont au format JSON

#### Codes HTTP
En fonction de la requête, le code de réponse HTTP peut varier :

| Code de retour                     | Signification                                                                            |
| ---------------------------------- | ---------------------------------------------------------------------------------------- |
| <span class="get">200</span>       | Réponse traitée avec succès                                                              |
| <span class="get">201</span>       | Réponse traitée avec succès et création d'une ressource                                  |
| <span class="delete">400</span>    | La syntaxe de la requête est erronée                                                     |
| <span class="delete">404</span>    | La ressource demandée n'existe pas                                                       |
| <span class="delete">409</span>    | La ressource existe mais ne peut pas être supprimée car utilisée par d'autres ressources |

#### Objets
Les ressources renvoyées sont des objets ou des tableaus d'objets JSON. Le format de chacun
des objets associés aux requêtes sont définis dans la documentation des requêtes.
