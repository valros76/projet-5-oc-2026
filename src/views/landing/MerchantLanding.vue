<script lang="ts" setup>
import ContactForm from '@/components/forms/ContactForm.vue'
import IllustrationImgComponent from '@/components/images/IllustrationImgComponent.vue'
import SalesPotential from '@/components/landing/merchant/SalesPotential.vue'

const scrollToSalesPotentialSection = () => {
  const salesPotentialSection = document.getElementById('salesPotential')
  if (salesPotentialSection) {
    salesPotentialSection.scrollIntoView({
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
        La Baie de Somme est votre vitrine, la France entière est votre marché
      </h1>
      <p>
        Ne soyez plus limité par le passage dans votre rue. Développez votre chiffre d'affaires en
        vendant vos produits partout, toute l'année.
      </p>

      <IllustrationImgComponent
        src="/assets/images/business/boutique-locale-baie-de-somme.png"
        alt="création d'une boutique en ligne pour un commerçant"
        :lazy="true"
      />

      <button class="cta-links small" @click="scrollToSalesPotentialSection">
        Voir mon potentiel de vente en ligne
      </button>
    </article>
  </section>

  <section class="main-sections">
    <article class="main-articles">
      <h2 class="main-articles-title">
        Vos produits régionaux sont les souvenirs préférés de vos clients
      </h2>
      <p>Ne les laissez pas repartir sans un moyen de commander à nouveau.</p>
      <p>
        Chaque touriste qui quitte votre boutique sans pouvoir vous retrouver en ligne est une vente
        perdue.
      </p>
      <p>
        Avec une boutique en ligne, Webdevoo permet que votre savoir-faire proposé dans la Somme
        dépasse enfin les frontières du département.
      </p>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">
        La solution Webdevoo : l'extension de votre boutique physique
      </h2>
      <p>
        Nous créons une passerelle digitale simple et intuitive pour prolonger l'expérience de vos
        clients, une fois rentrés chez eux.
      </p>
      <ul>
        <li>
          <strong>Fidélisation post-visite</strong> : Permettez à vos clients de Paris, Lyon ou
          d'ailleurs de commander leurs produits favoris en quelques clics.
        </li>
        <li>
          <strong>Vente en ligne simplifiée</strong> : Une boutique conçue pour la gestion locale,
          facile à mettre à jour et connectée aux solutions d'expédition.
        </li>
        <li>
          <strong>Revenus constants</strong> : Ne dépendez plus uniquement des flux touristiques
          saisonniers pour générer du chiffre d'affaires.
        </li>
      </ul>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">
        Pourquoi choisir une boutique mise en place par Webdevoo ?
      </h2>
      <ul>
        <li>
          <strong>Logistique facilitée</strong> : Nous configurons votre boutique pour que
          l'expédition de vos produits de la Baie de Somme devienne un jeu d'enfant.
        </li>
        <li>
          <strong>Image de marque locale</strong> : Un design qui valorise l'authenticité de vos
          produits et le charme de notre région.
        </li>
        <li>
          <strong>Accompagnement de proximité</strong> : Une agence basée dans la Somme qui vous
          aide à faire vos premiers pas dans la vente à distance sans stress technique.
        </li>
        <li>
          <strong>Connaissance des limites et frictions potentielles</strong>
          : Webdevoo n'est pas juste une agence web, c'est une entreprise multi-activité, qui a pu
          compter ses propres boutiques en ligne dans la baie de Somme. Grâce à ces expériences,
          nous pouvons désormais mieux vous conseiller lors de l'accompagnement sur vos projets.
        </li>
      </ul>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">Cet avis nous a touché</h2>
      <p>
        <cite>
          Le résultat final est tout simplement parfait. Les sites sont non seulement esthétiquement
          réussi, mais il fonctionne aussi à merveille. Il reflète exactement ce que j'avais
          imaginé, voire plus. Grâce à son expertise et son professionnalisme, nous avons pu mettre
          en ligne un site qui non seulement répond aux besoins des utilisateurs, mais qui les
          dépasse.
        </cite>
      </p>
      <p>
        <strong
          >Cet avis nous a fait chaud au coeur, car c'est le seul moyen fiable que l'on a pour
          s'assurer que toutes les heures passées à accumuler des connaissances sur des domaines
          d'activités et leurs contraintes contribuent aujourd'hui pleinement à l'accompagnement que
          nous proposons aux entreprises locales.</strong
        >
      </p>
    </article>
  </section>

  <section class="main-sections" id="salesPotential">
    <h1 class="main-sections-title">Prêt à faire voyager vos produits de la Baie de Somme ?</h1>

    <ul>
      <li>
        <small> Solution clé en main, de la mise en ligne à la gestion des expéditions. </small>
      </li>
      <li>
        <small> Consultation gratuite et sans engagement. </small>
      </li>
    </ul>

    <SalesPotential />

    <article class="main-articles">
      <h2 class="main-articles-title">
        Déployez tout votre potentiel de vente en ligne dès maintenant
      </h2>
      <p>N'attendez plus pour convertir plus.</p>
      <p>
        Vous avez déjà une clientèle existante, qui pourrait être ravie de retrouver vos produits en
        ligne et des followers qui ne peuvent pas forcément se rendre dans votre boutique physique.
      </p>
      <p>
        Avec une boutique en ligne, vous pouvez débrider votre potentiel de vente et augmenter votre
        visibilité par la même occasion.
      </p>
      <p>
        Webdevoo peut vous accompagner pour amener la présence de vos produits en ligne, à
        disponibilité de tous vos clients.
      </p>
      <p>
        Si vous souhaitez tester le marché potentiel qui vous attend en ligne, vous pouvez commencer
        par vendre votre produit phare, via une page de vente en ligne, que nous pouvons vous
        concevoir à partir de 2500€ HT :
        <RouterLink
          to="/les-formules/details/formule-ecommerce-page-de-vente"
          target="_blank"
          class="inline-links"
          >Voir le détail de la formule page de vente clés en main</RouterLink
        >.
        <small style="font-size: 0.8em; color: #666">
          * Idéal pour tester un produit phare ou lancer sa première activité e-commerce.
        </small>
      </p>
      <p>
        Si vous souhaitez vous lancer avec un catalogue de 2 à 30 produits, nous avons une formule
        adaptée, afin d'étendre votre capacité de vente en ligne, à partir de 5000€ HT :
        <RouterLink
          to="/les-formules/details/formule-ecommerce-avance"
          target="_blank"
          class="inline-links"
          >Voir le détail de la formule E-commerce avancé</RouterLink
        >.
        <small style="font-size: 0.8em; color: #666">
          * La solution complète pour gérer un catalogue boutique tout au long de l'année.
        </small>
      </p>
      <p>
        Si vous avez un catalogue de plus de 30 produits à vendre en ligne, nous vous proposons une
        formule vous permettant d'intégrer toutes vos fonctionnalités métiers, pour fluidifier le
        travail de vos équipes, à partir de 7500€ HT :
        <RouterLink
          to="/les-formules/details/formule-ecommerce-premium"
          target="_blank"
          class="inline-links"
          >Voir le détail de la formule E-commerce premium</RouterLink
        >.
        <small style="font-size: 0.8em; color: #666">
          * Pour les entreprises établies qui souhaitent une automatisation totale et une
          intégration métier poussée.
        </small>
      </p>
      <p>
        Si vous avez déjà un site existant, nous pouvons y ajouter des fonctionnalités sur mesure,
        <strong>à partir de 150€ HT / heure</strong>. Dans ce cas, sélectionnez le motif
        <strong>Création et ajout d'une fonctionnalité supplémentaire</strong>
        lors de votre prise de contact.
      </p>
      <ContactForm />
    </article>
  </section>

  <section class="main-sections">
    <h1 class="main-sections-title">Foire aux questions</h1>

    <article class="main-articles">
      <h2 class="main-articles-title">Vos questions courantes</h2>

      <details>
        <summary>Est-ce compliqué à gérer au quotidien ?</summary>
        <p>
          Pas du tout. Webdevoo simplifie l'interface pour que vous puissiez gérer vos stocks et vos
          commandes en toute autonomie.
        </p>
      </details>

      <details>
        <summary>Comment gérer les frais de port ?</summary>
        <p>
          Nous configurons avec vous les tarifs d'expédition adaptés à vos produits pour que la
          vente en ligne reste rentable pour votre boutique.
        </p>
      </details>

      <details>
        <summary>Puis-je vendre toute l'année ?</summary>
        <p>
          C'est exactement l'objectif. Votre boutique en ligne est ouverte 24h/24, transformant vos
          clients touristiques en clients fidèles, été comme hiver.
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
