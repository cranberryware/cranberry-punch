// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
Cypress.Commands.add('login', (email='admin@example.com', password='password') => { 
    cy.get("#email").type(email);
    cy.get("#password").type(password);
    cy.get('.bg-primary-600').click()
    cy.go('forward')
 })

 Cypress.Commands.add('logout',()=>{
    cy.get('.block > .w-10').click()
    cy.get('.filament-dropdown-list-item').click()
 })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })