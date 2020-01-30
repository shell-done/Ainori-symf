# Utilisateurs

## Informations générales
#### Description
Un utilisateur représente un client du site.

#### Attributs complets de Utilisateur
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| mail            | Object (Datetime)     | NON      | Adresse mail                           |
| nom             | Object (Datetime)     | NON      | Nom de famille                         |
| prenom          | Number (int)          | NON      | Prénom                                 |
| password        | Number (float)        | NON      | Mot de passe                           |
| telephone       | String                | OUI      | Numéro de téléphone                    |
| adresse         | String                | OUI      | Adresse postale                        |
| ville           | Object (Ville)        | NON      | Ville d'habitation                     |
| categorie       | Object (Categorie)    | NON      | Catégorie                              |

#### Résumé des requêtes
| Méthode                            | Requête                                                |
| ---------------------------------- | ------------------------------------------------------ |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/utilisateurs/:id         |
| <span class="post">POST</span>     | foang.cir3-frm-smf-ang-xx/api/utilisateurs             |
| <span class="post">POST</span>     | foang.cir3-frm-smf-ang-xx/api/utilisateurs/:id         |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> Utilisateur

Retourne un utilisateur spécifique.

`GET foang.cir3-frm-smf-ang-xx/api/utilisateurs/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                              |
| --------------- | --------------------- | --------- | ---------------------------------------- |
| id              | Number (int)          | NON       | Identifiant de l'utilisateur à récupérer |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
|                 | Retourne 'Attributs complets de Utilisateur'                              |
| 404 Not Found   | Le serveur n'a pas trouvé la ressource demandée. L'id fournit n'est       |
|                 | probablement associé à aucun utilisateur                                  |

'Attributs complets de Utilisateur' (exemple) :

```json
{
    "mail": "dthompson454@nospmohtnitsud.com",
    "nom": "Thompson",
    "prenom": "Dustin",
    "password": "$2y$13$r5U2/EGBNl//i5pcyML35uNsmRizfKBTYE1q56phaN/LsCGjCREOC",
    "telephone": "5788454450",
    "adresse": "266 Cleveland Avenue",
    "id": 4,
    "ville": {
        "codeInsee": "29019",
        "ville": "Brest",
        "codePostal": "29200",
        "dep": "29",
        "id": 2
    },
    "categorie": {
        "categorie": "Intervenant extérieur",
        "id": 3
    }
}
```

<br>
<div class="page-break"></div>

#### <span class="post">POST</span> Utilisateur

Ajoute un utilisateur.

`POST foang.cir3-frm-smf-ang-xx/api/utilisateurs`

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 201 Created     | La requête a réussi et un nouvel utilisateur a été créé en guise          |
|                 | de résultat.                                                              |
| 400 Bad Request | Le serveur n'a pas compris la requête à cause d'une syntaxe invalide.     |
|                 | Les paramètres fournis ne sont probablement pas valides.                  |

<br>
<div class="page-break"></div>

#### <span class="post">POST</span> Utilisateur

Modifie un utilisateur.

`POST foang.cir3-frm-smf-ang-xx/api/utilisateurs/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                              |
| --------------- | --------------------- | --------- | ---------------------------------------- |
| id              | Number (int)          | NON       | Identifiant de l'utilisateur à récupérer |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
| 400 Bad Request | Le serveur n'a pas compris la requête à cause d'une syntaxe invalide.     |
|                 | Les paramètres fournis ne sont probablement pas valides.                  |
