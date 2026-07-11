# FAQ Développeurs

Cette documentation répond aux principales questions techniques concernant les fonctionnalités implémentées dans le projet.

---

# Landing page - Artisans

## Quel est l'objectif de cette page ?

Cette landing page présente les services proposés aux artisans et met à disposition des outils permettant d'accéder rapidement au diagnostic de visibilité locale ainsi qu'au formulaire de contact.

---

## Quels composants sont utilisés ?

La page utilise les composants suivants :

- `IllustrationImgComponent`
- `DepartmentVisibility`
- `LocalVisibility`
- `ContactForm`

---

## Pourquoi utiliser plusieurs composants ?

Chaque fonctionnalité est isolée dans son propre composant afin de séparer les responsabilités :

- illustration ;
- diagnostic départemental ;
- diagnostic local ;
- formulaire de contact.

---

## Comment fonctionne le bouton principal ?

Le bouton déclenche un défilement fluide vers la section possédant l'identifiant :

```html
id="localVisibility"
```

au moyen de :

```ts
scrollIntoView({
  behavior: "smooth",
  block: "start"
})
```

---

## Pourquoi utiliser `RouterLink` ?

Les différentes formules commerciales sont accessibles via des liens internes utilisant Vue Router.

---

# Landing page - Gérants de gîtes

## Quel est l'objectif de cette page ?

Cette landing page permet de présenter les offres destinées aux gérants de gîtes et d'estimer le coût annuel des commissions grâce à un simulateur.

---

## Quel composant réalise le calcul ?

Le calcul est entièrement réalisé dans :

```text
ContributionCalculator
```

---

## Quelles données sont demandées ?

Le composant récupère :

- le pourcentage de commission ;
- le prix d'une nuit ;
- le nombre de chambres.

---

## Quelle formule est utilisée ?

Le calcul est réalisé selon la formule suivante :

```text
Prix d'une nuit × (Commission / 100) × 365 × Nombre de chambres
```

---

## Pourquoi utiliser `computed` ?

Les propriétés calculées permettent :

- le recalcul automatique du résultat ;
- le calcul des messages d'erreur ;
- la validation globale du formulaire.

---

## Comment les montants sont-ils formatés ?

Les montants sont formatés grâce à :

```ts
Intl.NumberFormat
```

avec la devise euro.

---

## Comment les validations sont-elles réalisées ?

Chaque champ possède son propre message d'erreur calculé via une propriété `computed`.

---

## Comment le tracking est-il déclenché ?

Deux événements sont envoyés.

Lors de la perte du focus :

```text
form_input_filled
```

Lorsque tous les champs sont valides depuis deux secondes :

```text
contribution_calculator_calculated
```

---

## Pourquoi utiliser un `debounce` ?

Le `debounce` évite d'envoyer plusieurs événements lorsque l'utilisateur modifie rapidement une valeur.

---

## Pourquoi utiliser `watch` ?

Le `watch` surveille la validité globale du formulaire avant d'envoyer l'événement de calcul.

---

## Pourquoi utiliser `onUnmounted` ?

Le composant supprime le timer en cours afin d'éviter son exécution après destruction.

---

# Landing page - Commerçants

## Quel est l'objectif de cette page ?

Cette landing page présente les solutions e-commerce et propose un simulateur de potentiel de vente.

---

## Quel composant réalise le calcul ?

Le calcul est effectué dans :

```text
SalesPotential
```

---

## Quelles informations sont utilisées ?

Le calcul utilise :

- le nombre moyen de clients ;
- le panier moyen ;
- le nombre d'abonnés ;
- le taux de conversion.

---

## Quelle formule est utilisée ?

Le chiffre d'affaires potentiel est calculé selon la formule suivante :

```text
Nombre d'abonnés × (Taux de conversion / 100) × Panier moyen
```

Le chiffre d'affaires global correspond à :

```text
CA boutique physique + CA potentiel
```

---

## Pourquoi utiliser plusieurs propriétés calculées ?

Les propriétés `computed` permettent de calculer :

- les erreurs de validation ;
- le chiffre d'affaires physique ;
- le chiffre d'affaires potentiel ;
- le chiffre d'affaires total ;
- la validité du formulaire.

---

## Comment les montants sont-ils affichés ?

Les résultats utilisent :

```ts
Intl.NumberFormat
```

avec le format monétaire français.

---

## Quels événements de tracking sont envoyés ?

À la perte du focus :

```text
form_input_filled
```

Lorsque le formulaire est valide :

```text
sales_potential_calculated
```

---

## Pourquoi utiliser un `watch` ?

Le `watch` surveille la validité globale du formulaire afin de déclencher automatiquement l'envoi des statistiques.

---

## Pourquoi utiliser un `debounce` ?

Le `debounce` limite le nombre d'événements envoyés lors de la saisie.

---

## Pourquoi utiliser `onUnmounted` ?

Le timer utilisé pour le tracking est supprimé lorsque le composant est détruit.

---

# Authentification administrateur

## Quel est l'objectif de ce module ?

Le module permet :

- la création d'un administrateur ;
- la connexion ;
- la déconnexion ;
- la conservation de la session utilisateur.

---

## Quels composants composent le module ?

Le module utilise :

- `RegisterAdmin`
- `LoginAdmin`

ainsi qu'une page de déconnexion.

---

## Comment est déterminé le composant affiché ?

La page utilise le store Pinia.

Si aucun utilisateur n'est présent :

```vue
<RegisterAdmin />
```

Sinon :

```vue
<LoginAdmin />
```

---

## Quel store est utilisé ?

Le module utilise :

```text
authStore
```

---

## Quelles méthodes du store sont utilisées ?

Les principales méthodes sont :

- `saveSessionUser()`
- `clearUserStored()`

---

## Où est stocké le code de sécurité ?

Le code est récupéré depuis :

```ts
import.meta.env.VITE_SECURITY_KEY
```

---

## Comment fonctionne l'affichage du mot de passe ?

Le type du champ alterne dynamiquement entre :

```text
password
```

et

```text
text
```

---

## Comment les erreurs sont-elles gérées ?

Les erreurs sont stockées dans un tableau réactif.

Chaque erreur est affichée dans une liste du formulaire.

---

## Que se passe-t-il après une connexion réussie ?

L'utilisateur est enregistré dans le store puis redirigé vers :

```text
/admin/statistiques
```

---

## Comment fonctionne la déconnexion ?

Au chargement de la page :

- la session est supprimée ;
- l'utilisateur est retiré du store ;
- une redirection est effectuée vers :

```text
/admin/register
```

---

# Statistiques de tracking

## Quel est l'objectif de ce module ?

Le composant affiche les événements de tracking enregistrés par l'application.

---

## Quel composant est utilisé ?

Les statistiques sont affichées par :

```text
TrackStats
```

---

## Quel composable est utilisé ?

Le composant utilise :

```text
useTracker
```

afin de récupérer :

- le nombre d'événements ;
- les événements paginés.

---

## Comment fonctionne la pagination ?

La pagination repose sur :

- `actualPage`
- `limit`
- `nbPages`

Le nombre total de pages est recalculé à partir du nombre total d'événements.

---

## Pourquoi utiliser `computed` ?

La propriété calculée :

```text
visibleNavigationPages
```

détermine les boutons de pagination à afficher.

---

## Pourquoi utiliser `watch` ?

Deux observations sont mises en place :

- surveillance du nombre de pages ;
- rechargement automatique lorsque la limite est modifiée.

---

## Pourquoi utiliser `AbortController` ?

Chaque nouvelle requête annule immédiatement la précédente afin d'éviter des réponses concurrentes.

---

## Pourquoi utiliser `nextTick` ?

`nextTick()` est utilisé après certaines mises à jour réactives avant d'effectuer des calculs dépendants des nouvelles valeurs.

---

## Comment sont traitées les métadonnées ?

Les métadonnées sont converties avec :

```ts
JSON.parse()
```

Si la conversion échoue, la valeur brute est affichée.

---

## Pourquoi supprimer les doublons ?

Les événements sont reconstruits via un `Map` indexé par leur identifiant afin d'éviter plusieurs affichages du même événement.

---

## Comment les événements sont-ils triés ?

Les événements sont triés par identifiant décroissant afin d'afficher les plus récents en premier.

---

## Comment est affichée la page d'origine ?

Seul le dernier segment de l'URL est affiché grâce à :

```ts
event.page_url.split('/').pop()
```

---

## Que contient le tableau des statistiques ?

Chaque ligne contient :

- l'identifiant de l'événement ;
- sa date ;
- son nom ;
- la page concernée ;
- les métadonnées associées.