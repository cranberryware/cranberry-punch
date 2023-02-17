describe("attach permissions", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
        cy.login();
    });

    it("attach permissions", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.contains("Edit")
            .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
            .click();

        cy.get(".filament-form-actions").click();
        cy.get(".text-gray-800 > .flex > span").click();

        cy.get(".choices__inner")
            .eq(0)
            .should("be.visible")
            .type("viewAny roles");
        cy.wait(2000);
        // cy.get(
        //     "#choices--mountedTableActionDatarecordId-item-choice-1"
        // ).click();

        cy.get(".filament-tables-component > form:nth-child(2)").submit();
    });
});
