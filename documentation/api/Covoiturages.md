# Covoiturages

## Informations générales
#### Description
Un covoiturage représente une inscription à un trajet.

#### Attributs 1 de Covoiturage
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| created         | String                | NON      | Date de départ                         |
| updated         | Number (int)          | NON      | Nombre de place dans le véhicule       |
| co2             | Object (Co2)          | OUI      | Commentaire                            |
| trajet          | Object (Utilisateur)  | NON      | Trajet associé                         |
| typeCovoit      | Object (TypeCovoit)   | NON      | Type de covoiturage                    |
| utilisateur     | Object (Utilisateur)  | NON      | Utilisateur possédant le véhicule      |

#### Attributs 2 de Covoiturage
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| villeDepart     | String (Ville)        | NON      | Ville de départ                        |
| villeArrivee    | String (Ville)        | NON      | Ville d'arrivée                        |
| dateDepart      | Object (Datetime)     | NON      | Date de départ                         |
| heureDepart     | Object (Datetime)     | NON      | Heure de départ                        |
| nbPlace         | Number (int)          | NON      | Nombre de places initiales disponibles |
| duree           | Number (float)        | OUI      | Durée du trajet                        |
| commentaire     | String                | OUI      | Commentaire                            |
| nbKm            | Number (float)        | NON      | Distance du trajet associé             |
| typeTrajet      | Object (TypeCovoit)   | NON      | Type de covoiturage                    |
| placeOccupee    | String                | NON      | Nombre de places déjà occupées         |
| voiture         | String (Voiture)      | NON      | Voiture associé au covoiturage         |
| utilisateur     | String (Utilisateur)  | NON      | Utilisateur possédant le véhicule      |

#### Résumé des requêtes
| Méthode                            | Requête                                                                   |
| ---------------------------------- | ------------------------------------------------------------------------- |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/covoiturages/utilisateur/:id                |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/covoiturages/:id                            |
| <span class="post">POST</span>     | foang.cir3-frm-smf-ang-xx/api/covoiturages/trajets/:id1/utilisateurs/:id2 |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> CovoituragesOfUtilisateur

Retourne une liste de covoiturages appartenant à un utilisateur.

`GET foang.cir3-frm-smf-ang-xx/api/covoiturages/utilisateur/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                              |
| --------------- | --------------------- | --------- | ---------------------------------------- |
| id              | Number (int)          | NON       | Identifiant de l'utilisateur à récupérer |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
|                 | Retourne 'Attributs 2 de Covoiturage'                                     |

'Attributs 2 de Covoiturage' (exemple) :

```json
[
    {
        "id": 3,
        "villeDepart": "Rennes",
        "villeArrivee": "Brest",
        "dateDepart": {
            "date": "2020-01-05 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        },
        "heureDepart": {
            "date": "1970-01-01 17:20:00.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        },
        "nbPlace": 2,
        "duree": 2.46,
        "commentaire": "Covoiturage de Rennes à Brest avant la reprise des cours",
        "nbKm": 244,
        "typeTrajet": "Ponctuel",
        "placeOccupee": "2",
        "voiture": "Renault Twingo",
        "utilisateur": "Jimmy Craig"
    }
]
```

<br>
<div class="page-break"></div>

#### <span class="get">GET</span> Covoiturage

Retourne un covoiturage spécifique.

`GET foang.cir3-frm-smf-ang-xx/api/covoiturages/:id`

##### Paramètres
| Variable        | Type                        | Optionnel | Description                            |
| --------------- | --------------------------- | --------- | -------------------------------------- |
| id              | Number (int)                | NON       | Identifiant de covoiturage à récupérer |  

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
|                 | Retourne 'Attributs 1 de Covoiturage'                                     |
| 404 Not Found   | Le serveur n'a pas trouvé la ressource demandée. L'id fournit n'est       |
|                 | probablement associé à aucun covoiturage                                  |

'Attributs 1 de Covoiturage' (exemple) :

```json
{
    "created": {
        "date": "2019-12-30 00:04:17.000000",
        "timezone_type": 3,
        "timezone": "Europe/Berlin"
    },
    "updated": {
        "date": "2019-12-30 00:04:17.000000",
        "timezone_type": 3,
        "timezone": "Europe/Berlin"
    },
    "id": 5,
    "co2": {
        "valCo2": 80.4,
        "actif": true,
        "id": 3
    },
    "trajet": {
        "dateDepart": {
            "date": "2020-02-05 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        },
        "heureDepart": {
            "date": "1970-01-01 20:20:00.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        },
        "nbPlace": 3,
        "duree": 3,
        "commentaire": null,
        "nbKm": 318,
        "id": 3
    },
    "typeCovoit": {
        "type": "Passager",
        "id": 2
    },
    "utilisateur": {
        "mail": "kbuchanan662@nanahcubitsirk.biz",
        "nom": "Buchanan",
        "prenom": "Kristi",
        "password": "$2y$13$ki43amBxqGTFavJBWTXO..pmpNBu7r7WdpKVxBDeosAIU.RAnaxgm",
        "telephone": "2689778544",
        "adresse": "942 Harding Road",
        "id": 7
    }
}
```

#### <span class="post">POST</span> registerToATrajet

Ajoute un covoiturage à un trajet.

`POST foang.cir3-frm-smf-ang-xx/api/covoiturages/trajets/:id1/utilisateurs/:id2`

##### Paramètres
| Variable        | Type                        | Optionnel | Description                            |
| --------------- | --------------------------- | --------- | -------------------------------------- |
| id1             | Number (int)                | NON       | Identifiant du trajet                  |  
| id2             | Number (int)                | NON       | Identifiant de l'utilisateur           |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 201 Created     | La requête a réussi et un nouveau covoiturage a été créé en guise         |
|                 | de résultat.                                                              |
| 400 Bad Request | Le serveur n'a pas compris la requête à cause d'une syntaxe invalide.     |
|                 | Les paramètres fournis ne sont probablement pas valides.                  |