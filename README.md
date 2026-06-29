# Webdevoo Landing

Application dédiée à l'optimisation de la conversion pour les professionnels de la Baie de Somme (gîtes, artisans et commerçants). Le projet propose plusieurs landing pages spécialisées, des simulateurs interactifs, un système d'analytics personnalisé ainsi qu'une interface d'administration sécurisée.

---

# 📚 Sommaire

- Présentation
- Fonctionnalités
- Technologies
- Documentation
- Prérequis
- Installation
- Configuration
- Base de données
- Sécurité
- Lancement
- Tests
- Déploiement
- Journal de l'IA
- Contributeurs

---

# ✨ Fonctionnalités

- Landing pages optimisées pour la conversion
- Simulateurs interactifs
- Formulaire de contact
- Interface d'administration
- Authentification via sessions PHP
- Tableau de bord Analytics
- API REST en PHP
- Tests unitaires et End-to-End

---

# 🚀 Technologies

### Frontend

- Vue.js 3
- TypeScript
- Vite
- Pinia
- Vue Router

### Backend

- PHP 8
- Architecture MVC personnalisée
- MySQL

### Tests

- Vitest
- Cypress

### Build

- Bun (recommandé)
- NPM

---

# 📚 Documentation

Une documentation technique plus détaillée est disponible dans les fichiers suivants :

- `documentation.md`
- `structure.md`

---

# 📋 Prérequis

Avant de commencer, assurez-vous de disposer de :

- PHP 8.2 ou supérieur
- MySQL ou MariaDB
- Git
- Bun (recommandé) ou Node.js avec NPM

---

# 🛠 Installation

## 1. Cloner le dépôt

```bash
git clone <url-du-projet>
```

## 2. Installer les dépendances

Avec Bun :

```bash
bun install
```

Ou avec NPM :

```bash
npm install
```

### Dépendances du backend

Avec Composer :

```bash
cd api
composer install
```

## 3. Configuration

Copiez le fichier `.env.example` :

```bash
cp .env.example .env.development
cp .env.example .env.production
cp api/.env.example api/.env
```

Pensez à modifier les valeurs du .env.

---

# ⚙️ Configuration Backend

## Variables d'environnement

Dans `/api`, configurez votre fichier `.env` :

```env
BDD_MODE=dev
BDD_PASSWORD=votremdpbdd
PASSWORD_ENCRYPT_KEY=VotreCleDeCryptage
PASSWORD_ENCRYPT_ALG=aes-256-gcm
```

## Configuration de l'API

Copiez les fichiers suivants :

```text
/api/config/.htaccess.example → /api/config/.htaccess
/api/config/.htpasswd.example → /api/config/.htpasswd
/api/config/config.example → /api/config/config.json
```

```bash
cp api/config/.htaccess.example api/config/.htaccess
```

```bash
cp api/config/.htpasswd.example api/config/.htpasswd
```

```bash
cp api/config/config.example.json api/config/config.json
```

**Adaptez ensuite leur contenu à votre environnement.**

Le fichier `config.json` permet notamment de configurer :

- les dossiers chargés automatiquement ;
- les connexions aux bases de données ;
- le chemin de base de l'application.

---

# 🗄️ Base de données

Les scripts SQL sont disponibles dans le dossier :

```text
/api/sql/
```

Importez les tables SQL :

```bash
api/sql/users.sql
api/sql/analytics_event.sql
```

---

# 🔐 Sécurité

Le backend permet de chiffrer les identifiants de connexion à la base de données grâce aux variables suivantes :

- `PASSWORD_ENCRYPT_KEY`
- `PASSWORD_ENCRYPT_ALG`
- `encrypted_password`
- `iv`
- `tag`

## Encrypter vos informations

Rendez-vous sur : 
```bash
http://127.0.0.1:5500/encrypt.php
```

Pour créer des données cryptées, vous pouvez utiliser le fichier `/api/encrypt.php`, qui vous permettra d'ajouter simplement un mot de passe à crypter, puis de déclencher le fichier, pour récupérer les informations à inclure à votre fichier `/api/config/config.json`.
⚠️ Sans ces données encryptées, vous ne pourrez pas vous connecter à la base de données.

Les identifiants peuvent ainsi être stockés de manière chiffrée dans `config.json` pour les environnements de production.

L'authentification de l'application repose sur les **sessions PHP** avec des cookies sécurisés (`HttpOnly`, `Secure` et `SameSite=Lax` en production).

---

# ▶️ Lancement

## Frontend

```bash
bun run dev
```

## Backend

```bash
php -S 127.0.0.1:5500
```

> Pensez à démarrer votre serveur PHP ainsi que votre serveur MySQL avant de lancer l'application.

---

# 🧪 Tests

Le projet dispose d'une suite complète de tests unitaires et End-to-End.

## Tests End-to-End (Cypress)

Mode CI :

```bash
bun run test:e2e
```

Mode interactif :

```bash
bun run test:e2e:dev
```

## Tests unitaires (Vitest)

Lancer les tests :

```bash
bun run test:unit
```

Avec couverture :

```bash
bun run test:unit:coverage
```

---

# 🚀 Déploiement

Compiler le frontend :

```bash
bun run build
```

Puis :

- configurer les fichiers d'environnement de production ;
- déployer le contenu du dossier `dist` ;
- déployer le dossier `api` sur le serveur.

---

# 🤖 Journal de l'IA

Dans le cadre de ce projet, l'intelligence artificielle (Gemini) a été utilisée comme assistant technique afin d'accélérer certaines phases de développement, principalement sur des problématiques d'architecture, de configuration, de débogage et de tests.

## Configuration et sécurité

L'IA a contribué à :

- la configuration du proxy Vite ;
- la mise en place des en-têtes CORS ;
- la sécurisation des cookies de session (`Secure`, `HttpOnly`, `SameSite=Lax`) ;
- l'organisation des variables d'environnement.

## Architecture backend

L'IA a participé à la réflexion autour :

- du système de routage sécurisé ;
- du contrôle des rôles utilisateurs ;
- de la gestion des sessions PHP ;
- de la standardisation des réponses JSON ;
- de l'amélioration du chargement automatique des classes.

## Débogage et maintenance

L'assistance de l'IA a permis notamment de :

- analyser des erreurs PHP complexes ;
- résoudre des problèmes de sérialisation d'objets ;
- améliorer certaines requêtes SQL ;
- optimiser plusieurs méthodes du backend.

## Tests

L'IA a également assisté la création :

- des tests unitaires avec Vitest ;
- des mocks d'API ;
- des tests des composables (`useAuth`, `useTracker`) ;
- des tests des stores Pinia ;
- des scénarios End-to-End avec Cypress pour les différentes landing pages et l'interface d'administration.

## Validation

Toutes les propositions générées par l'IA ont été systématiquement relues, adaptées, testées puis intégrées manuellement afin de garantir leur cohérence avec l'architecture du projet.

L'utilisation de l'IA est restée limitée à un rôle d'assistance technique. Les choix d'architecture, les développements finaux et les validations fonctionnelles ont été réalisés manuellement.

---

# 👥 Contributeur

**Valérian Dufrène**

## Entreprise

**Webdevoo**
