<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>

<template>
  <section class="main-sections">
    <h2 class="main-sections-title">Mentions légales</h2>
    <article class="main-articles">
      <h2 class="main-articles-title">Informations légales</h2>
      <p>
        Merci de lire avec attention les différentes modalités d'utilisation du présent site avant
        d'y parcourir ses pages. En vous connectant sur ce site, vous acceptez sans réserves les
        présentes modalités. Aussi, conformément à l'article n°6 de la Loi n°2004-575 du 21 Juin
        2004 pour la confiance dans l'économie numérique, les responsables du présent site internet
        webdevoo.com sont :
      </p>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">Éditeur du site</h2>
      <p>Webdevoo</p>
      <p>
        Numéro de SIRET :
        <a href="https://www.societe.com/societe/monsieur-valerian-dufrene-849595574.html"
          >84959557400013</a
        >
      </p>
      <p>
        Responsable editorial :
        <a href="https://www.linkedin.com/in/webdevoo/" rel="sponsored">Dufrène Valérian</a>
      </p>
      <p>
        <a href="https://maps.app.goo.gl/v1s1eNq3Ym6T2GkdA"> 25 rue de la vallée, 80132 Cahon </a>
      </p>
      <p>Téléphone : <a href="tel+33750474757">07.50.47.47.57</a></p>
      <p>Email : <a href="mailto:developpeur@webdevoo.com">developpeur@webdevoo.com</a></p>
      <p>Site Web : <RouterLink to="/">webdevoo.com</RouterLink></p>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">Hébergeur</h2>
      <p>PLANETHOSTER</p>
      <p>4416 Louis B. Mayer, Laval (Québec) H7P 0G1, Canada</p>
      <p>
        Site Web :
        <a href="https://www.planethoster.com/goph-webdevoo" rel="sponsored">planethoster.com</a>
      </p>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">Développement</h2>
      <p>Webdevoo - Dufrène Valérian</p>
      <p>Adresse : 25 rue de la vallée, 80132 Cahon</p>
      <p>Site Web : <RouterLink to="/">webdevoo.com</RouterLink></p>
    </article>

    <article class="main-articles">
      <h2 class="main-articles-title">Déclaration à la CNIL</h2>
      <p>
        Conformément à la loi 78-17 du 6 janvier 1978 (modifiée par la loi 2004-801 du 6 août 2004
        relative à la protection des personnes physiques à l'égard des traitements de données à
        caractère personnel) relative à l'informatique, aux fichiers et aux libertés, ce site n'a
        pas fait l'objet d'une déclaration auprès de la Commission nationale de l'informatique et
        des libertés (www.cnil.fr).
      </p>
    </article>
  </section>
</template>
