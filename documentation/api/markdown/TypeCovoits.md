# TypeCovoits

## Informations générales
#### Description
Un typeCovoit indique si un utilisateur a réservé un covoiturage en tant que conducteur ou passager.

#### Attributs complets d'un TypeCovoit
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| type            | String                | NON      | Type de covoiturage                    |

#### Résumé des requêtes
| Méthode                            | Requête                                      |
| ---------------------------------- | ---------------------------------------------|
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/typecovoits    |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> TypeCovoits

Retourne une liste de typeCovoits.

`GET foang.cir3-frm-smf-ang-xx/api/typecovoits`

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. Retourne 'Attributs complets de TypeCovoit' |

'Attributs complets de TypeCovoit' (exemple) :

```json
[
    {
        "type": "Conducteur",
        "id": 1
    },
    {
        "type": "Passager",
        "id": 2
    }
]
```