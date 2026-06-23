# Structure du Projet Webdevoo Landing

Le projet est divisé en deux parties principales : le frontend (Vite/Vue) et le backend (PHP MVC).

## 📂 Organisation des dossiers

### Frontend (`/src`)

* `components/` : Composants UI réutilisables (Dialogs, Layouts, Navigation).
* `composables/` : Logique métier partagée (ex. : `useTracker`, `useAuth`).
* `stores/` : État global de l'application (Pinia).
* `views/landing/` : Landing pages spécifiques (cottage, artisan, merchant).
* `utils/` : Fonctions utilitaires (debounce, formatters, helpers, etc.).

### Backend (`/api`)

Architecture MVC personnalisée :

* `controllers/` : Gestion des requêtes (`AuthController`, `AnalyticsController`, etc.).
* `models/` : Interaction avec la base de données (entités comme `User`, `Analytics`).
* `routes/` : Définition des endpoints et routage des requêtes.
* `exceptions/` : Gestion centralisée des erreurs PHP.
* `sql/` : Schémas, migrations et scripts de base de données.

### Tests (`/cypress`)

* `e2e/` : Scénarios de tests end-to-end pour valider les parcours utilisateurs (connexion, calculatrices, pagination, formulaires, etc.).

### Ressources (`/public` & `/assets`)

* `assets/` : Contient les images, logos, polices (BeauSans, Figtree) et vidéos promotionnelles.
* `public/` : Fichiers statiques accessibles directement par le navigateur.
* `serviceWorker.js` : Gestion du cache et des fonctionnalités hors ligne.

## 🏗️ Architecture Générale

```text
webdevoo-landing/
├── api/
│   ├── controllers/
│   ├── models/
│   ├── routes/
│   ├── exceptions/
│   └── sql/
├── src/
│   ├── components/
│   ├── composables/
│   ├── stores/
│   ├── views/
│   │   └── landing/
│   └── utils/
├── cypress/
│   └── e2e/
├── public/
├── assets/
├── .env
├── vite.config.ts
├── package.json
└── README.md
```

## 📌 Objectif

Cette structure vise à séparer clairement la logique métier, l'interface utilisateur et les services backend afin de faciliter la maintenance, les tests et l'évolution du projet.
