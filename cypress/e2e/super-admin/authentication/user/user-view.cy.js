describe("Open User", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/users");
        cy.login();
        cy.wait(2000);
    });
    it("Should check User View", () => {
        cy.get('.filament-sidebar-close-overlay').click();
        cy.contains("View")
            .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
            .click();
        cy.wait(2000);
        cy.contains("Name").should("be.visible");
        // cy.contains("Email").should("be.visible");
        cy.contains("Password").should("be.visible");
        cy.contains("Confirm Password").should("be.visible");
        cy.wait(2000);
        cy.get('.filament-page-actions > .inline-flex').click();
        cy.wait(2000);
    });

});
