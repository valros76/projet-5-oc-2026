import type { UserI } from '@/interfaces/userI'
import { defineStore } from 'pinia'
import { computed, ref } from 'vue'

export const authStore = defineStore('auth', () => {

  const user = ref<UserI | undefined>(undefined);

  const init = () => {
    const rawSessionData = sessionStorage.getItem("webdevoo_user");
    let rawData;

    if (!rawSessionData) {
      const rawLocalData = localStorage.getItem("webdevoo_user");
      if (!rawLocalData) return undefined;
      rawData = rawLocalData;
    } else {
      rawData = rawSessionData;
    }

    try {
      user.value = JSON.parse(rawData) as UserI;
    } catch (e) {
      console.error("Erreur de lecture du stockage:", e);
      sessionStorage.removeItem("webdevoo_user");
      return undefined;
    }
  };
  init();

  const clearUserStored = () => {
    user.value = undefined;
    sessionStorage.removeItem("webdevoo_user");
    localStorage.removeItem("webdevoo_user");
  }

  const saveSessionUser = (newUser: UserI) => {
    sessionStorage.setItem("webdevoo_user", JSON.stringify(newUser));
    user.value = newUser;
  }

  const getSessionUser = () => {
    const rawData = sessionStorage.getItem("webdevoo_user");

    if (!rawData) return undefined;

    try {
      return JSON.parse(rawData) as UserI;
    } catch (e) {
      console.error("Erreur de lecture du stockage:", e);
      sessionStorage.removeItem("webdevoo_user");
      return undefined;
    }
  }

  const saveLocalUser = (newUser: UserI) => {
    localStorage.setItem("webdevoo_user", JSON.stringify(newUser));
    user.value = newUser;
  }

  const getLocalUser = () => {
    const rawData = localStorage.getItem("webdevoo_user");

    if (!rawData) return undefined;

    try {
      return JSON.parse(rawData) as UserI;
    } catch (e) {
      console.error("Erreur de lecture du stockage:", e);
      localStorage.removeItem("webdevoo_user")
      return undefined;
    }
  }

  return { user, clearUserStored, saveSessionUser, getSessionUser, saveLocalUser, getLocalUser }
})