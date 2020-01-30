# Villes

## Informations générales
#### Description
Une ville indique le point de départ et le point d'arrivée d'un trajet. Un utilisateur est également obligatoirement associé
à une ville.

#### Attributs complets d'une Ville
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| codeInsee       | Number (int)          | NON      | Code INSEE de la ville                 |
| ville           | String                | NON      | Nom de la ville                        |
| codePostal      | Number (int)          | NON      | Code postal de la ville                |
| dep             | Number (int)          | NON      | Numéro du département de la ville      |

#### Attributs résumés d'une Ville
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| ville           | String                | NON      | Nom de la ville                        |

#### Résumé des requêtes
| Méthode                            | Requête                                    |
| ---------------------------------- | ------------------------------------------ |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/villes/:id   |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/villes       |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> Ville

Retourne une ville spécifique.

`GET foang.cir3-frm-smf-ang-xx/api/villes/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                            |
| --------------- | --------------------- | --------- | -------------------------------------- |
| id              | Number (int)          | NON       | Identifiant de la ville à récupérer    |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
|                 | Retourne 'Attributs complets de Ville'                                    |
| 404 Not Found   | Le serveur n'a pas trouvé la ressource demandée. L'id fournit n'est       |
|                 | probablement associé à aucune ville.                                      |

'Attributs complets de Ville' (exemple) :

```json
{
    "codeInsee": "35238",
    "ville": "Rennes",
    "codePostal": "35000",
    "dep": "35",
    "id": 1
}
```

<br>
<div class="page-break"></div>

#### <span class="get">GET</span> Villes

Retourne une liste de villes.

`GET foang.cir3-frm-smf-ang-xx/api/villes`

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
|                 | Retourne 'Attributs résumés de Ville'                                     |

'Attributs résumés de Ville' (exemple) :

```json
[
    {
        "id": 1,
        "ville": "Rennes"
    },
    {
        "id": 2,
        "ville": "Brest"
    },
    {
        "id": 3,
        "ville": "Paris"
    },
    {
        "id": 4,
        "ville": "Marseille"
    },
    {
        "id": 5,
        "ville": "Lyon"
    },
    {
        //...
    }
]
```