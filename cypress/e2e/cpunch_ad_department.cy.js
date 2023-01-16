import { slowCypressDown } from "cypress-slow-down";

describe("Admin_Department spec", () => {
    beforeEach(() => {
        slowCypressDown(200);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.adminLogin();
    });
    it("Should test the Department section", () => {

      cy.log("Should test add new department---------------" )
      cy.visit('http://localhost:8000/cp-dashboard/departments');
      cy.contains('New Department').click();
      cy.get('input[id="data.name"]').click();
      cy.get('input[id="data.name"]').type('Test Dept');
      cy.get('textarea[id="data.description"]').click();
      cy.get('textarea[id="data.description"]').type('This dept. is fro testing');
      cy.get('select[id="data.parent_id"]').select('Technology').should('have.value', '9')
      cy.get('.filament-form').submit();

      cy.log("Should test Edit Department--------------")
      cy.visit('http://localhost:8000/cp-dashboard/departments');
      cy.contains('Test Dept').click();
      cy.get('textarea[id="data.description"]').click();
      cy.get('textarea[id="data.description"]').clear();
      cy.get('textarea[id="data.description"]').type('This dept. is for testing and development');
      cy.get('select[id="data.parent_id"]').select('IT and Infrastructure').should('have.value', '6')
      cy.get('.filament-form').submit();
      cy.url().should('contains', 'http://localhost:8000/cp-dashboard/departments');
      

      cy.log("Should test delete department-----------")
      cy.contains('Test Dept').click().wait(500);
      cy.contains('Delete').click().wait(1000);
      cy.get('.filament-page > form:nth-child(2)').submit();

    });
});
