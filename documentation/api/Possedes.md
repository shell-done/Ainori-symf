# Possedes

## Informations générales
#### Description
Un possede représente une voiture appartenant à un utilisateur.

#### Attributs complets de Possede
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| immatriculation | String                | NON      | Immatriculation du véhicule            |
| nbPlace         | Number (int)          | NON      | Nombre de place dans le véhicule       |
| utilisateur     | Object (Utilisateur)  | NON      | Utilisateur possédant le véhicule      |
| voiture         | Object (Voiture)      | NON      | Voiture associée                       |

#### Attributs résumés de Possede
| Variable        | Type                  | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | NON      | Identifiant unique                     |
| immatriculation | String                | NON      | Immatriculation du véhicule            |
| nbPlace         | Number (int)          | NON      | Nombre de place dans le véhicule       |
| voiture         | Object (Voiture)      | NON      | Voiture associée                       |

#### Résumé des requêtes
| Méthode                            | Requête                                                |
| ---------------------------------- | ------------------------------------------------------ |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/possedes/utilisateur/:id |
| <span class="get">GET</span>       | foang.cir3-frm-smf-ang-xx/api/possedes/:id             |

<br>
<div class="page-break"></div>

## Requêtes
#### <span class="get">GET</span> PossedesOfUtilisateur

Retourne une liste de possedes appartenant à un utilisateur.

`GET foang.cir3-frm-smf-ang-xx/api/possedes/utilisateur/:id`

##### Paramètres
| Variable        | Type                  | Optionnel | Description                              |
| --------------- | --------------------- | --------- | ---------------------------------------- |
| id              | Number (int)          | NON       | Identifiant de l'utilisateur à récupérer |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
|                 | Retourne 'Attributs complets de Possede'                                  |

'Attributs complets de Possede' (exemple) :

```json
[
    {
        "immatriculation": "BE-256-AB",
        "nbPlace": 5,
        "id": 11,
        "voiture": {
            "modele": "Hilux",
            "id": 20,
            "marque": {
                "marque": "Toyota",
                "id": 11
            }
        },
        "utilisateur": {
            "mail": "mhanson265@nosnahwehttam.net",
            "nom": "Hanson",
            "prenom": "Matthew",
            "password": "$2y$13$aCUTquhA159Dmt1Hu0rMI.Lil0UbphmVMWx8ZYNjG/KkJQfpKXlk2",
            "telephone": "2785185676",
            "adresse": "750 Melon Terrace",
            "id": 9
        }
    },
    {
        //...
    }
]
```

<br>
<div class="page-break"></div>

#### <span class="get">GET</span> Possede

Retourne un possede spécifique.

`GET foang.cir3-frm-smf-ang-xx/api/possedes/:id`

##### Paramètres
| Variable        | Type                        | Optionnel | Description                            |
| --------------- | --------------------------- | --------- | -------------------------------------- |
| id              | Number (int)                | NON       | Identifiant de possede à récupérer     |

##### Réponse
| Statut          | Signification                                                             |
| --------------- | ------------------------------------------------------------------------- |
| 200 OK          | La ressource a été récupérée et est retransmise dans le corps du message. |
|                 | Retourne 'Attributs résumés de Possede'                                   |
| 404 Not Found   | Le serveur n'a pas trouvé la ressource demandée. L'id fournit n'est       |
|                 | probablement associé à aucun possede.                                     |

'Attributs résumés de Possede' (exemple) :

```json
{
    "immatriculation": "XU-358-CE",
    "nbPlace": 5,
    "id": 4,
    "voiture": {
        "modele": "2008",
        "id": 6,
        "marque": {
            "marque": "Peugeot",
            "id": 1
        }
    }
}
```