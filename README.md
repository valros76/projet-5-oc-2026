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

## 👥 Contributeurs

* Valérian Dufrène

### Entreprise

Webdevoo
