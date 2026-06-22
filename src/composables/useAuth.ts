import type { UserAuthI } from "@/interfaces/userI";

export const useAuth = () => {
  const apiPath = import.meta.env.VITE_API_URL ?? "https://webdevoo.com/api";

  const postRequest = async (endpoint: string, data: UserAuthI): Promise<Response> => {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 2000);

    try {
      const response = await fetch(`${apiPath}${endpoint}`, {
        signal: controller.signal,
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      });
      return response;
    } finally {
      clearTimeout(timeoutId);
    }
  }

  const registerAdmin = (user: UserAuthI) => postRequest("/v1/auth/register", user);
  const connexionAdmin = (user: UserAuthI) => postRequest("/v1/auth/connexion", user);

  return { registerAdmin, connexionAdmin };
};