// describe("delete roles", () => {
//     beforeEach(() => {
//         cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
//         cy.login();
//     });

//     it("delete super-admin roles ", () => {
//         cy.get('.filament-sidebar-close-overlay').click();

//         cy.get('.filament-tables-row:nth-child(1) > .filament-tables-checkbox-cell > .block').click();
//         cy.get('.filament-tables-bulk-actions-trigger > .filament-icon-button-icon').click();
//         // cy.get('.hover\\3A bg-danger-500 > .filament-dropdown-list-item-label').click();
//         // cy.get('.flex > span:nth-child(3)').click();
//         // cy.get('.filament-tables-component > form:nth-child(3)').submit();

// cy.wait(1500);
// cy.get('.hover\\:bg-danger-500').click();
// cy.get('.filament-tables-component > form:nth-child(3)').submit();
//         cy.wait(1500);

//     });
// });

// ******************************SECOND WAY OF DELETE *********************************************

// describe("delete roles", () => {
//     beforeEach(() => {
//         cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
//         cy.login();
//     });

//     it("delete roles ", () => {
//         cy.get('.filament-sidebar-close-overlay').click();
//         cy.contains("Edit")
//         .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
//         .click();

//         cy.get('[dusk="filament.admin.action.delete"]').click();

//         cy.get('.bg-danger-600 > .flex > span').click();
//         cy.get('.bg-danger-600 span:nth-child(3)').click();
//         cy.wait(1500);

//     });
// });

// ********************************************SELECT ALL AND DESELECT ALL*****************************************************************************

describe("delete roles", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
        cy.login();
    });

    it("delete roles ", () => {
    cy.get('.filament-sidebar-close-overlay').click();
        // SELECT ALL
        cy.get(".filament-tables-checkbox-cell:nth-child(1) > .block").click();

        // DESELECT ALL
        // cy.get(".filament-tables-checkbox-cell:nth-child(1) > .block").click();

        cy.wait(2000);
        cy.get(".filament-header").click();
        cy.get(".filament-icon-button").click();
        cy.get(
            ".hover\\3A bg-danger-500 > .filament-dropdown-list-item-label"
        ).click();

        //CANCEL DELETE
        cy.get(".text-gray-800 > .flex > span").click();

        //CONFIRM DELETE
        // cy.get('.bg-danger-600').click();
        // cy.get('.filament-tables-component > form:nth-child(3)').submit();
    });
});
