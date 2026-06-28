export const useTracker = () => {
  const apiPath = import.meta.env.VITE_MODE === "production" ? import.meta.env.VITE_API_URL : "/api";
  const apiAnalyticsPath = `${apiPath}/v1/analytics`;

  const trackEvent = async (eventName: string, metadata: Record<string, any> = {}) => {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 2000);
    try {
      await fetch(apiAnalyticsPath, {
        signal: controller.signal,
        method: "POST",
        credentials: "include",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          event_name: eventName,
          page_url: window.location.href,
          metadata: metadata // C'est ici qu'on passe les données de tracking, au format JSON
        })
      });
    } catch (e: unknown) {
      if (e instanceof Error) {
        if (e.name === "AbortError") {
          console.warn("Tracking annulé : timeout dépassé");
        } else {
          console.error("Tracking error", e);
        }
      } else {
        // Cas où 'e' n'est pas une instance d'Error (ex: throw "une chaine")
        console.error("Erreur inconnue:", e);
      }
    } finally {
      // TRÈS IMPORTANT : On arrête le timer si la requête est finie
      clearTimeout(timeoutId);
    }
  };

  const getTrackEvents = async (offset: number = 0, limit: number = 250, signal?: AbortSignal) => {
    const url = `${apiAnalyticsPath}/view-events?offset=${offset}&limit=${limit}`;
    const response = await fetch(url, { signal, method: "GET", credentials: "include"});
    if (!response.ok) throw new Error("Erreur réseau");
    return await response.json();
  }

  const countEvents = async () => {
    const url = `${apiAnalyticsPath}/count-events`;
    const response = await fetch(url, { method: "GET", credentials: "include" });
    if (!response.ok) throw new Error("Erreur lors de l'appel à l'API pour lancer countEvents.");
    const result = await response.json();
    const count = Number(result.params[0].events_count);
    return count;
  }

  return { trackEvent, getTrackEvents, countEvents };
};

