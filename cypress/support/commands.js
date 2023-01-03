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
        cy.get('input[type="email"]').type(email);
        cy.get('input[type="password"]').type(password);
        cy.get('input[type="checkbox"]').check();
        cy.get('button[type="submit"]').click();
    }
);

Cypress.Commands.add("logout", () => {
    cy.wait(1500);
    cy.get(".bg-gray-200").click();
    cy.wait(1000);
    cy.get('form > .filament-dropdown-list-item > .filament-dropdown-list-item-label').click();
    // cy.get(".filament-dropdown-item:nth-child(2) > .truncate").click();
});

//APIs
Cypress.Commands.add('clientLogin', (username = Cypress.env('api_username'), pass = Cypress.env('api_password')) => {

    cy.request("POST", Cypress.env('login'), {
            email: username,
            password: pass,
        }).then((res) => {
            expect(res.status).to.eq(201);
            cy.setLocalStorage("token", res.body.token);
            // console.log(res.body.token);
        });

});