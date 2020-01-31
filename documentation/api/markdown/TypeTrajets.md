# TypeTrajets

## Informations générales
#### Description
Un typeTrajet indique si le trajet est régulier ou ponctuel.

#### Attributs complets d'un TypeTrajet
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| typeTrajet      | String                | NON      | Type de trajet                         |

#### Résumé des requêtes
| Méthode                            | Requête                                      |
| ---------------------------------- | ---------------------------------------------|
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/typetrajets    |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> TypeTrajets

Retourne une liste de typeTrajets.

`GET foang.cir3-frm-smf-ang-xx/api/typetrajets`

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. Retourne 'Attributs complets de TypeTrajets' |

'Attributs complets de TypeTrajets' (exemple) :

```json
[
    {
        "typeTrajet": "Régulier",
        "id": 1
    },
    {
        "typeTrajet": "Ponctuel",
        "id": 2
    }
]
```