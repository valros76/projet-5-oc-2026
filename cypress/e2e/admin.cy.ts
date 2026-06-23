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

    // 1. On injecte la valeur 9999 (qui déclenche le message métier)
    cy.get('#securityCode').invoke('val', 9999).trigger('input')

    // 2. On supprime l'attribut 'max' ou on dit au formulaire de ne pas valider
    cy.get('form').invoke('attr', 'novalidate', 'true')

    // 3. On soumet
    cy.get('button[type="submit"]').click()

    // 4. L'erreur métier apparaît enfin
    cy.get('li.error', { timeout: 6000 })
      .should('be.visible')
      .and('contain', 'CODE DE SÉCURITÉ INVALIDE !')
  })

  it('4. Valide que l\'accès est refusé (404) pour un utilisateur qui n\'existe pas', () => {
    cy.contains('Je veux me connecter').click()

    cy.get('#email').type('admin@webdevoo.com')
    cy.get('input[placeholder="Mot de passe"]').type('MonMotDePasseValide')

    const secureCode = Cypress.env('VITE_SECURITY_KEY') || '1000'
    cy.get('#securityCode').clear().type(secureCode)

    // On intercepte pour vérifier le rejet 401
    cy.intercept('POST', '**/api/v1/auth/connexion').as('loginRequest')

    cy.get('button[type="submit"]').click()

    // On attend le 401
    cy.wait('@loginRequest').its('response.statusCode').should('eq', 404)

    // On vérifie qu'on est bien resté sur la page de connexion (pas de redirection)
    cy.url().should('not.include', '/admin/statistiques')
  })
})