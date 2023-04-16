describe("edit permissions", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
        cy.login();
    });

    it("edit permissions", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.contains("Edit")
        .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
        .click();
        cy.get('.filament-tables-row:nth-child(1) .filament-link:nth-child(1)').click();

        cy.get('#mountedTableActionData\\.name').click();
        cy.get('#mountedTableActionData\\.name').dblclick();
        cy.get('#mountedTableActionData\\.name').clear().type('viewAny departments');


        cy.get('#mountedTableActionData\\.guard_name').click();
        cy.get('#mountedTableActionData\\.guard_name').clear().type('web');

        cy.get('.filament-tables-modal-button-action:nth-child(1)').click();
        cy.get('.filament-tables-component > form:nth-child(2)').submit();


    });
});
