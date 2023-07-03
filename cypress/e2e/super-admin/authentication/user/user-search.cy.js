describe("user search", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/users");
        cy.login();
    });

    it("user search", () => {
        cy.get('.filament-sidebar-close-overlay').click();
        cy.get(".filament-header").click();
        cy.get("#tableSearchInput").click();

        cy.get("#tableSearchInput").type("Aisurya");
        cy.get(2000);
        cy.get("#tableSearchInput").clear();
        cy.get(1000);
        cy.get("#tableSearchInput").type("jamir");
    });
});
