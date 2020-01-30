# TypeVehicules

## Informations générales
#### Description
Un typeVehicule indique le type du véhicule.

#### Attributs complets de TypeVehicule
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| type            | String                | NON      | Type du véhicule                       |

#### Résumé des requêtes
| Méthode                            | Requête                                      |
| ---------------------------------- | ---------------------------------------------|
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/typevehicules  |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> TypeVehicules

Retourne une liste de typeVehicule.

`GET foang.cir3-frm-smf-ang-xx/api/typevehicules`

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
|                 | Retourne 'Attributs complets de TypeVehicule'                             |

'Attributs complets de TypeVehicule' (exemple) :

```json
[
    {
        "type": "Berline",
        "id": 1
    },
    {
        "type": "Break",
        "id": 2
    },
    {
        "type": "Monospace",
        "id": 3
    },
    {
        "type": "Cabriolet",
        "id": 4
    },
    {
        "type": "Coupé",
        "id": 5
    },
    {
        //...
    }
]
```