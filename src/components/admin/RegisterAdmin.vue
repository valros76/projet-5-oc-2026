<script lang="ts" setup>
import { useAuth } from '@/composables/useAuth'
import type { UserAuthI, UserI } from '@/interfaces/userI'
import { authStore } from '@/stores/authStore'
import { storeToRefs } from 'pinia'
import { reactive, ref } from 'vue'

const { registerAdmin } = useAuth()

const errors = ref<string[]>([])
const isPassword = ref(true)

const store = authStore()
const { saveSessionUser } = store
const { user } = storeToRefs(store)

const securityCode = ref<number>(Number(import.meta.env.VITE_SECURITY_KEY))
const inputSecurityCode = ref<number>(0)

const formData = reactive<UserAuthI>({
  email: '',
  password: '',
  is_admin: true,
})

const addError = (err: string) => {
  errors.value = [...errors.value, err]
}

const clearErrors = () => {
  errors.value = []
}

const verifyPassword = () => {
  isPassword.value = !isPassword.value
}

const storeUserModel = () => {
  const modelUser: UserI = {
    email: '',
    is_admin: true,
    inscriptionDate: new Date(),
  }
  saveSessionUser(modelUser)
  user.value = modelUser
}

const handleSubmit = async () => {
  clearErrors()
  if (inputSecurityCode.value !== securityCode.value) {
    addError(`CODE DE SÉCURITÉ INVALIDE !`)
    return
  }
  try {
    const response = await registerAdmin(formData)

    if (response.ok) {
      const data = await response.json()
      const user = data.params[0]
      saveSessionUser(user)
      formData.email = ''
      formData.password = ''
    } else if (response.status === 500) {
      addError(`Veuillez choisir une autre adresse email.`)
    } else {
      addError(`Erreur HTTP : ${response.status}`)
    }
  } catch (e) {
    if (e instanceof Error && e.name === 'AbortError') {
      addError(`Requête annulée : timeout`)
    } else {
      addError(`Erreur réseau : ${e}`)
    }
  }
}
</script>

<template>
  <article class="main-articles">
    <h2 class="main-articles-title">Inscription d'un nouvel administrateur</h2>
    <form method="POST" @submit.prevent.stop="handleSubmit">
      <label for="email"> Votre adresse email : </label>
      <input
        v-model="formData.email"
        @focus="clearErrors"
        placeholder="Email"
        name="email"
        id="email"
      />

      <label for="password"> Votre mot de passe : </label>
      <input
        :type="isPassword ? 'password' : 'text'"
        v-model="formData.password"
        @focus="clearErrors"
        placeholder="Mot de passe"
      />
      <button type="button" @click.prevent="verifyPassword" class="cta-links small">
        {{ isPassword ? '🕶️ Voir mon mot de passe 🕶️' : '🕶️ Masquer mon mot de passe 🕶️' }}
      </button>

      <label for="securityCode"> Code de sécurité </label>
      <input
        type="number"
        v-model="inputSecurityCode"
        name="securityCode"
        id="securityCode"
        min="0"
        max="2000"
        step="10"
      />

      <ul v-if="errors.length > 0" class="list-square">
        <li v-for="(err, index) in errors" :key="index" class="error">
          {{ err }}
        </li>
      </ul>

      <button type="submit">Ajouter l'administrateur</button>
    </form>

    <aside class="aside-articles">
      <button @click.prevent="storeUserModel" class="cta-links small">Je veux me connecter</button>
    </aside>
  </article>
</template>

<style scoped></style>
