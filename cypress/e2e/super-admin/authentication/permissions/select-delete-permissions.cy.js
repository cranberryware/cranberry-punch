describe("Appraisal Forms", () => {
    beforeEach(() => {
        cy.visit(
            "http://127.0.0.1:8000/cp-dashboard/permissions/10/edit?activeRelationManager=0"
        );
        cy.login();
    });

    it("delete selected  ", () => {
        cy.get(".filament-sidebar-close-overlay").click();

        cy.wait(2000);
        cy.contains("Name");
        cy.contains("Guard Name");
        cy.get(".filament-tables-component > form:nth-child(3)").submit();
        cy.wait(2000);

        // delete selected

        cy.get(".space-y-6:nth-child(1)").click();
        cy.get(
            ".filament-tables-row:nth-child(2) > .filament-tables-checkbox-cell > .block"
        ).click();
        cy.get(".filament-icon-button").click();
        cy.get(
            ".filament-dropdown-list-item:nth-child(1) > .filament-dropdown-list-item-label"
        ).click();
        cy.get(".filament-tables-modal-button-action:nth-child(1)").click();

        // delete
        cy.wait(2000);
        cy.get(
            ".filament-tables-row:nth-child(1) .filament-link:nth-child(3)"
        ).click();
        cy.get(".filament-tables-component > form:nth-child(2)").submit();
        cy.wait(2000);
    });
});
