describe("employee", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/employees");
        cy.login();
        cy.get(
            `[x-data="{ label: 'Employee Management' }"] > .text-sm > :nth-child(3) > .items-center`
        ).click();
    });
    it("Pagination", () => {
        cy.get(
            "li:nth-child(2) > .filament-tables-pagination-item > span"
        ).click();
        cy.get(
            "div.justify-center > .flex > #tableRecordsPerPageSelect"
        ).select("10");
        cy.wait(3000);
        cy.get(
            "div.justify-center > .flex > #tableRecordsPerPageSelect"
        ).select("25");
        cy.wait(2000);
    });
    it("Designation Filter", () => {
        cy.get(
            ".filament-tables-header-toolbar > .justify-end > .filament-dropdown > .filament-dropdown-trigger > .filament-icon-button"
        ).click();
        cy.contains("Deleted records").should("be.visible");
        cy.get('[dusk="filament.forms.tableFilters.trashed.value"]')
            .select("1")
            .should("have.value", "1")
            .wait(3000);
        cy.get('[dusk="filament.forms.tableFilters.trashed.value"]')
            .select("")
            .should("have.value", "")
            .wait(3000);
        cy.get('[dusk="filament.forms.tableFilters.trashed.value"]')
            .select("0")
            .should("have.value", "0")
            .wait(3000);
        cy.get(".text-danger-600").dblclick();
        cy.get(
            ".filament-tables-filters-trigger > .filament-icon-button-icon"
        ).click();
    });
    it("delete selected  ", () => {
        cy.get(
            ".filament-tables-row:nth-child(9) > .filament-tables-checkbox-cell > .block"
        ).click();
        cy.get(
            ".filament-tables-row:nth-child(8) > .filament-tables-checkbox-cell > .block"
        ).click();
        cy.get(
            ".filament-tables-bulk-actions-trigger > .filament-icon-button-icon"
        ).click();
        cy.get(
            ".hover\\3A bg-danger-500 > .filament-dropdown-list-item-label"
        ).click();
        cy.get(".bg-danger-600").click();
        cy.get(".filament-tables-component > form:nth-child(3)").submit();
        cy.wait(2000);
        cy.get(
            ".filament-tables-row:nth-child(10) > .filament-tables-checkbox-cell > .block"
        ).click();
        cy.get(".filament-tables-bulk-actions-trigger path").click();
        cy.get(".filament-tables-bulk-action:nth-child(2)").click();
    });

});
