describe("user edit wrong data", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/users");
        cy.login();
    });
    it("user edit wrong data ", () => {
        cy.get('.filament-sidebar-close-overlay').click();
        cy.contains("Edit")
            .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
            .click();
        //Fill the Edit form
        cy.get("#data\\.name").click();
        // cy.get('#data\\.name').clear().type('aisurya ');
        cy.get("#data\\.email").click();

        cy.get("#data\\.email").clear().type("rima@gmail.com");
        cy.get("#data\\.password").click();
        cy.get("#data\\.password").type("123");
        cy.get("#data\\.passwordConfirmation").click();

        cy.get("#data\\.passwordConfirmation").clear().type("1213");
        cy.get(".space-y-6:nth-child(1)").click();
        cy.get(".choices__inner").click();
        cy.get('[data-id="2"]').click();

        cy.get(".filament-form").submit();
    });
});
