<script lang="ts" setup>
import ContactForm from '@/components/forms/ContactForm.vue'
import IllustrationImgComponent from '@/components/images/IllustrationImgComponent.vue'
import ContributionCalculator from '@/components/landing/cottage/ContributionCalculator.vue'

const scrollToContributionCalculatorSection = () => {
  const contributionCalculatorSection = document.getElementById('contributionCalculator')
  if (contributionCalculatorSection) {
    contributionCalculatorSection.scrollIntoView({
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
        Gérants de gîtes en Baie de Somme : reprenez le contrôle de vos réservations
      </h1>

      <IllustrationImgComponent
        src="/assets/images/business/gite-baie-de-somme.png"
        alt="création d'un site vitrine pour un gîte"
        :lazy="true"
      />

      <button class="cta-links small" @click="scrollToContributionCalculatorSection">
        Connaître mes économies potentielles liées aux commissions
      </button>
    </article>
  </section>

  <section class="main-sections">
    <article class="main-articles">
      <h2 class="main-articles-title">
        La Baie de Somme est votre terrain, pas celui des plateformes
      </h2>
      <p>
        Chaque réservation prise via Airbnb ou Booking est une ponction inutile sur votre marge.
      </p>
      <p>
        Pourquoi laisser 15% de vos revenus à des intermédiaires quand vous pouvez attirer vos
        clients en direct ?
      </p>
      <p>Votre gîte mérite un canal de vente qui vous appartient à 100%.</p>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">
        La solution Webdevoo : votre moteur de réservation autonome
      </h2>
      <p>Nous vous installons un outil conçu pour convertir les touristes en clients directs.</p>
      <p>
        Vous ne vendez pas seulement des nuitées, vous construisez votre propre fichier client pour
        garantir vos saisons futures.
      </p>
      <ul>
        <li><strong>Zéro commission</strong> : Le prix de la nuitée vous revient en totalité.</li>
        <li>
          <strong>Indépendance totale</strong> : Vous maîtrisez votre calendrier et vos tarifs sans
          dépendre des algorithmes des plateformes.
        </li>
        <li>
          <strong>Expertise locale</strong> : Un site conçu par une agence basée en Baie de Somme
          depuis 2019, qui comprend vos besoins.
        </li>
      </ul>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">Ce que vous gagnez dès aujourd'hui</h2>
      <ul>
        <li>
          <strong>Fidélisation durable</strong> : Constituez votre base de données clients pour les
          recontacter par email l'année prochaine.
        </li>
        <li>
          <strong>Image professionnelle</strong> : Un site qui reflète l'authenticité de votre gîte
          et rassure vos futurs hôtes.
        </li>
        <li>
          <strong>Simplicité technique</strong> : Nous gérons la maintenance, vous gérez vos hôtes.
        </li>
      </ul>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">Cet avis nous a touché</h2>
      <p>
        <cite>
          Je suis absolument ravi du travail accompli et je recommande vivement webdevoo à toute
          personne cherchant un partenaire fiable et compétent pour la réalisation de projets web.
          Encore une fois, merci pour cette magnifique collaboration !
        </cite>
      </p>
      <p>
        <strong>
          C'est surtout Webdevoo qui vous remercie tous, d'être aussi investis dans vos projets et
          vos idées. L'agence n'en serait pas là aujourd'hui, sans toutes ces idées innovantes.
        </strong>
      </p>
    </article>
  </section>

  <section class="main-sections" id="contributionCalculator">
    <h1 class="main-sections-title">Prêt à augmenter vos marges dès la prochaine saison ?</h1>
    <ul>
      <li>
        <small>Simulation gratuite et sans engagement.</small>
      </li>
      <li>
        <small>Recevez votre estimation personnalisée par email en quelques secondes.</small>
      </li>
    </ul>

    <article class="main-articles">
      <h2 class="main-articles-title">Économisez sur le long terme dès maintenant</h2>
      <ContributionCalculator />
      <p>
        Contactez-nous pour investir dans les économies de comissions sur le long terme, en créant
        un site vitrine sur mesure, à partir de <strong>6250€ HT</strong> :
        <RouterLink
          to="/les-formules/details/formule-premium-site-vitrine-sur-mesure"
          target="_blank"
          >Voir le détail de la formule premium pour gérer votre gite au quotidien</RouterLink
        >.
      </p>
      <p>
        Si vous avez déjà un site existant, nous pouvons y ajouter des fonctionnalités sur mesure, à
        partir de <strong>150€ HT / heure</strong>. Dans ce cas, sélectionnez le motif
        <strong>Création et ajout d'une fonctionnalité supplémentaire</strong> lors de votre prise
        de contact.
      </p>
      <ContactForm />
    </article>
  </section>

  <section class="main-sections">
    <h1 class="main-sections-title">Foire aux questions</h1>

    <article class="main-articles">
      <h2 class="main-articles-title">Réponses à vos questions courantes</h2>

      <details>
        <summary>Pourquoi un site direct plutôt qu'Airbnb ?</summary>
        <p>
          Parce que vous gardez 100% du prix de la nuitée et que vous possédez le contact direct de
          vos clients pour les fidéliser.
        </p>
      </details>

      <details>
        <summary>Le site est-il compatible mobile ?</summary>
        <p>
          Oui, 100% de nos sites sont optimisés pour les smartphones des touristes qui cherchent
          leur hébergement en Baie de Somme, car ils représentent 60% à 70% des recherches courantes
          dans votre situation.
        </p>
      </details>

      <details>
        <summary>Webdevoo intervient-il dans toute la Somme ?</summary>
        <p>
          Nous accompagnons les entreprises locales, de la Baie de Somme jusqu'au département 80,
          avec une proximité physique et un accompagnement sur-mesure.
        </p>
      </details>

      <details>
        <summary>Acceptez-vous des clients hors secteur ?</summary>
        <p>
          Nous pouvons également accompagner votre entreprise, hors de la Baie de Somme, si vous
          acceptez d'ajouter un rendez-vous spécifique à la découverte de vos atouts locaux et des
          spécificités de l'emplacement de votre gîte, pour nous permettre de cibler au mieux votre
          clientèle via la solution web apportée.
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
