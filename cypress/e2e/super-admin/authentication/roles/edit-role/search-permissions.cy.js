describe("search permissions", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
        cy.login();
    });

    it("search permission", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.contains("Edit")
        .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
        .click();
        cy.get('.filament-header').click();
        cy.get('#tableSearchInput').click();

        cy.get('#tableSearchInput').type("aisurya")


    });
});
