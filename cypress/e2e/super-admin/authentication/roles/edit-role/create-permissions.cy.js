describe("create permissions", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
        cy.login();
    });

    it("create permissions", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.contains("Edit")
            .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
            .click();
        cy.get(".filament-button-size-sm:nth-child(1) > .flex > span").click();
        cy.get("#mountedTableActionData\\.name").click();
        cy.get("#mountedTableActionData\\.name").click();
        cy.get("#mountedTableActionData\\.name").click();
        cy.get("#mountedTableActionData\\.name").type("laravel");
        cy.get("#mountedTableActionData\\.guard_name").dblclick();
        cy.get("#mountedTableActionData\\.guard_name").click();
        cy.get(".filament-tables-modal-button-action:nth-child(1)").click();
        cy.get(".filament-tables-component > form:nth-child(2)").submit();
    });
});
