
describe("attach user", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
        cy.login();
    });

    it("attach user", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.contains("Edit")
        .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
        .click();
        cy.get('.hover\\3Atext-gray-800').click();
        cy.get('.filament-form-actions').click();
        cy.wait(1000);
        cy.get('.text-gray-800 > .flex > span').click();
        cy.wait(1000);

        cy.get(".choices__inner")
            .eq(0)
            .should("be.visible")
            .type("apur");
        cy.wait(2000);
        cy.get('#choices--mountedTableActionDatarecordId-item-choice-1').click();

        cy.get('.filament-tables-component > form:nth-child(2)').submit();


    });
});
