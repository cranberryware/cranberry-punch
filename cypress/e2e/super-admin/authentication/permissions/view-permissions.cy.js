describe("Appraisal Forms", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/permissions/7");
        cy.login();
    });
    // it(" View", () => {
    //     cy.get('.filament-sidebar-close-overlay').click();

    //     cy.wait(2000);
    //     cy.contains("Name");
    //     cy.contains("Guard Name");
    //     cy.get(".filament-tables-component > form:nth-child(3)").submit();
    //     cy.wait(2000);

    //     // add new role
    //     cy.get('[dusk="filament.tables.action.create"]').click();
    //     cy.wait(2000);
    //     cy.get(
    //         ".px-4:nth-child(1) .col-span-1:nth-child(1) .text-sm:nth-child(1)"
    //     ).type("appraisal set3");
    //     //create another
    //     cy.wait(2000);

    //     cy.get(".filament-button-size-md:nth-child(2) > .flex > span").click();
    //     cy.wait(2000);
    //     cy.get(
    //         ".px-4:nth-child(1) .col-span-1:nth-child(1) .text-sm:nth-child(1)"
    //     ).type("employees105");
    //     //create Another
    //     cy.wait(2000);
    //     cy.get(".filament-button-size-md:nth-child(2) > .flex > span").click();
    //     cy.wait(2000);
    //     cy.get(
    //         ".px-4:nth-child(1) .col-span-1:nth-child(1) .text-sm:nth-child(1)"
    //     ).type("employee106");
    //     cy.get(".filament-tables-component > form:nth-child(2)").submit();
    //     cy.wait(2000);
    //     //edit that role
    //     cy.get(
    //         ".filament-tables-row:nth-child(3) .filament-link:nth-child(1)"
    //     ).click();
    //     // cy.get('[dusk="filament.forms.mountedTableActionData.name"]').click();
    //     cy.get('[dusk="filament.forms.mountedTableActionData.name"]').type(
    //         "employee"
    //     );
    //     cy.wait(2000);
    //     cy.get(".filament-tables-component > form:nth-child(2)").submit();
    //     cy.wait(2000);
    //     // //attach role
    //     // cy.get('.text-gray-800 > .flex > span').click();
    //     // cy.get('.choices__placeholder').type("employee11");
    //     // cy.wait(2000);
    //     // cy.get('[data-id="1"]').click();
    //     // cy.get('.filament-tables-component > form:nth-child(2)').submit();
    //     // cy.wait(2000);

    // });
    // it("delete selected ", () => {
    //     cy.get('.filament-sidebar-close-overlay').click();
    //     cy.wait(2000);
    //     cy.contains("Name");
    //     cy.contains("Guard Name");
    //    cy.get(".filament-tables-component > form:nth-child(3)").submit();
    //     cy.wait(2000);
    //    // delete selected
    //     cy.get(
    //         ".filament-tables-row:nth-child(1) > .filament-tables-checkbox-cell > .block"
    //     ).click();
    //     cy.get(".filament-icon-button-icon").click();
    //     cy.get(
    //         ".filament-dropdown-list-item:nth-child(1) > .filament-dropdown-list-item-label"
    //     ).click();
    //    cy.get(".filament-tables-component > form:nth-child(3)").submit();
    //     cy.wait(2000);
    //     //detach
    //     cy.get(
    //         ".filament-tables-row:nth-child(1) .filament-link:nth-child(2)"
    //     ).click();
    //     cy.wait(2000);
    //     cy.get(".filament-tables-component > form:nth-child(2)").submit();
    //     cy.wait(2000);
    //     cy.get('.filament-tables-row:nth-child(1) .filament-link:nth-child(3)').click();
    //    cy.get('.filament-tables-component > form:nth-child(2)').submit();

    // });
    it("detach selected ", () => {
        cy.get(".filament-sidebar-close-overlay").click();

        cy.wait(2000);
        cy.contains("Name");
        cy.contains("Guard Name");
        cy.get(".filament-tables-component > form:nth-child(3)").submit();
        cy.wait(2000);
        cy.get('[dusk="filament.tables.action.create"]').click();
        cy.wait(2000);
        cy.get(
            ".px-4:nth-child(1) .col-span-1:nth-child(1) .text-sm:nth-child(1)"
        ).type("appraisal w");
        cy.get(".filament-tables-component > form:nth-child(2)").submit();
        cy.wait(2000);
        cy.get(
            ".filament-tables-row:nth-child(1) > .filament-tables-checkbox-cell > .block"
        ).click();
        cy.get(".filament-icon-button-icon").click();
        cy.get(
            ".hover\\3A bg-danger-500:nth-child(2) > .filament-dropdown-list-item-label"
        ).click();
        cy.get(".filament-tables-component > form:nth-child(3)").submit();
    });
});
