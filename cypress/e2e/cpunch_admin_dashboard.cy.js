import { slowCypressDown } from "cypress-slow-down";

describe("empty spec", () => {
    beforeEach(() => {
        slowCypressDown(200);
        cy.viewport(1440, 900);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.adminLogin();
    });

    it("Should test Admin dashboard and profile section", (name = "Rafael Wehner", email = "stephania02@bashirian.com", newName = "Rafael Jones", newEmail = "stephania02@yahoo.com") => {
        cy.get('input[id="globalSearchInput"]').type("Rafael Wehner");
        cy.get('li[class="filament-global-search-result"]').click();

        cy.log("should test name and email editing-----------------");
        cy.get('input[id="data.name"]').clear();
        cy.get('input[id="data.email"]').clear();
        cy.get('input[id="data.name"]').should("have.value", "");
        cy.get('input[id="data.email"]').should("have.value", "");
        cy.get('input[id="data.name"]').type(newName);
        cy.get('input[id="data.email"]').type(newEmail);
        cy.contains("Save changes").click();
        cy.get('input[id="data.name"]').clear();
        cy.get('input[id="data.email"]').clear();
        cy.get('input[id="data.name"]').type(name);
        cy.get('input[id="data.email"]').type(email);
        cy.contains("Save changes").click();

        cy.log("should test edit password----------------");
        cy.get('input[id="data.password"]').type("new_password");
        cy.get('input[id="data.passwordConfirmation"]').type(
            "diff_new_password"
        );
        cy.contains("Save changes").click();

        cy.get('input[id="data.password"]').clear();
        cy.get('input[id="data.passwordConfirmation"]').clear();
        cy.get('input[id="data.password"]').type("new_password");
        cy.get('input[id="data.passwordConfirmation"]').type("new_password");
        cy.contains("Save changes").click();

        cy.get('input[id="data.password"]').clear();
        cy.get('input[id="data.passwordConfirmation"]').clear();
        cy.get('input[id="data.password"]').type("password");
        cy.get('input[id="data.passwordConfirmation"]').type("password");
        cy.contains("Save changes").click();

        cy.get('input[name="search_terms"]').click();
        cy.get('div[id="choices--dataroles-item-choice-2"]').click();
        cy.get("body").click(0, 0);
        cy.contains("Save changes").click();
        cy.wait(1000);
        cy.contains("View").click();
        cy.contains("Edit").click();
        cy.contains("View").click();
        cy.contains("Dashboard").click();

        cy.get('input[id="tableSearchInput"]').type("Rafael Wehner");
        cy.get(".filament-tables-filters-trigger").click();
        cy.get('input[id="tableSearchInput"]').clear()
        cy.get(".filament-tables-filters-trigger").click();
        cy.get('select[id="tableFilters.attendance_month.value"]').select(
            "November 2022"
        );
        cy.get(".filament-tables-filters-trigger").click();

    });
});
