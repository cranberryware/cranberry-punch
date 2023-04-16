describe("Appraisal Forms", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/permissions/10/edit?activeRelationManager=0");
        cy.login();
    });

    it("delete ", () => {
        cy.get('.filament-sidebar-close-overlay').click();
        cy.wait(2000);
        cy.contains("Name");
        cy.contains("Guard Name");
        cy.get(".filament-tables-component > form:nth-child(3)").submit();
        cy.wait(1000);
        cy.get('[dusk="filament.admin.action.delete"]').click();
        cy.wait(1000);
    });
});
