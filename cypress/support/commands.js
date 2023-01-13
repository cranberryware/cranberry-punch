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
// Cypress.Commands.add('login', (email, password) => { ... })
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

import "cypress-localstorage-commands";
Cypress.Commands.add(
    "login",
    (email = "erin19@yahoo.com", password = "password") => {
        cy.get('input[type="email"]').type(email).wait(500);
        cy.get('input[type="password"]').type(password).wait(500);
        cy.get('input[type="checkbox"]').check().wait(500);
        cy.get('button[type="submit"]').click().wait(500);
    }
);
Cypress.Commands.add(
    "adminLogin",
    (email = "admin@example.com", password = "password") => {
        cy.get('input[type="email"]').type(email).wait(500);
        cy.get('input[type="password"]').type(password).wait(500);
        cy.get('input[type="checkbox"]').check().wait(500);
        cy.get('button[type="submit"]').click().wait(500);
    }
);

Cypress.Commands.add("logout", () => {
    cy.wait(1500);
    cy.get(".bg-gray-200").click();
    cy.wait(1000);
    cy.get('form > .filament-dropdown-list-item > .filament-dropdown-list-item-label').click().wait(500);
    // cy.get(".filament-dropdown-item:nth-child(2) > .truncate").click();
});