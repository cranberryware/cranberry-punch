describe("user pagination", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/oa-dashboard/roles");
        cy.login();
    });

    it("user pagination", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.contains("Edit")
            .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
            .click();

        cy.get(".hover\\3Atext-gray-800").click();

        cy.get(
            ".filament-resources-relation-managers-container > .flex"
        ).click();

        // cy.get('.flex:nth-child(1) > #tableRecordsPerPageSelect').type('5');
        // cy.get('.flex:nth-child(1) > #tableRecordsPerPageSelect').click();

        // cy.get('div.justify-center > .flex > #tableRecordsPerPageSelect').select("5")
        cy.wait(3000);
        cy.get(
            "div.justify-center > .flex > #tableRecordsPerPageSelect"
        ).select("25");
        cy.wait(3000);
    });
});
