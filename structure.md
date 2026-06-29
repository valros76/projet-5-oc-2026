# Structure du Projet Webdevoo Landing

## Objectif

Le projet est composé de deux applications distinctes :

- un frontend développé avec Vue.js, TypeScript et Vite ;
- un backend développé en PHP suivant une architecture MVC.

Cette séparation permet d'isoler l'interface utilisateur, la logique métier et l'accès aux données afin de faciliter la maintenance, les tests et les évolutions.

---

# Organisation générale

```text
Navigateur
      │
      ▼
Frontend Vue.js
      │
      ▼
API PHP MVC
      │
      ▼
MySQL
```

---

# Structure du Frontend

Le frontend est principalement contenu dans le dossier `src`.

## components/

Contient les composants Vue réutilisables utilisés dans plusieurs pages.

Exemples :

- composants d'administration ;
- composants de formulaire ;
- composants d'illustration ;
- composants communs.

---

## composables/

Contient la logique métier réutilisable sous forme de composables.

Exemples :

- authentification (`useAuth`)
- analytics (`useTracker`)

---

## interfaces/

Contient les interfaces TypeScript utilisées dans l'application.

Exemples :

- utilisateurs
- analytics
- zones géographiques

---

## router/

Contient la configuration de Vue Router.

Responsabilités :

- déclaration des routes ;
- gestion de la navigation ;
- page 404.

---

## stores/

Contient les stores Pinia.

Responsabilités :

- authentification ;
- cookies ;
- analytics ;
- autres états globaux de l'application.

---

## utils/

Fonctions utilitaires réutilisables.

Exemple :

- debounce

---

## views/

Contient les différentes pages de l'application.

On y retrouve notamment :

- HomeView.vue
- ContactView.vue
- MessageSend.vue
- ContactError.vue
- RGPDView.vue
- CGUAndCGVView.vue
- LegalMentionsView.vue
- TrackingStats.vue
- CottageLanding.vue
- ArtisanLanding.vue
- MerchantLanding.vue

---

## test/

Configuration utilisée pour les tests unitaires.

---

## main.ts

Point d'entrée de l'application Vue.

Responsabilités :

- création de l'application ;
- chargement des plugins ;
- montage de Vue.

---

# Structure du Backend

Le backend repose sur une architecture MVC.

Les principaux dossiers sont :

## controllers/

Contient les contrôleurs responsables du traitement des requêtes HTTP.

Exemples :

- AuthController
- ContactController
- AnalyticsController
- WelcomeController
- TestController

---

## models/

Contient les modèles responsables des interactions avec la base de données.

Exemples :

- User
- Analytics
- Contact

---

## routes/

Déclaration des routes de l'API.

Les routes redirigent les requêtes HTTP vers les contrôleurs appropriés.

---

# Base de données

Le backend utilise MySQL.

Les principales tables actuellement utilisées sont :

- user
- analytics_events
- sav

---

# Tests

Le projet contient plusieurs niveaux de tests.

## Tests unitaires

Utilisent :

- Vitest
- Vue Test Utils

Configuration :

- vitest.config.ts

---

## Tests End-to-End

Réalisés avec Cypress.

Ils permettent de tester les parcours utilisateurs complets.

Exemples :

- navigation
- formulaires
- authentification
- landing pages

---

# Ressources statiques

## public/

Contient les fichiers accessibles directement par le navigateur.

---

## assets/

Contient notamment :

- images ;
- polices ;
- feuilles de style.

---

# Configuration

Les principaux fichiers de configuration sont :

| Fichier | Rôle |
|---------|------|
| package.json | Dépendances et scripts |
| vite.config.ts | Configuration de Vite |
| vitest.config.ts | Configuration de Vitest |
| tsconfig.json | Configuration TypeScript |
| tsconfig.app.json | Configuration TypeScript de l'application |
| env.d.ts | Déclarations TypeScript pour Vite |
| .env | Variables d'environnement |
| .env.production | Variables de production |

---

# Architecture simplifiée

```text
webdevoo-landing/
│
├── api/
│   ├── controllers/
│   ├── models/
│   └── routes/
│
├── src/
│   ├── components/
│   ├── composables/
│   ├── interfaces/
│   ├── router/
│   ├── stores/
│   ├── test/
│   ├── utils/
│   ├── views/
│   └── main.ts
│
├── public/
├── cypress/
│   └── e2e/
│
├── package.json
├── vite.config.ts
├── vitest.config.ts
├── tsconfig.json
├── tsconfig.app.json
├── env.d.ts
├── .env
└── .env.production
```

---

# Flux général

```text
Utilisateur
      │
      ▼
Vue Router
      │
      ▼
Vue Component
      │
      ▼
Composable
      │
      ▼
Requête HTTP
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

# Remarques

Cette documentation décrit l'organisation actuelle du projet. Elle devra être mise à jour lors de l'ajout, de la suppression ou de la réorganisation de dossiers, composants, services ou modules afin de rester cohérente avec l'architecture du projet.