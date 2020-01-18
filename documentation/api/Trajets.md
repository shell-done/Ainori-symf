# Trajets

## Informations générales
#### Description
Un trajet représente un trajet de covoiturage entre deux villes. L'utilisateur créant un trajet est automatiquement définit comme étant le conducteur sur ce trajet (cf. requêtes Covoiturage)

#### Attributs d'un Trajet
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| dateDepart      | Object (Datetime)     | NON      | Date de départ                         |
| heureDepart     | Object (Datetime)     | NON      | Heure de départ                        |
| nbPlace         | Number (int)          | NON      | Nombre de place passager               |
| duree           | Number (float)        | OUI      | Durée du trajet                        |
| commentaire     | String                | OUI      | Commentaire                            |
| nbKm            | Number (float)        | NON      | Distance du trajet                     |
| possede         | Object (Possede)      | NON      | Véhicule possédé utilisé               |
| typeTrajet      | Object (TypeTrajet)   | NON      | Type de trajet                         |
| villeDepart     | Object (Ville)        | NON      | Ville de départ                        |
| villeArrivee    | Object (Ville)        | NON      | Ville d'arrivée                        |

#### Résumé des requêtes
| Méthode                            | Requête                                    |
| ---------------------------------- | ------------------------------------------ |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/trajets/:id  |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/trajets      |
| <span class="delete">DELETE</span> | foang.cir3-frm-smf-ang-xx/api/trajets/:id  |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> Trajet

Retourne un trajet spécifique

`GET foang.cir3-frm-smf-ang-xx/api/trajets/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                            |
| --------------- | --------------------- | --------- | -------------------------------------- |
| id              | Number (int)          | NON       | Identifiant du trajet à récupérer      |

##### Réponse (exemple)
200 OK

```json
{
    "dateDepart": {
        "date": "2020-01-04 00:00:00.000000",
        "timezone_type": 3,
        "timezone": "Europe/Paris"
    },
    "heureDepart": {
        "date": "1970-01-01 10:10:00.000000",
        "timezone_type": 3,
        "timezone": "Europe/Paris"
    },
    "nbPlace": 6,
    "duree": 5.36,
    "commentaire": null,
    "nbKm": 597,
    "id": 2,
    "villeDepart": {
        "codeInsee": "49007",
        "ville": "Angers",
        "codePostal": "49000",
        "dep": "49",
        "id": 19
    },
    "villeArrivee": {
        "codeInsee": "69300",
        "ville": "Lyon",
        "codePostal": "69000",
        "dep": "69",
        "id": 5
    },
    "typeTrajet": {
        "typeTrajet": "Régulier",
        "id": 1
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

##### Réponse (exemple)
200 OK

```json
[
    {
        "dateDepart": {
            "date": "2020-02-05 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "Europe/Paris"
        },
        "heureDepart": {
            "date": "1970-01-01 20:20:00.000000",
            "timezone_type": 3,
            "timezone": "Europe/Paris"
        },
        "nbPlace": 3,
        "duree": 3,
        "commentaire": null,
        "nbKm": 318,
        "id": 3,
        "villeDepart": {
            "codeInsee": "13200",
            "ville": "Marseille",
            "codePostal": "13000",
            "dep": "13",
            "id": 4
        },
        "villeArrivee": {
            "codeInsee": "66136",
            "ville": "Perpignan",
            "codePostal": "66000",
            "dep": "66",
            "id": 30
        },
        "typeTrajet": {
            "typeTrajet": "Ponctuel",
            "id": 2
        }
    },
    {
        //...
    }
]
```

<br>
<div class="page-break"></div>

#### <span class="delete">DELETE</span> Trajets

Supprime un trajet. Impossible si ce trajet est utilisé dans un covoiturage

`DELETE foang.cir3-frm-smf-ang-xx/api/trajets/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                            |
| --------------- | --------------------- | --------- | -------------------------------------- |
| id              | Number (int)          | NON       | Identifiant du trajet à récupérer      |

##### Réponse (exemple)
200 OK