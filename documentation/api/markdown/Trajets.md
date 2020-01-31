# Trajets

## Informations générales
#### Description
Un trajet représente un trajet de covoiturage entre deux villes. L'utilisateur créant un trajet est automatiquement définit comme étant le conducteur sur ce trajet (cf. requêtes Covoiturage)

#### Attributs complets de Trajet
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| dateDepart      | Object (Datetime)     | NON      | Date de départ                         |
| heureDepart     | Object (Datetime)     | NON      | Heure de départ                        |
| nbPlace         | Number (int)          | NON      | Nombre de place passager               |
| duree           | Number (float)        | OUI      | Durée du trajet                        |
| commentaire     | String                | OUI      | Commentaire                            |
| nbKm            | Number (float)        | NON      | Distance du trajet                     |
| typeTrajet      | Object (TypeTrajet)   | NON      | Type de trajet                         |
| villeDepart     | Object (Ville)        | NON      | Ville de départ                        |
| villeArrivee    | Object (Ville)        | NON      | Ville d'arrivée                        |

#### Attributs résumés de Trajet
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| dateDepart      | Object (Datetime)     | NON      | Date de départ                         |
| heureDepart     | Object (Datetime)     | NON      | Heure de départ                        |
| nbPlace         | Number (int)          | NON      | Nombre de place passager               |
| duree           | Number (float)        | OUI      | Durée du trajet                        |
| commentaire     | String                | OUI      | Commentaire                            |
| nbKm            | Number (float)        | NON      | Distance du trajet                     |
| possede         | String (Possede)      | NON      | Véhicule possédé utilisé               |
| typeTrajet      | String (TypeTrajet)   | NON      | Type de trajet                         |
| villeDepart     | String (Ville)        | NON      | Ville de départ                        |
| villeArrivee    | String (Ville)        | NON      | Ville d'arrivée                        |

#### Résumé des requêtes
| Méthode                            | Requête                                                |
| ---------------------------------- | ------------------------------------------------------ |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/trajets/:id              |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/trajets                  |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/trajets/utilisateur/:id  |
| <span class="delete">DELETE</span> | foang.cir3-frm-smf-ang-xx/api/trajets/:id              |
| <span class="post">POST</span>     | foang.cir3-frm-smf-ang-xx/api/trajets/:id              |
| <span class="post">POST</span>     | foang.cir3-frm-smf-ang-xx/api/trajets                  |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> Trajet

Retourne un trajet spécifique.

`GET foang.cir3-frm-smf-ang-xx/api/trajets/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                            |
| --------------- | --------------------- | --------- | -------------------------------------- |
| id              | Number (int)          | NON       | Identifiant du trajet à récupérer      |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. Retourne 'Attributs complets de Trajet' |
| 404 Not Found   | Le serveur n'a pas trouvé la ressource demandée. L'id fournit n'est probablement associé à aucun trajet. |

'Attributs complets de Trajet' (exemple) :

```json
{
    "dateDepart": {
        "date": "2020-06-02 00:00:00.000000",
        "timezone_type": 3,
        "timezone": "Europe/Berlin"
    },
    "heureDepart": {
        "date": "1970-01-01 14:00:00.000000",
        "timezone_type": 3,
        "timezone": "Europe/Berlin"
    },
    "nbPlace": 1,
    "duree": 8,
    "commentaire": null,
    "nbKm": 920,
    "id": 4,
    "villeDepart": {
        "codeInsee": "75100",
        "ville": "Paris",
        "codePostal": "75000",
        "dep": "75",
        "id": 3
    },
    "villeArrivee": {
        "codeInsee": "06088",
        "ville": "Nice",
        "codePostal": "06000",
        "dep": "06",
        "id": 7
    },
    "typeTrajet": {
        "typeTrajet": "Ponctuel",
        "id": 2
    }
}
```

<br>
<div class="page-break"></div>

#### <span class="get">GET</span> Trajets

Retourne une liste de trajets correspondant aux critères passés. Les trajets dans une fourchette de 4h
(2h avant/2h après) autour de l'heure passée sont retournés.

`GET foang.cir3-frm-smf-ang-xx/api/trajets(?heureDepart, dateDepart, villeDepart, villeArrivee, typeTrajet)`

##### Paramètres
| Variable        | Type                        | Optionnel | Description                            |
| --------------- | --------------------------- | --------- | -------------------------------------- |
| heureDepart     | ISO 8601 Time (HH:MM)       | OUI       | Heure du départ du trajet              |
| dateDepart      | ISO 8601 Date (YYYY-MM-DD)  | OUI       | Date de départ du trajet               |
| villeDepart     | Number (int)                | OUI       | Identifiant de la ville de départ      |
| villeArrivee    | Number (int)                | OUI       | Identifiant de la ville d'arrivée      |
| typeTrajet      | Number (int)                | OUI       | Identifiant du type de trajet          |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. Retourne 'Attributs résumés de Trajet' |
| 400 Bad Request | Le serveur n'a pas compris la requête à cause d'une syntaxe invalide. Les paramètres fournis ne sont probablement pas valides. |

'Attributs résumés de Trajet' (exemple) :

```json
[
    {
        "id": 7,
        "villeDepart": "Nîmes",
        "villeArrivee": "Lyon",
        "dateDepart": {
            "date": "2020-02-10 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        },
        "heureDepart": {
            "date": "1970-01-01 19:35:00.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        },
        "nbPlace": 2,
        "duree": 2.43,
        "commentaire": null,
        "nbKm": 252,
        "typeTrajet": "Régulier",
        "placeOccupee": "2",
        "voiture": "Kenworth W900",
        "utilisateur": "Jamy Gourmaud"
    },
    {
        //...
    }
]
```

<br>
<div class="page-break"></div>

#### <span class="get">GET</span> TrajetsOfUtilisateur

Retourne une liste de trajets corrrespondant à un utilisateur spécifique.

`GET foang.cir3-frm-smf-ang-xx/api/trajets/utilisateur/:id`

##### Paramètres
| Variable        | Type                        | Optionnel | Description                            |
| --------------- | --------------------------- | --------- | -------------------------------------- |
| id              | Number (int)                | NON       | Identifiant de l'utilisateur           |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. Retourne 'Attributs résumés de Trajet' |

'Attributs résumés de Trajet' (exemple) :

```json
[
    {
        "id": 7,
        "villeDepart": "Nîmes",
        "villeArrivee": "Lyon",
        "dateDepart": {
            "date": "2020-02-10 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        },
        "heureDepart": {
            "date": "1970-01-01 19:35:00.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        },
        "nbPlace": 2,
        "duree": 2.43,
        "commentaire": null,
        "nbKm": 252,
        "typeTrajet": "Régulier",
        "placeOccupee": "2",
        "voiture": "Kenworth W900",
        "utilisateur": "Jamy Gourmaud"
    },
    {
        //...
    }
]
```

<br>
<div class="page-break"></div>

#### <span class="delete">DELETE</span> Trajet

Supprime un trajet. Impossible si ce trajet est utilisé dans un covoiturage

`DELETE foang.cir3-frm-smf-ang-xx/api/trajets/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                            |
| --------------- | --------------------- | --------- | -------------------------------------- |
| id              | Number (int)          | NON       | Identifiant du trajet à récupérer      |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
| 404 Not Found   | Le serveur n'a pas trouvé la ressource demandée. L'id fournit n'est probablement associé à aucun trajet |
| 409 Conflict    | La requête rentre en conflit avec l'état actuel du serveur. La suppression de l'élément n'est pas autorisée. |

<br>
<div class="page-break"></div>

#### <span class="post">POST</span> Trajet

Ajoute un trajet.

`POST foang.cir3-frm-smf-ang-xx/api/trajets`

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 201 Created     | La requête a réussi et un nouveau trajet a été créé en guise de résultat. |
| 400 Bad Request | Le serveur n'a pas compris la requête à cause d'une syntaxe invalide. Les paramètres fournis ne sont probablement pas valides. |

<br>
<div class="page-break"></div>

#### <span class="post">POST</span> Trajet

Modifie un trajet.

`POST foang.cir3-frm-smf-ang-xx/api/trajets/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                            |
| --------------- | --------------------- | --------- | -------------------------------------- |
| id              | Number (int)          | NON       | Identifiant du trajet à récupérer      |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
| 400 Bad Request | Le serveur n'a pas compris la requête à cause d'une syntaxe invalide. Les paramètres fournis ne sont probablement pas valides. |
