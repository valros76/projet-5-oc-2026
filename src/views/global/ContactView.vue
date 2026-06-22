<script setup lang="ts">
import ContactForm from '@/components/forms/ContactForm.vue'
</script>

<template>
  <section class="main-sections">
    <h1 class="main-sections-title">
      Contacter l'entreprise Webdevoo pour la création d'un site internet ou d'une boutique en ligne
    </h1>
    <aside class="cta-links-container">
      <a href="mailto:developpeur@webdevoo.com" class="cta-links cta-links-secondary">
        Contactez-nous par email
      </a>
      <a href="tel:+33750474757" class="cta-links cta-links-secondary">
        Contactez-nous par téléphone
      </a>
      <a
        href="https://www.linkedin.com/company/entreprise-webdevoo"
        class="cta-links cta-links-secondary"
      >
        Vous préférez Linkedin ?
      </a>
    </aside>
    <article class="main-articles">
      <h2 class="main-articles-title">Une idée, un projet, un besoin professionnel ?</h2>
      <div class="portfolio-articles-content">
        <p>
          <strong>L'entreprise Webdevoo</strong> est disponible pour répondre à vos demandes de
          création de <strong>site internet</strong>, création de
          <strong>boutique en ligne</strong> ou pour toute
          <strong>intervention sur un site existant</strong>.
        </p>
        <p>
          Prenez contact avec nous <strong>gratuitement</strong> et nous conviendrons avec vous d'un
          <strong>rendez-vous</strong> dans les plus brefs délais.
        </p>
        <p>
          Lors de ce rendez-vous, nous pourrons <strong>étudier vos besoins</strong>,
          <strong>établir un cahier des charge</strong> pour votre projet et
          <strong>estimer le délai de production</strong> de votre projet.
        </p>
        <p>
          Si vous n'avez qu'une <strong>vague idée</strong> pour le lancement de
          <strong>votre projet</strong>, nous pouvons vous aiguiller sur le parcours à suivre pour
          <strong>donner vie à cette idée</strong>.
        </p>
        <p>
          En contactant l'entreprise Webdevoo via ce formulaire,
          <strong
            >vous acceptez l'utilisation des données personnelles fournies dans le cadre d'une mise
            en relation professionnelle</strong
          >, par email.
        </p>
        <p>L'utilisation de ce formulaire induit la condition suivante :</p>
        <p>
          <em>
            "Conformément à la loi RGPD, j'autorise l'entreprise Webdevoo à me recontacter grâce à
            mes informations personnelles, fournies préalablement dans ce formulaire. L'entreprise
            Webdevoo s'engage à utiliser mes informations personnelles uniquement dans un cadre de
            contact professionnel et à les supprimer en cas d'interruption du contact."
          </em>
        </p>
      </div>
    </article>
    <ContactForm />
  </section>
</template>
