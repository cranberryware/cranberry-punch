describe("New User", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/users");
        cy.login();
    });
    it("Create User", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.get(".filament-page-actions > .inline-flex > span").click();

        cy.get("#data\\.name").click();
        cy.get("#data\\.name").type("aisurya ");
        cy.get("#data\\.email").click();

        cy.get("#data\\.email").type("ashu@gmail.com");
        cy.get("#data\\.password").click();
        cy.get("#data\\.password").type("123");
        cy.get("#data\\.passwordConfirmation").click();

        cy.get("#data\\.passwordConfirmation").type("123");
        cy.get(".space-y-6:nth-child(1)").click();
        cy.get(".choices__inner").click();
        cy.get('[data-id="2"]').click();

        cy.get(".filament-form").submit();
    });
});
