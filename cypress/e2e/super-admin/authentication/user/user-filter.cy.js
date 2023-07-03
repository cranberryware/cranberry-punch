describe("user filter", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/users");
        cy.login();
    });

    it("department Form filter", () => {
        cy.get('.filament-sidebar-close-overlay').click();
        cy.get(
            ".filament-tables-filters-trigger > .filament-icon-button-icon"
        ).click();
        // cy.get('[dusk="filament.forms.tableFilters.trashed.value"]').select('1').should('have.value', '1').wait(3000)
        // cy.get('[dusk="filament.forms.tableFilters.trashed.value"]').select('').should('have.value', '').wait(3000)
        cy.get('[dusk="filament.forms.tableFilters.email_verified_at.value"]')
            .select("0")
            .should("have.value", "0")
            .wait(3000);
        cy.get(".text-danger-600").dblclick();
    });
});
