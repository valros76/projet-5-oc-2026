/// <reference types="cypress" />

describe("E2E - Connexion administrateur et accès aux statistiques", () => {
  it("1. Connexion robuste et test de pagination", () => {
    cy.visit("/admin/register");
    const username = "test.admin@webdevoo.com";
    const password = "SuperTester@42";
    const secureCode = Cypress.env("VITE_SECURITY_KEY") || "1000";

    cy.contains('Je veux me connecter').click();

    // 1. Interception de la première tentative de connexion
    cy.intercept('POST', '**/api/v1/auth/connexion').as('firstLogin');

    cy.get('#email').type(username);
    cy.get('input[placeholder="Mot de passe"]').type(password);
    cy.get('#securityCode').clear().type(secureCode);
    cy.get('button[type="submit"]').click();

    // 2. Logique conditionnelle basée sur la réponse de l'API
    cy.wait('@firstLogin').then((interception) => {
      const status = interception.response?.statusCode;

      if (status === 404) {
        cy.log("Utilisateur non trouvé, inscription en cours...");
        cy.contains('Je n\'ai pas de compte').click();

        cy.get('#email').type(username);
        cy.get('input[placeholder="Mot de passe"]').type(password);
        cy.get('#securityCode').clear().type(secureCode);

        cy.intercept('POST', '**/api/v1/auth/register').as('signInRequest');
        cy.get('button[type="submit"]').click();
        cy.wait('@signInRequest').its('response.statusCode').should('eq', 201);

        // Reconnexion après inscription
        cy.contains('Je veux me connecter').click();
        cy.get('#email').type(username);
        cy.get('input[placeholder="Mot de passe"]').type(password);
        cy.get('#securityCode').clear().type(secureCode);
        cy.get('button[type="submit"]').click();
      }

      // 3. Accès aux statistiques
      cy.url({ timeout: 10000 }).should('include', '/admin/statistiques');

      // On intercepte explicitement le chargement des données des logs
      cy.intercept('GET', '**/api/v1/analytics/view-events*').as('getLogs');
      cy.wait('@getLogs', { timeout: 15000 }); // Attendre que l'API réponde

      cy.get('table').should('be.visible');

      // 4. Test de pagination robuste
      // Cypress attendra jusqu'à 10s que les éléments .pagination-btn apparaissent
      cy.get('.pagination-btn', { timeout: 10000 }).then(($btns) => {

        // Filtrage des boutons numériques > 1
        const filteredButtons = $btns.filter((_, el) => {
          const text = Cypress.$(el).text().trim();
          return !isNaN(Number(text)) && Number(text) > 1;
        });

        const buttonsToTest = filteredButtons.slice(0, 5);

        if (buttonsToTest.length === 0) {
          cy.log("Aucune page supplémentaire trouvée, test de pagination ignoré.");
        } else {
          // Itération sur les boutons trouvés
          cy.wrap(buttonsToTest).each(($el) => {
            cy.wait(1000); // Délai visuel pour le testeur
            cy.wrap($el).click();

            // On attend que les nouvelles données de la page cliquée soient chargées
            cy.wait('@getLogs');

            // Vérification après clic
            cy.get('table').should('be.visible');
          });
        }
      });
    });
  });
});