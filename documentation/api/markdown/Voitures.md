# Voitures

## Informations générales
#### Description
Une voiture représente la voiture utilisée pour un trajet.

#### Attributs complets de Voiture
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| modele          | String                | NON      | Modèle de la voiture                   |
| marque          | Object (Marque)       | NON      | Marque de la voiture                   |

#### Résumé des requêtes
| Méthode                            | Requête                                      |
| ---------------------------------- | ---------------------------------------------|
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/voitures/:id   |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> Voitures

Retourne une liste de voitures spécifiques par rapport à la marque.

`GET foang.cir3-frm-smf-ang-xx/api/voitures/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                            |
| --------------- | --------------------- | --------- | -------------------------------------- |
| id              | Number (int)          | NON       | Identifiant de la marque à récupérer   |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. Retourne 'Attributs complets de Voiture' |

'Attributs complets de Voiture' (exemple) :

```json
[
    {
        "modele": "C3",
        "id": 3,
        "marque": {
            "marque": "Citroën",
            "id": 4
        }
    }
]
```