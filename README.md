# Webdevoo Landing

Application dédiée à l'optimisation de la conversion pour les professionnels de la Baie de Somme (gîtes, artisans, commerçants). Ce projet vise à résoudre leurs points de friction métier grâce à des outils de calcul interactifs et une présence en ligne optimisée.

## 🚀 Technologies

* **Frontend** : Vue.js 3, TypeScript, Vite.
* **Backend** : PHP 8 (Architecture MVC personnalisée).
* **Tests** : Cypress (E2E), Vitest (Unit).
* **Build** : Bun (recommandé) ou NPM.

## 🛠 Installation

### 1. Cloner le dépôt

```bash
git clone <url-du-projet>
```

### 2. Installation des dépendances

```bash
# Avec Bun (recommandé)
bun install

# Ou avec NPM
npm install
```

### 3. Configuration

Copiez le fichier `.env.example` vers `.env` et configurez vos variables :

```bash
cp .env.example .env
```

### 4. Lancement

```bash
# Mode développement
bun run dev
```

## ⚙️ Configuration Backend

### Fichier `.env`

Créez un fichier `.env` à la racine du projet à partir de `.env.example` :

```env
BDD_MODE=dev # dev ou prod

PASSWORD_ENCRYPT_KEY=VotreCleDeCryptage
PASSWORD_ENCRYPT_ALG=aes-256-gcm
```

### Configuration de la base de données

Le backend contient des fichiers au format **.example**, vous devez changer l'extension des fichiers en fonctions de leurs type.

- /api/config/.htaccess.example > */api/config/.htaccess*
- /api/config/.htpasswd.example > */api/config/.htpasswd*
- /api/config/config.example > */api/config/config.json*

Il faudra, bien sûr, personnaliser leur contenu en fonction de vos besoins et de votre environnement.

Par exemple, pour config.example.json :
Le backend utilise le fichier `/api/config/config.json` pour gérer les connexions aux bases de données selon l'environnement sélectionné.

```json
{
  "autoloadFolders": [
    "framework",
    "controllers",
    "models",
    "framework/exceptions",
    "utils",
    "utils/exceptions"
  ],
  "database": {
    "dev": {
      "host": "127.0.0.1",
      "dbname": "dbname",
      "username": "username",
      "password": "",
      "encrypted_password": "",
      "iv": "encrypted_password_iv",
      "tag": "encrypted_password_tag"
    },
    "prod": {
      "host": "127.0.0.1",
      "dbname": "dbname",
      "username": "username",
      "password": "",
      "encrypted_password": "encrypted_password",
      "iv": "encrypted_password_iv",
      "tag": "encrypted_password_tag"
    }
  },
  "basepath": ""
}
```

## 🗄️ Base de données

### Table des utilisateurs

```sql
CREATE TABLE user (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    mail VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
```

### Table des événements Analytics

```sql
CREATE TABLE IF NOT EXISTS analytics_events (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    event_name VARCHAR(750) NOT NULL,
    page_url TEXT NOT NULL,
    metadata JSON NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY event_name (event_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

### Import SQL complet

Le fichier SQL fourni dans `/api/sql/` peut être importé directement via phpMyAdmin ou la ligne de commande MySQL :

```bash
mysql -u username -p dbname < api/sql/database.sql
```

## 🔐 Sécurité

Le framework backend supporte le chiffrement des mots de passe de connexion à la base de données via :

* `PASSWORD_ENCRYPT_KEY`
* `PASSWORD_ENCRYPT_ALG`
* `encrypted_password`
* `iv`
* `tag`

Les identifiants de base de données peuvent ainsi être stockés de manière chiffrée dans `config.json` pour les environnements de production.

### 4. Lancement

```bash
# Mode développement
php -S 127.0.0.1:5500
```
**PS** : N'oubliez pas de lancer l'environnement local PHP/MySQL

## 🧪 Tests

Le projet inclut une suite de tests E2E pour valider les parcours utilisateurs critiques.

### Tests E2E (Cypress)

* Lancer en mode headless (CI) :

```bash
bun run test:e2e
```

* Lancer en mode interactif :

```bash
bun run test:e2e:dev
```

### Tests Unitaires (Vitest)

* Lancer les tests :

```bash
bun run test:unit
```

* Avec couverture :

```bash
bun run test:unit:coverage
```

### Mise en production

* Compiler le code front-end (depuis la racine) :

```bash
bun run build
```

* Importer le dossier API.

* Modifier les fichiers d'environnement pour la production.

* Basculer le contenu du dossier **dist** et du dossier **api** sur le FTP.

## 🤖 Journal de l'IA
Dans le cadre de ce projet, j'ai utilisé l'IA (Gemini) comme un collaborateur technique pour m'aider à surmonter des défis d'architecture et de configuration système. Voici les principaux apports de cet outil :

1. Configuration et Sécurité (Backend)
**Gestion des sessions** : Résolution des problématiques de communication entre le frontend (Vue3 sur port 5173) et l'API (PHP/Laragon sur port 5500). L'IA m'a guidé dans la configuration du proxy Vite et des en-têtes CORS nécessaires.

**Sécurisation des cookies** : Implémentation des bonnes pratiques de production (Secure, HttpOnly, SameSite=Lax) pour garantir la sécurité des sessions utilisateur.

**Structuration des variables d'environnement** : Optimisation du fichier index.php pour une bascule fluide entre les environnements de développement (local) et de production, en utilisant phpdotenv (réinterprétation du placement dans le fichier).

2. Architecture et Sécurité (Routage)
**Contrôle d'accès** : Co-conception d'un système de routage sécurisé dans Route.php intégrant :

La vérification de l'authentification via $_SESSION.

La validation des rôles utilisateurs (via UserRole et UserDTO).

La transformation des erreurs PHP fatales en réponses JSON standardisées pour l'API.

**Typage et Intégrité** : Résolution des erreurs de type lors de la désérialisation des objets de session, grâce à la mise en place d'un chargement rigoureux de l'Autoloader.

3. Debugging et Maintenance
**Analyse d'erreurs** : Support pour interpréter les Fatal errors liées aux problèmes d'autoloading et de sérialisation d'objets, permettant d'identifier rapidement le besoin de charger les classes avant session_start().

**Optimisation de code** : Nettoyage des méthodes d'accès aux données (utilisation de fetchColumn() au lieu de fetch()[0]) pour améliorer la robustesse des requêtes SQL dans la classe Analytics.

4. Tests et Qualité (Frontend)
Pour garantir la fiabilité de l'application et sécuriser les évolutions futures, j'ai mis en place une suite de tests unitaires et de composants avec Vitest et Vue Test Utils. L'IA m'a assisté dans la conception de tests couvrant plusieurs couches critiques :

**Tests de Composants (App.vue)** : Vérification du montage correct de l'application avec ses plugins (Pinia, Router) pour assurer l'intégrité du démarrage de l'interface.

**Tests de Composables (Logique métier), par exemple** :

**useAuth** : Simulation des appels API (fetch) pour valider les interactions de connexion et d'inscription (headers, méthodes HTTP, gestion des signaux AbortController).

**useTracker** : Validation de l'envoi de données d'analytics et gestion robuste des erreurs (try/catch, timeouts réseau) pour garantir que le tracking ne bloque jamais l'utilisation principale du site.

**Tests de Stores (Pinia)** : Validation de la persistance des données utilisateur (SessionStorage vs LocalStorage), gestion de l'hydratation du state au démarrage et résilience face aux données corrompues dans le navigateur.

**Tests E2E** : Mise en place de tests E2E avec Cypress, pour : 
- La partie admin
- La partie admin stats
- Les landing pages ajoutées (gîtes / commerçants / artisans)

**Apports de l'IA dans cette étape** : L'IA m'a aidé à structurer les mocks (simulations d'API) pour isoler les tests de la couche réseau, ainsi qu'à gérer les cycles de vie des tests (beforeEach, vi.stubGlobal) pour garantir des environnements de test propres et isolés. La délégation IA a accéléré la création des tests (2h30 au total pour la création de l'intégralité des tests unitaires / e2e).

**Note** : 
L'utilisation de l'IA a été centrée sur le débogage complexe et l'architecture système.
L'intégralité du code a été revue, testée et intégrée manuellement pour s'assurer qu'elle répond aux exigences spécifiques de mon projet.
J'ai eu besoin d'utiliser l'IA, car j'ai voulu, pour ce projet qui nous laisse plus de liberté, utiliser des vieux skeletons PHP existant dans ma codebase d'entreprise, puis les réadapter pour un projet récent, pour accélérer au maximum la conception des nouvelles fonctionnalités.

## 👥 Contributeurs

* Valérian Dufrène

### Entreprise

Webdevoo
