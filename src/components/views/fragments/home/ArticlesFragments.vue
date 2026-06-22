<script setup lang="ts">
import IllustrationImgComponent from '@/components/images/IllustrationImgComponent.vue'
</script>

<template>
  <article class="main-articles">
    <h2 class="main-articles-title">Votre site web est votre meilleur guide touristique.</h2>
    <p>
      Webdevoo peut vous proposer des
      <strong>solutions clés en main</strong> pour votre <strong>gîte</strong>, votre
      <strong>boutique touristique</strong> ou vous aider à
      <strong>améliorer votre visibilité</strong> si vous êtes un
      <strong>artisan de la Somme</strong>.
    </p>
    <p>
      L'agence est présente
      <strong>depuis 2019, à Cahon Gouy (80132)</strong>, dans la <strong>baie de somme</strong> et
      porte une attention particulière à la <strong>vie des entreprises locales</strong>.
    </p>
    <p>
      Hormis le <strong>secteur touristique</strong>, il est important pour nous d'<strong
        >accompagner les entreprises locales dans leurs croissance</strong
      >.
    </p>
    <p>
      Vous avez la chance d'entreprendre dans une région magnifique, il est important que vous ayez
      <strong>la visibilité locale que vous méritez</strong>.
    </p>

    <RouterLink to="/nous-contacter" class="cta-links"> J'ai un projet local </RouterLink>
  </article>

  <article class="main-articles">
    <h2 class="main-articles-title">Une idée ? Un projet ?</h2>
    <p>
      Vous êtes <strong>auto-entrepreneur</strong>, gérant d'une
      <strong><abbr title="Très petite entreprise" tabindex="0">TPE</abbr></strong>
      ou d'une
      <strong><abbr title="Petite ou moyenne entreprise" tabindex="0">PME</abbr></strong>
      dans la somme ?
    </p>
    <p>
      Vous êtes à la recherche d'un
      <strong>développeur web</strong> pour créer votre
      <strong>site internet dans la somme</strong> ou votre
      <strong>boutique en ligne de produits locaux</strong>
      ?
    </p>
    <p>
      <strong>Webdevoo</strong> s'occupe de la <strong>création de votre projet</strong> et vous
      accompagne pour <strong>augmenter votre visibilité</strong> auprès des clients.
    </p>
    <p>
      Vous ciblez une <strong>clientèle locale</strong> ou <strong>touristique</strong> ? Votre site
      internet ou votre boutique en ligne doit être <strong>la vitrine de votre entreprise</strong>.
    </p>
    <p><strong>Ne ratez plus une vente</strong>, car vous n'êtes pas présent en ligne !</p>
    <p>
      <strong>Pas besoin de s'embêter à calculer</strong>, Webdevoo vous propose
      <strong>différentes formules, à prix fixe</strong>, pour lancer votre projet sans tarder.
    </p>
    <RouterLink to="/les-formules" class="cta-links"> Découvrir les formules </RouterLink>
  </article>

  <article class="main-articles">
    <h2 class="main-articles-title">Vous êtes un gérant de gîte ?</h2>
    <IllustrationImgComponent
      src="/assets/images/business/gite.png"
      alt="création d'un site vitrine pour un gîte"
      :lazy="true"
    />
    <p>
      Vous avez besoin d'un
      <strong>outil de travail performant</strong> et d'une
      <strong>belle vitrine pour attirer de nouveaux clients</strong>
      !
    </p>
    <p>
      Vous êtes <strong>sceptiques</strong> à l'idée d'<strong
        >étendre votre visibilité en ligne</strong
      >
      ?
    </p>
    <p>
      N'oubliez pas que <strong>chaque année</strong>, la <strong>nouvelle génération</strong> vient
      <strong>agrandir le panel de clientèle potentielle</strong>, et cette génération est
      <strong>ultra-connectée</strong>.
    </p>
    <p>
      En prime, vous pourrez
      <strong>étendre à votre guise votre prospection</strong>.
    </p>
    <p>Une <strong>clientèle parisienne</strong>, ou même <strong>européenne</strong> ?</p>
    <p>
      Vous êtes
      <strong>libres d'étendre votre activité</strong>, en fonction de votre volonté !
    </p>
    <p>
      Et tout se fait simplement, en utilisant
      <strong>les outils que nous développons sur mesure</strong>
      pour votre activité.
    </p>
    <p>
      Vous ne pouvez pas continuer à les ignorer,
      <strong>préférez leur proposer vos nuitées</strong> !
    </p>
    <RouterLink
      to="/les-formules/details/formule-premium-site-vitrine-sur-mesure"
      class="cta-links"
    >
      Je veux les cibler
    </RouterLink>
  </article>

  <article class="main-articles">
    <h2 class="main-articles-title">Vous avez une boutique physique de produits régionaux ?</h2>
    <IllustrationImgComponent
      src="/assets/images/business/boutique-locale.png"
      alt="création d'une boutique en ligne pour une boutique locale"
      :lazy="true"
    />
    <p>
      Vous n'avez pas encore tenté l'<strong>expérience de vente en ligne</strong>
      ?
    </p>
    <p>
      Comment
      <strong>vos clients, issus du tourisme</strong>, peuvent
      <strong>profiter de vos produits</strong>, s'ils sont déjà repartis ?
    </p>
    <p>
      Avec une <strong>boutique en ligne locale</strong>, ils pourront sans problèmes
      <strong>vous ajouter à leur favoris et commander à leur guise vos fabuleux produits</strong>
      !
    </p>
    <p>
      Vous voulez vous lancer en douceur ? Webdevoo vous propose de commencer avec la
      <RouterLink to="/les-formules/details/formule-ecommerce-page-de-vente" class="inline-links"
        ><strong>formule page de vente</strong></RouterLink
      >, pour promouvoir votre produit phare.
    </p>
    <p>
      Sinon, découvrez la
      <strong>formule ecommerce avancée</strong>, qui vous permet de
      <strong>promouvoir un catalogue contenant jusqu'à 30 produits</strong>.
    </p>
    <RouterLink to="/les-formules/details/formule-ecommerce-avance" class="cta-links">
      Je veux me lancer
    </RouterLink>
  </article>

  <article class="main-articles">
    <h2 class="main-articles-title">Vous êtes un artisan de la Somme (80) ?</h2>
    <IllustrationImgComponent
      src="/assets/images/business/artisan.png"
      alt="création d'une page web pour un artisan"
      :lazy="true"
    />
    <p>
      Vous en avez marre de
      <strong>perdre du temps à prospecter</strong> ?
    </p>
    <p>
      <strong>Laissez les clients venir à vous</strong>, en mettant en place les
      <strong>éléments essentiels pour votre présence en ligne</strong>.
    </p>
    <p>
      Vous <strong>gardez un budget maîtrisé</strong>, Webdevoo vous propose de vous accompagner
      <strong>à partir de 1.000,00€</strong>, en commençant avec la
      <strong>formule essentielle</strong>.
    </p>
    <p>
      Cette formule a été
      <strong>spécialement pensée pour commencer à créer votre présence en ligne</strong>.
    </p>
    <p>
      Ne perdez pas plus de temps et
      <strong>commencez à vous positionner localement</strong>.
    </p>
    <RouterLink
      to="/les-formules/details/formule-essentielle-page-web-entreprise"
      class="cta-links"
    >
      Je veux me positionner
    </RouterLink>
  </article>
</template>
