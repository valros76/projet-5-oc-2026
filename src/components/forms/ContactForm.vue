<script setup lang="ts">
import router from '@/router'
import { computed, reactive, ref } from 'vue'

const contactFormState = reactive({
  state: false,
})
const formDatas = ref({
  reason: {
    value: '',
    state: false,
  },
  email: {
    value: '',
    state: false,
  },
  message: {
    value: '',
    state: false,
  },
  returnDate: {
    value: '',
    state: false,
  },
  rgpd: {
    value: false,
    state: false,
  },
})

const onClickRgpd = () => {
  formDatas.value.rgpd = {
    value: !formDatas.value.rgpd.value,
    state: !formDatas.value.rgpd.state,
  }
}

const verifyAllInputStates = computed(() => {
  // const inputsState = Object.values(formDatas.value).filter(
  //   (input) => !input.state
  // );
  // return inputsState.length === 0 ? false : true;

  // On vérifie que TOUS les états sont à true
  const allValid = Object.values(formDatas.value).every((input) => input.state === true)
  // Le bouton est disabled si le formulaire n'est PAS valide
  return !allValid
})

const onSubmit = async (e: any) => {
  const datas = {
    reason: formDatas.value.reason.value,
    email: formDatas.value.email.value,
    message: formDatas.value.message.value,
    returnDate: formDatas.value.returnDate.value,
    rgpd: formDatas.value.rgpd.value,
  }

  const submitDatas = await fetch('https://webdevoo.com/api/contact', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': '*',
    },
    body: JSON.stringify(datas),
  })
    .then((response) => response.ok && response.json())
    .then((datas) => {
      e.target.reset()
      formDatas.value.rgpd = {
        value: !formDatas.value.rgpd.value,
        state: !formDatas.value.rgpd.state,
      }
      router.push('/message-envoye')
    })
    .catch((err) => {
      console.error(err)
      router.push('/nous-recontacter')
    })
}
</script>

<template>
  <form action="/contact" method="POST" id="contactForm" @submit.stop.prevent="(e) => onSubmit(e)">
    <label id="contactFormLoadingMessage" v-if="contactFormState.state">
      Chargement du formulaire en cours, veuillez patienter...
    </label>
    <label for="reason"> Motif du contact </label>
    <div class="select">
      <select
        name="reason"
        id="reason"
        class="form-select"
        v-model="formDatas.reason.value"
        @change="() => formDatas.reason.value && (formDatas.reason.state = true)"
        required
      >
        <optgroup label="Organisme de formation">
          <option value="formation_sous_traitance">Je cherche un formateur</option>
          <option value="formation">Informations pour une formation</option>
        </optgroup>
        <optgroup label="Formules">
          <option value="website">Création d'un site vitrine</option>
          <option value="ecommerce">Création d'une boutique en ligne</option>
          <option value="first_site">Création de votre première page web</option>
          <option value="presentation">Création d'une page web de présentation</option>
          <option value="one_product">Création d'une page d'achat pour produit unique</option>
        </optgroup>
        <optgroup label="Formation">
          <option value="formation_prestashop">Formation Prestashop</option>
          <option value="formation_wordpress">Formation Wordpress</option>
        </optgroup>
        <optgroup label="Interventions">
          <option value="modification">Modification d'un site existant</option>
          <option value="fonctionnality">
            Création et ajout d'une fonctionnalité supplémentaire
          </option>
          <option value="freelance">Réserver une prestation journalière freelance</option>
        </optgroup>
        <optgroup label="B2B">
          <option value="partenariat">Demande de partenariat</option>
        </optgroup>
        <optgroup label="Autres motifs">
          <option value="contact">Contacter l'entreprise</option>
          <option value="reclamation">Effectuer une réclamation</option>
        </optgroup>
      </select>
      <span class="focus"></span>
    </div>
    <label for="email"> Votre adresse email </label>
    <input
      name="email"
      id="email"
      v-model="formDatas.email.value"
      @change="() => formDatas.email.value && (formDatas.email.state = true)"
      required
    />
    <label for="message"> Exposez-nous brièvement votre projet </label>
    <textarea
      v-model="formDatas.message.value"
      @change="() => formDatas.message.value && (formDatas.message.state = true)"
      name="message"
      id="message"
    ></textarea>
    <label for="return_date"> Avez-vous un jour de préférence pour être recontacté ? </label>
    <div class="select">
      <select
        v-model="formDatas.returnDate.value"
        @change="() => formDatas.returnDate.value && (formDatas.returnDate.state = true)"
        name="return_date"
        id="return_date"
        class="form-select"
        required
      >
        <option value="none">Je n'ai pas de préférences</option>
        <option value="all_work_days">Tous les jours ouvrés</option>
        <option value="monday">Le lundi</option>
        <option value="tuesday">Le mardi</option>
        <option value="wednesday">Le mercredi</option>
        <option value="thursday">Le jeudi</option>
        <option value="friday">Le vendredi</option>
        <option value="saturday">Le samedi</option>
        <option value="sunday">Le dimanche</option>
      </select>
      <span class="focus"></span>
    </div>
    <div class="rgpd-input-wrapper">
      <input
        class="rgpd rgpd-light"
        id="rgpd"
        type="checkbox"
        v-model="formDatas.rgpd.value"
        @change="formDatas.rgpd.state = formDatas.rgpd.value"
        :checked="formDatas.rgpd.value"
      />
      <label class="rgpd-btn" for="rgpd"> </label>
      <em class="rgpd-text" @click="onClickRgpd()">
        "Conformément à la loi RGPD, j'autorise l'entreprise Webdevoo à me recontacter grâce à mes
        informations personnelles, fournies préalablement dans ce formulaire. L'entreprise Webdevoo
        s'engage à utiliser mes informations personnelles uniquement dans un cadre de contact
        professionnel et à les supprimer en cas d'interruption du contact."
      </em>
    </div>
    <button type="submit" :disabled="verifyAllInputStates">Valider la demande de contact</button>
  </form>
</template>
