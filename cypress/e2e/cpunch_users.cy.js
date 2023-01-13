import { slowCypressDown } from "cypress-slow-down";

Cypress.on('uncaught:exception', (err, runnable) => {
  return false;
});
describe("empty spec", () => {
    beforeEach(() => {
        slowCypressDown(200);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.adminLogin();
    });
    it("Should test Users section", () => {
        cy.visit("http://localhost:8000/cp-dashboard/users");

        cy.log("Should test adding new user--------------")
        cy.contains("New User").click();
        cy.get('input[id="data.name"]').click();
        cy.get('input[id="data.name"]').type("Test");
        cy.get('input[id="data.email"]').click();
        cy.get('input[id="data.email"]').type("test@example.com");
        cy.get('input[id="data.password"]').click();
        cy.get('input[id="data.password"]').type("password");
        cy.get('input[id="data.passwordConfirmation"]').click();
        cy.get('input[id="data.passwordConfirmation"]').type("password");
        cy.get('input[name="search_terms"]').click();
        cy.get('div[id="choices--dataroles-item-choice-1"]').click();
        cy.get("body").click(0, 0);
        cy.get(".filament-form").submit();

        cy.log("Should test user edit------------------");
        cy.visit("http://localhost:8000/cp-dashboard/users");
        cy.get('input[id="tableSearchInput"]').click();
        cy.get('input[id="tableSearchInput"]').type("test").wait(1000);
        cy.contains("Edit").click();
        cy.get('input[id="data.name"]').click();
        cy.get('input[id="data.name"]').clear();
        cy.get('input[id="data.name"]').type("Testing");
        cy.get('input[id="data.email"]').click();
        cy.get('input[id="data.email"]').clear();
        cy.get('input[id="data.email"]').type("testing@example.com");
        cy.get('input[id="data.password"]').click();
        cy.get('input[id="data.password"]').type("password1");
        cy.get('input[id="data.passwordConfirmation"]').click();
        cy.get('input[id="data.passwordConfirmation"]').type("password1");
        cy.get(".choices__input--cloned").click();
        cy.get('input[name="search_terms"]').click();
        cy.get('button[class="choices__button"]').eq(0).click();
        cy.get('div[id="choices--dataroles-item-choice-2"]').click();
        cy.get("body").click(0, 0);
        cy.get(".filament-form").submit().wait(1000);

        cy.log("Should test delete functionality--------")
        cy.get(".bg-danger-600 > .flex > span").click();
        cy.get(".bg-danger-600 span:nth-child(3)").click();
        cy.get(".filament-page > form:nth-child(2)").submit();
        cy.url().should("contains", "http://localhost:8000/cp-dashboard/users");

        cy.log("Should test adding new user--------------")
        cy.contains("New User").click();
        cy.get('input[id="data.name"]').click();
        cy.get('input[id="data.name"]').type("Test");
        cy.get('input[id="data.email"]').click();
        cy.get('input[id="data.email"]').type("test@example.com");
        cy.get('input[id="data.password"]').click();
        cy.get('input[id="data.password"]').type("password");
        cy.get('input[id="data.passwordConfirmation"]').click();
        cy.get('input[id="data.passwordConfirmation"]').type("password");
        cy.get('input[name="search_terms"]').click();
        cy.get('div[id="choices--dataroles-item-choice-1"]').click();
        cy.get("body").click(0, 0);
        cy.get(".filament-form").submit();
        cy.contains("Users").click();
    });
});
