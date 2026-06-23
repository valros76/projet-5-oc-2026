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
