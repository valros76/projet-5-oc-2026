/// <reference types="cypress" />

describe("E2E - Tests des Landing Pages", () => {

  it("1. Teste le calculateur de cotisations (Gîte)", () => {
    cy.visit("/gites/site-pour-gite-en-baie-de-somme");

    // Test de validation
    cy.get('#percent').clear().type('0');
    cy.contains('La cotisation doit être supérieure à 0%').should('be.visible');

    // Test de calcul
    cy.get('#percent').clear().type('10');
    cy.get('#nightPrice').clear().type('100');
    cy.get('#nbChambers').clear().type('2');

    // Formule : 100 * (10/100) * 365 * 2 = 7 300 €
    cy.contains('7 300,00 €').should('be.visible');
  });

  it("2. Teste le sélecteur de région/département (Artisan)", () => {
    cy.visit("/artisans/site-pour-artisan-en-baie-de-somme");

    // Test de sélection
    cy.get('#userRegion').select('Hauts-de-France');
    cy.get('#userDepartment').should('be.visible').select('Somme');

    // Vérifie que le lien de recherche apparaît et contient le département
    cy.contains('Lancer la recherche locale')
      .should('have.attr', 'href')
      .and('include', 'somme');
  });

  it("3. Teste le sélecteur métier/ville (Artisan)", () => {
    cy.visit("/artisans/site-pour-artisan-en-baie-de-somme");

    // 1. Sélectionne par la valeur précise (le texte exact de l'option)
    cy.get('#jobSelect').select('Ébéniste');

    // 2. Ajoute un blur pour déclencher le handleBlur si nécessaire
    cy.get('#jobSelect').blur();

    // 3. Remplissage de la ville
    cy.get('#city').clear().type('Amiens');
    cy.get('#city').blur();

    // 4. Assertion plus souple : on vérifie que le paragraphe contient bien les deux infos
    // On utilise une expression régulière ou on vérifie la présence du texte attendu
    cy.contains('Vous avez indiqué être ébéniste, à Amiens', { matchCase: false }).should('be.visible');
  });

  it("4. Teste le calculateur de potentiel de vente (Commerçant)", () => {
    cy.visit("/commercants/site-pour-boutique-commercant-local-en-baie-de-somme");

    // Saisie des valeurs
    cy.get('#nbCustomers').clear().type('100');
    cy.get('#averageCart').clear().type('50');
    cy.get('#nbFollowers').clear().type('1000');
    cy.get('#manualConversionRate').clear().type('20');

    // Vérification des résultats
    // CA boutique = 100 * 50 = 5000
    // CA conversion = 1000 * 0.20 * 50 = 10000
    // Total = 15000
    cy.contains('15 000 € de CA global').should('be.visible');
  });
});