import { slowCypressDown } from "cypress-slow-down";
Cypress.on("uncaught:exception", (err, runnable) => {
    return false;
});
describe("Admin_Holiday spec", () => {
    beforeEach(() => {
        slowCypressDown(200);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.adminLogin();
    });
    it("Should test the Holiday section", (employeeId = "NTE-006: Rafael Wehner", name = "Rafael Wehner") => {
        cy.log("Should test the add Holiday--------------------");
        cy.visit("http://localhost:8000/cp-dashboard/holidays");
        cy.contains("New holiday").click();
        cy.get('input[id="data.date"]').click().wait(500);
        cy.contains("23").click().wait(500);
        cy.get('input[id="data.holiday_name"]').type("Test Holiday");
        cy.get('select[id="data.holiday_type"]')
            .select("test holiday")
            .should("have.value", "test-holiday");
        cy.get('button[id="data.is_confirmed"]').click();
        cy.get('button[id="data.is_confirmed"]').click();
        cy.get("span:nth-child(3)").click();

        cy.log("Should test the Edit Holiday---------------------");
        cy.visit("http://localhost:8000/cp-dashboard/holidays");
        cy.contains("Test Holiday").click();
        cy.contains("Edit").click();
        cy.get('input[id="data.date"]').click().wait(500);
        cy.contains("23").click().wait(500);
        cy.get('input[id="data.holiday_name"]').clear();
        cy.get('input[id="data.holiday_name"]').type("Updated Test Holiday");
        cy.get('select[id="data.holiday_type"]')
            .select("Another test holiday")
            .should("have.value", "another-test-holiday");
        cy.get('button[id="data.is_confirmed"]').click();
        cy.get('button[id="data.is_confirmed"]').click();
        cy.contains("Save changes").click();

        cy.log("Should test the delete holiday------------------");
        cy.contains("Delete").click();
        cy.get(".filament-page-modal-button-action:nth-child(2)").click();
        cy.get(".filament-page > form:nth-child(2)").submit();
    });
});
