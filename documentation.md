# Documentation des Interactions Frontend ↔ Backend

## Objectif

Ce document décrit les interactions entre l'application Vue.js (frontend) et l'API PHP MVC (backend).

Il permet aux développeurs de :

- comprendre les flux applicatifs ;
- identifier les endpoints utilisés ;
- connaître les formats de données échangés ;
- faciliter la maintenance et les évolutions.

---

# Architecture Générale

```text
Navigateur
    │
    ▼
Frontend Vue.js (Vite)
    │
    ├── Vue Router
    ├── Composables
    ├── Components
    │
    ▼
API PHP MVC
    │
    ├── Routes
    ├── Controllers
    ├── Models
    │
    ▼
MySQL
```

---

# Technologies utilisées

## Frontend

- Vue.js
- Vite
- Vue Router
- Pinia
- TypeScript

## Backend

- PHP (architecture MVC)
- API REST

## Base de données

- MySQL

---

# Pages Frontend

## Pages publiques

| URL                                                               | Vue                   |
| ----------------------------------------------------------------- | --------------------- |
| /                                                                 | HomeView.vue          |
| /gites/site-pour-gite-en-baie-de-somme                            | CottageLanding.vue    |
| /artisans/site-pour-artisan-en-baie-de-somme                      | ArtisanLanding.vue    |
| /commercants/site-pour-boutique-commercant-local-en-baie-de-somme | MerchantLanding.vue   |
| /nous-contacter                                                   | ContactView.vue       |
| /message-envoye                                                   | MessageSend.vue       |
| /nous-recontacter                                                 | ContactError.vue      |
| /rgpd                                                             | RGPDView.vue          |
| /cgu-cgv                                                          | CGUAndCGVView.vue     |
| /mentions-legales                                                 | LegalMentionsView.vue |

## Administration

| URL                 | Vue                 |
| ------------------- | ------------------- |
| /admin/register     | RegisterAdmin.vue   |
| /admin/disconnect   | DisconnectAdmin.vue |
| /admin/statistiques | TrackingStats.vue   |

---

# API Backend

## Vue d'ensemble

| Méthode | Endpoint                       | Contrôleur                         |
| ------- | ------------------------------ | ---------------------------------- |
| POST    | /api/contact                   | ContactController::SendMail()      |
| POST    | /contact                       | ContactController::SendMail()      |
| POST    | /api/v1/auth/register          | AuthController::Register()         |
| POST    | /api/v1/auth/connexion         | AuthController::Connect()          |
| POST    | /api/v1/analytics              | AnalyticsController::SaveEvent()   |
| GET     | /api/v1/analytics/view-events  | AnalyticsController::ViewEvents()  |
| GET     | /api/v1/analytics/count-events | AnalyticsController::CountEvents() |
| GET     | /api/test                      | TestController::Test()             |
| GET     | /api/v1/welcome                | WelcomeController::HelloWorld()    |

---

# Contact

## Envoi du formulaire de contact

```http
POST /api/contact
```

ou

```http
POST /contact
```

### Payload

```json
{
    "reason": formDatas.value.reason.value,
    "email": formDatas.value.email.value,
    "message": formDatas.value.message.value,
    "returnDate": formDatas.value.returnDate.value,
    "rgpd": formDatas.value.rgpd.value,
}
```

### Contrôleur

```text
ContactController::SendMail()
```

### Résultat attendu

```json
{
  "status": 200
}
```

---

# Authentification

## Création d'un administrateur

```http
POST /api/v1/auth/register
```

### Payload

```json
{
  "user": {
    "email": "",
    "password": "",
    "is_admin": true
  }
}
```

### Contrôleur

```text
AuthController::Register()
```

---

## Connexion administrateur

```http
POST /api/v1/auth/connexion
```

### Payload

```json
{
  "user": {
    "email": "",
    "password": ""
  }
}
```

### Contrôleur

```text
AuthController::Connect()
```

### Réponse attendue

```json
{
  "message" : "L'utilisateur est authentifié.",
  "params" : [{"id": 42, "email": "admin42@mail.com", "is_admin": 1, "inscription_date": "2021-02-09 13:21:09"}],
  "status" : 200
}
```

---

# Analytics

Le système Analytics est utilisé pour suivre les interactions des visiteurs.

---

## Enregistrement d'un évènement

```http
POST /api/v1/analytics
```

### Payload

```json
{
  "event_name": "calculator_submit",
  "page_url": "/gites/site-pour-gite-en-baie-de-somme",
  "metadata": {
    "commissions": 1200
  }
}
```

### Contrôleur

```text
AnalyticsController::SaveEvent()
```

### Table concernée

```sql
analytics_events
```

---

## Consultation des évènements

```http
GET /api/v1/analytics/view-events
```

### Contrôleur

```text
AnalyticsController::ViewEvents()
```

### Réponse

```json
[
  {
    "id": 1,
    "event_name": "calculator_submit",
    "page_url": "/gites/site-pour-gite-en-baie-de-somme",
    "metadata": {},
    "created_at": "2026-01-01 12:00:00"
  }
]
```

---

## Comptage des évènements

```http
GET /api/v1/analytics/count-events
```

### Contrôleur

```text
AnalyticsController::CountEvents()
```

### Réponse

```json
{
  "total": 1254
}
```

---

# API de test

```http
GET /api/test
```

### Paramètres

| Paramètre |
| --------- |
| value     |

### Contrôleur

```text
TestController::Test()
```

---

# Welcome API

Endpoint de validation du bon fonctionnement de l'API.

```http
GET /api/v1/welcome
```

### Contrôleur

```text
WelcomeController::HelloWorld()
```

### Réponse

```json
{
  "message": "Hello World"
}
```

---

# Flux Métier

## Flux général

```text
Utilisateur
    │
    ▼
Vue Router
    │
    ▼
Composant Vue
    │
    ▼
Composable
    │
    ▼
API PHP MVC
    │
    ▼
Controller
    │
    ▼
Model
    │
    ▼
MySQL
```

---

## Landing Gîte

```text
Utilisateur
    │
    ▼
Simulation économies Airbnb
    │
    ▼
Analytics SaveEvent
    │
    ▼
Contact
    │
    ▼
ContactController
    │
    ▼
Envoi Email
```

---

## Landing Artisan

```text
Utilisateur
    │
    ▼
Simulation devis
    │
    ▼
Analytics SaveEvent
    │
    ▼
Contact
    │
    ▼
ContactController
```

---

## Landing Commerçant

```text
Utilisateur
    │
    ▼
Simulation ventes
    │
    ▼
Analytics SaveEvent
    │
    ▼
Formulaire Contact
```

---

# Gestion des Erreurs

## Erreurs Frontend

| Cas                 |
| ------------------- |
| Route inexistante   |
| Erreur API          |
| Formulaire invalide |

Vue concernée :

```text
404.vue
```

---

## Erreurs Backend

| HTTP | Description              |
| ---- | ------------------------ |
| 400  | Requête invalide         |
| 401  | Authentification requise |
| 403  | Accès refusé             |
| 404  | Ressource introuvable    |
| 500  | Erreur interne           |

---

# Tables utilisées

## user

```sql
user
```

Utilisée par :

- AuthController
- User

---

## analytics_events

```sql
analytics_events
```

Utilisée par :

- AnalyticsController
- Analytics

---

# Remarques

Cette documentation décrit les interactions actuellement implémentées entre le frontend Vue.js et l'API PHP MVC. Elle devra être mise à jour à chaque ajout, modification ou suppression d'un endpoint, d'une route frontend ou d'un flux métier afin de rester cohérente avec l'application.
