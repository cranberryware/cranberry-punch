describe("roles search", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
        cy.login();
    });

    it("roles search", () => {
        cy.get('.filament-sidebar-close-overlay').click();
        cy.get(".filament-header").click();
        cy.get("#tableSearchInput").click();

        cy.get("#tableSearchInput").type("Nt");
        cy.get(2000);
        cy.get("#tableSearchInput").clear();
        cy.get(1000);
        cy.get("#tableSearchInput").type("writer");

    });


});
