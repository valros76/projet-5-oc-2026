/// <reference types="cypress" />

describe('E2E - Espace Administrateur', () => {

  beforeEach(() => {
    cy.visit('/admin/register')
  })

  it('1. Permet de basculer entre le formulaire d\'inscription et de connexion', () => {
    cy.get('h2').should('contain', 'Inscription d\'un nouvel administrateur')
    cy.contains('Je veux me connecter').click()
    cy.get('h2').should('contain', 'Connexion d\'un administrateur')
    cy.contains('Je n\'ai pas de compte').click()
    cy.get('h2').should('contain', 'Inscription d\'un nouvel administrateur')
  })

  it('2. Permet de masquer/afficher le mot de passe', () => {
    cy.get('input[placeholder="Mot de passe"]').should('have.attr', 'type', 'password')
    cy.contains('Voir mon mot de passe').click()
    cy.get('input[placeholder="Mot de passe"]').should('have.attr', 'type', 'text')
    cy.contains('Masquer mon mot de passe').click()
    cy.get('input[placeholder="Mot de passe"]').should('have.attr', 'type', 'password')
  })

  it('3. Bloque la soumission si le code de sécurité est incorrect', () => {
    cy.contains('Je veux me connecter').click()

    cy.get('#email').type('test.admin@webdevoo.com')
    cy.get('input[placeholder="Mot de passe"]').type('SuperPassword123!')

    // 🚀 CORRECTION : Utilisation de {force: true} ET trigger('change')
    // Le 'change' est souvent nécessaire pour que Vue.js synchronise le v-model
    cy.get('#securityCode')
      .clear()
      .invoke('val', 9999)
      .trigger('input')
      .trigger('change') // Important pour forcer la mise à jour du state Vue

    cy.get('button[type="submit"]').click()

    // Assertion : On cherche l'élément LI avec la classe error
    cy.get('li.error', { timeout: 3000 })
      .should('be.visible')
      .and('contain', 'CODE DE SÉCURITÉ INVALIDE !')
  })

  it('4. Valide que l\'accès est refusé (401) pour un utilisateur sans droits', () => {
    cy.contains('Je veux me connecter').click()

    cy.get('#email').type('admin@webdevoo.com')
    cy.get('input[placeholder="Mot de passe"]').type('MonMotDePasseValide')

    const secureCode = Cypress.env('VITE_SECURITY_KEY') || '1000'
    cy.get('#securityCode').clear().type(secureCode)

    // On intercepte pour vérifier le rejet 401
    cy.intercept('POST', '**/api/v1/auth/connexion').as('loginRequest')

    cy.get('button[type="submit"]').click()

    // On attend le 401
    cy.wait('@loginRequest').its('response.statusCode').should('eq', 401)

    // On vérifie qu'on est bien resté sur la page de connexion (pas de redirection)
    cy.url().should('not.include', '/admin/statistiques')
  })
})