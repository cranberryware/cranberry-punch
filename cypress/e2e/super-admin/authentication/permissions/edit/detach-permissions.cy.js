describe("Appraisal Forms", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/permissions/10/edit");
        cy.login();
    });

    it(" detach ", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.wait(2000);
        cy.contains("Name");
        cy.contains("Guard Name");
        cy.get(".filament-tables-component > form:nth-child(3)").submit();
        cy.wait(2000);

        // detach
        cy.get(
            ".filament-tables-row:nth-child(1) .filament-link:nth-child(2)"
        ).click();
        cy.wait(2000);
        cy.get(".filament-tables-component > form:nth-child(2)").submit();

        //delete
        cy.wait(2000);
        cy.get('.filament-tables-row:nth-child(1) .filament-link:nth-child(3)').click();
        cy.get('.filament-tables-component > form:nth-child(2)').submit();
        cy.wait(2000);
    });

    it("detach selected ", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.wait(2000);
        cy.contains("Name");
        cy.contains("Guard Name");
        cy.get(".filament-tables-component > form:nth-child(3)").submit();
        cy.wait(1000);
        cy.get(
            ".filament-tables-row:nth-child(1) > .filament-tables-checkbox-cell > .block"
        ).click();
        cy.get(".filament-icon-button-icon").click();
        cy.wait(1000);
        cy.get(
            ".hover\\3A bg-danger-500:nth-child(2) > .filament-dropdown-list-item-label"
        ).click();
        cy.wait(1000);
        cy.get(".filament-tables-component > form:nth-child(3)").submit();
    });
});
