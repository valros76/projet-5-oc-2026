<script lang="ts" setup>
import ContactForm from '@/components/forms/ContactForm.vue'
import IllustrationImgComponent from '@/components/images/IllustrationImgComponent.vue'
import DepartmentVisibility from '@/components/landing/artisan/DepartmentVisibility.vue'
import LocalVisibility from '@/components/landing/artisan/LocalVisibility.vue'

const scrollToLocalVisibilitySection = () => {
  const localVisibilitySection = document.getElementById('localVisibility')
  if (localVisibilitySection) {
    localVisibilitySection.scrollIntoView({
      behavior: 'smooth',
      block: 'start',
    })
  }
}
</script>

<template>
  <section class="hero-sections">
    <article class="hero-articles">
      <h1 class="hero-articles-title">
        Artisans de la Somme : votre site web travaille pendant que vous êtes sur vos chantiers
      </h1>

      <IllustrationImgComponent
        src="/assets/images/business/artisan-baie-de-somme.png"
        alt="création d'un site pour un artisan"
        :lazy="true"
      />

      <button class="cta-links small" @click="scrollToLocalVisibilitySection">
        Tester ma visibilité locale
      </button>
    </article>
  </section>

  <section class="main-sections">
    <article class="main-articles">
      <h2 class="main-articles-title">
        Vous êtes l'expert de votre métier, laissez votre site web être l'expert de votre visibilité
      </h2>
      <p>Ne perdez plus vos soirées à prospecter après vos journées de travail.</p>
      <p>
        Pour développer votre activité, vous avez besoin de clients qualifiés qui vous cherchent,
        pas de clients que vous devez prospecter et relancer constamment afin de signer le moindre
        devis.
      </p>
      <p>
        Votre site Webdevoo agit comme un commercial infatigable, présent 24h/24 pour capturer les
        opportunités locales.
      </p>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">
        La solution Webdevoo : la conversion client en mode "pilote automatique" pour votre
        entreprise
      </h2>
      <p>
        Nous ne vous créons pas seulement une page web, nous mettons en place un système de
        génération de devis automatisé.
      </p>
      <ul>
        <li>
          <strong>Visibilité locale garantie</strong> : Nous vous positionnons sur les recherches
          des clients qui ont besoin de vous dans la Somme.
        </li>
        <li>
          <strong>Image professionnelle</strong> : Un site robuste qui impose la confiance dès le
          premier coup d'oeil.
        </li>
        <li>
          <strong>Devis dans votre boîte mail</strong> : Un formulaire intelligent qui filtre les
          demandes pour vous envoyer uniquement les projets sérieux, sans que vous ayez à décrocher
          votre téléphone.
        </li>
      </ul>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">Pourquoi les artisans de la Somme nous font confiance</h2>
      <ul>
        <li>
          <strong>Gain de temps massif</strong> : Plus besoin de gérer la prospection, vos clients
          viennent à vous.
        </li>
        <li>
          <strong>Expertise territoriale</strong> : Une agence locale qui comprend les spécificités
          du département 80 et les attentes de vos clients picards.
        </li>
        <li>
          <strong>Maîtrise budgétaire</strong> : Des formules à prix fixe, sans surprise, conçues
          pour les TPE et indépendants.
        </li>
      </ul>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">Un avis qui compte pour nous</h2>
      <p>
        <cite>
          Je cherchais un moyen de ne plus perdre de temps à prospecter inutilement. Webdevoo a créé
          un site simple qui me ramène des devis qualifiés tous les mois. Je peux enfin me
          concentrer sur mon travail d'artisan.
        </cite>
      </p>
      <p>
        <strong
          >Votre principale préoccupation doit être l'amélioration de votre expertise et de votre
          notoriété, pas de passer des dizaines d'heures au téléphone pour espérer signer un nouveau
          devis cette semaine !</strong
        >
      </p>
    </article>
  </section>

  <section class="main-sections" id="localVisibility">
    <h1 class="main-sections-title">
      Êtes-vous visible quand un client cherche un artisan dans votre secteur ?
    </h1>

    <ul>
      <li>
        <small> Diagnostic instantané et gratuit. </small>
      </li>
      <li>
        <small> Découvrez si vous apparaissez en priorité sur les recherches locales. </small>
      </li>
    </ul>

    <!--TODO : Le bouton de test de visibilité doit mener vers un petit tunnel rapide qui demande le métier de l'artisan et sa ville principale avant de "débloquer" le diagnostic -->
    <DepartmentVisibility />
    <LocalVisibility />

    <article class="main-articles">
      <h2 class="main-articles-title">Vous n'êtes pas visible dans les 3 premières pages ?</h2>
      <p>
        Webdevoo peut vous accompagner dans la mise en place de solutions concrètes pour améliorer
        votre visibilité ou pour mettre en valeur votre activité, à partir de 1000€ HT :
        <RouterLink
          to="/les-formules/details/formule-essentielle-page-web-entreprise"
          target="_blank"
          class="inline-links"
          >Voir le détail de la formule essentielle (page de présentation)</RouterLink
        >.
      </p>
      <p>
        Si vous n'avez pas encore de site vitrine, pour promouvoir votre activité en ligne et être
        visible auprès des prospects, nous pouvons vous accompagner à partir de 3000€ HT :
        <RouterLink
          to="/les-formules/details/formule-dynamique-site-vitrine-evolutif"
          target="_blank"
          class="inline-links"
          >Voir le détail de la formule essentielle (page de présentation)</RouterLink
        >.
      </p>

      <p>
        Contactez-nous pour trouver une solution sur mesure pour vous rendre visible auprès de vos
        prospects.
      </p>
      <p>
        Si vous avez déjà un site existant, nous pouvons intervenir dessus pour améliorer son
        référencement, à partir de 150€ HT / heure, dans ce cas, sélectionnez le motif de contact
        <strong>"Modifier un site existant"</strong>.
      </p>
      <ContactForm />
    </article>
  </section>

  <section class="main-sections">
    <h1 class="main-sections-title">Foire aux questions</h1>
    <article class="main-articles">
      <h2 class="main-articles-title">Vos questions courantes</h2>

      <details>
        <summary>Mon site sera-t-il vraiment visible à Abbeville ou Amiens ?</summary>
        <p>
          Oui, nous optimisons chaque page spécifiquement pour le référencement local dans la Somme
          afin que vous soyez trouvé par vos voisins.
        </p>
      </details>

      <details>
        <summary>Dois-je être un pro de l'informatique ?</summary>
        <p>
          Absolument pas. Webdevoo s'occupe de toute la technique. Vous restez concentré sur votre
          savoir-faire artisanal.
        </p>
      </details>

      <details>
        <summary>Combien de temps pour obtenir des résultats ?</summary>
        <p>
          Nos formules sont pensées pour une mise en place rapide, vous permettant de commencer à
          recevoir vos premiers contacts qualifiés sous quelques semaines.
        </p>
        <p>
          Le délai nécessaire pour remonter peut être différent, en fonction de vos zones de
          chalandises.
        </p>
      </details>
    </article>
  </section>
</template>

<style scoped>
.hero-articles {
  width: 100%;
}
button:is(.cta-links, .small) {
  max-width: calc(60% - var(--padding-bigger));
  font-size: 0.85rem;
  margin-block: 0;
  margin-inline: auto 0;
  padding: var(--padding-small) var(--padding-regular);

  @media (width > 1920px) {
    font-size: 0.85em;
  }
}
</style>
