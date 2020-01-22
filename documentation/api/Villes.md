# Villes

## Informations générales
#### Description
Une ville indique le point de départ et le point d'arrivée d'un trajet. Un utilisateur est également obligatoirement associé
à une ville.

#### Attributs d'un Trajet
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| codeInsee       | Number (int)          | NON      | Code INSEE de la ville                 |
| ville           | String                | NON      | Nom de la ville                        |
| codePostal      | Number (int)          | NON      | Code postal de la ville                |
| dep             | Number (int)          | NON      | Numéro du département de la ville      |

#### Résumé des requêtes
| Méthode                            | Requête                                    |
| ---------------------------------- | ------------------------------------------ |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/villes/:id   |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/villes       |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> Ville

Retourne une ville spécifique

`GET foang.cir3-frm-smf-ang-xx/api/villes/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                            |
| --------------- | --------------------- | --------- | -------------------------------------- |
| id              | Number (int)          | NON       | Identifiant de la ville à récupérer    |

##### Réponse (exemple)
200 OK

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

##### Réponse (exemple)
200 OK

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