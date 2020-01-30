# Marques

## Informations générales
#### Description
Une marque représente la marque de la voiture associée à un trajet.

#### Attributs complets de Marque
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| marque          | String                | NON      | Marque de la voiture                   |

#### Résumé des requêtes
| Méthode                            | Requête                                      |
| ---------------------------------- | ---------------------------------------------|
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/marques        |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> Marques

Retourne une liste de marques.

`GET foang.cir3-frm-smf-ang-xx/api/marques`

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
|                 | Retourne 'Attributs complets de Marque'                                   |

'Attributs complets de Marque' (exemple) :

```json
[
    {
        "marque": "Peugeot",
        "id": 1
    },
    {
        "marque": "Renault",
        "id": 2
    },
    {
        "marque": "Opel",
        "id": 3
    },
    {
        "marque": "Citroën",
        "id": 4
    },
    {
        "marque": "Volkswagen",
        "id": 5
    },
    {
        //...
    }
]
```