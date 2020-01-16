# Trajets

## Informations générales
### Description
Un trajet représente un trajet de covoiturage entre deux villes. L'utilisateur créant un trajet est automatiquement définit comme étant le conducteur sur ce trajet (cf. requêtes Covoiturage)

### Attributs d'un Trajet
| Type            | Variable              | Nullable | Description                            |
| --------------- | --------------------- | -------- | -------------------------------------- |
| id              | Number (int)          | false    | Identifiant unique                     |
| dateDepart      | Object (Datetime)     | false    | Date de départ                         |
| heureDepart     | Object (Datetime)     | false    | Heure de départ                        |
| nbPlace         | Number (int)          | false    | Nombre de place passager               |
| duree           | Number (float)        | true     | Durée du trajet                        |
| commentaire     | String                | true     | Commentaire                            |
| nbKm            | Number (float)        | false    | Distance du trajet                     |
| possede         | Object (Possede)      | false    | Véhicule possédé utilisé               |
| typeTrajet      | Object (TypeTrajet)   | false    | Type de trajet                         |
| villeDepart     | Object (Ville)        | false    | Ville de départ                        |
| villeArrivee    | Object (Ville)        | false    | Ville d'arrivée                        |

### Méthodes autorisées :
 * GET    : Récupération d'une ressource ou d'une liste de ressources
 * POST   : Création et modification d'une ressource
 * DELETE : Suppression d'une ressource

----

## Requêtes détaillées
### Récupérer un Trajet

#### Requête
GET : foang.cir3-frm-smf-ang-xx/api/trajets/id

#### Paramètres
| Type            | Variable              | Description                            |
| --------------- | --------------------- | -------------------------------------- |
| id              | Number (int)          | Identifiant du trajet à récupérer      |

#### Réponse
200 OK

```json
    {
        "dateDepart": {
            "date":"2020-01-04 00:00:00.000000",
            "timezone_type":3,
            "timezone":"Europe/Paris"
            },
        "heureDepart":{
            "date":"1970-01-01 10:10:00.000000",
            "timezone_type":3,
            "timezone":"Europe/Paris"
            },
        "nbPlace":6,
        "duree":5.36,
        "commentaire":null,
        "nbKm":597,
        "id":2
    }
```
