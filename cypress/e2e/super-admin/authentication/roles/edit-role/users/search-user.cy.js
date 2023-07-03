describe("user search", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/oa-dashboard/roles");
        cy.login();
    });

    it("user search", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.contains("Edit")
        .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
        .click();
        cy.get('.hover\\3Atext-gray-800').click();

        cy.get('#tableSearchInput').click();


        cy.get('#tableSearchInput').type("Subrat")


    });
});
