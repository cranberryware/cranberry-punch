describe("check dashboard", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/login");
        cy.login();
    }),
        // logout
        it("logout using function written in command", () => {
            cy.logout();
        });

    // Search bar
    it("search functionality", () => {
        cy.get(".ml-1 > .w-3 > path").click();
        cy.get("#tableSearchInput").type("nte-002");
        cy.wait(2000);
    });

    // filters
    it("check filter condition", () => {
        cy.get(".filament-tables-filters-trigger").click();
        cy.get("#tableFilters\\.attendance_month\\.value")
            .select("2023-01-01")
            .should("have.value", "2023-01-01")
            .wait(3000);
        cy.get(".choices__input--cloned").click();
        cy.get(".choices__input--cloned").type("philip Lindgren");

        cy.get(".col-span-1:nth-child(2) .grid .flex:nth-child(1)").click();
        cy.get(".filament-link").click();
        cy.wait(2000);
        cy.get(
            ".filament-widget:nth-child(1) .filament-tables-header-toolbar"
        ).click();
        cy.get(".w-5 > .w-5:nth-child(1)").click();
        cy.wait(2000);
    });
});
