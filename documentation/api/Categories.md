# Categories

## Informations générales
#### Description
Une catégorie indique le statut de l'utilisateur.

#### Attributs complets de Categorie
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| categorie       | String                | NON      | Catégorie de l'utilisateur             |

#### Résumé des requêtes
| Méthode                            | Requête                                      |
| ---------------------------------- | ---------------------------------------------|
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/categories     |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> Categories

Retourne une liste de categories.

`GET foang.cir3-frm-smf-ang-xx/api/categories`

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
|                 | Retourne 'Attributs complets de Categorie'                                |

'Attributs complets de Categorie' (exemple) :

```json
[
    {
        "categorie": "Étudiant",
        "id": 1
    },
    {
        "categorie": "Enseignant",
        "id": 2
    },
    {
        "categorie": "Intervenant extérieur",
        "id": 3
    },
    {
        "categorie": "Autre",
        "id": 4
    }
]
```