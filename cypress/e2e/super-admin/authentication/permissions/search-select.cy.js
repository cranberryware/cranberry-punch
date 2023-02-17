describe("Appraisal Forms", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/permissions");
        cy.login();

    });

    it("Search", () => {
        cy.get('.filament-sidebar-close-overlay').click();
        cy.get(".filament-header").click();
        cy.get("#tableSearchInput").click();
        cy.get("#tableSearchInput").type("viewAny employees");
        cy.wait(4000);
    });


});
