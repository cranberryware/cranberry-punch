// describe("delete user", () => {
//     beforeEach(() => {
//         cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
//         cy.login();
//     });

//     it("delete user", () => {
//         cy.get('.filament-sidebar-close-overlay').click();

//         cy.contains("Edit")
//             .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
//             .click();
//         cy.get(".hover\\3Atext-gray-800").click();
//         cy.wait(1500);
//         cy.get(
//             ".filament-tables-row:nth-child(1) > .filament-tables-checkbox-cell > .block"
//         ).click();
//         cy.get(
//             ".filament-tables-bulk-actions-trigger > .filament-icon-button-icon"
//         ).click();

//         cy.wait(1500);
//         cy.get(".filament-dropdown-list-item:nth-child(1)").click();

//         cy.get(".filament-tables-component > form:nth-child(3)").submit();
//     });
// });

// *********************************************SECOND WAY OF DELETE*******************************************************

describe("delete user", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/roles");
        cy.login();
    });

    it("delete user", () => {
        cy.get('.filament-sidebar-close-overlay').click();
        cy.contains("Edit")
            .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
            .click();
        cy.get(".hover\\3Atext-gray-800").click();
        cy.wait(1500);
        cy.get(
            ".filament-tables-row:nth-child(1) .filament-link:nth-child(3)"
        ).click();
        cy.get(".filament-tables-component > form:nth-child(3)").submit();
        cy.wait(1500);
    });
});

// *************************************************************ALL  SELECT ALL DESELECT**************************************************

// describe("delete user", () => {
//     beforeEach(() => {
//         cy.visit("http://127.0.0.1:8000/oa-dashboard/roles");
//         cy.login();
//     });

//     it("delete user", () => {
//         cy.contains("Edit")
//             .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
//             .click();
//         cy.get(".hover\\3Atext-gray-800").click();
//         cy.wait(1500);
//         // SELECT ALL
//         cy.get(".filament-tables-checkbox-cell:nth-child(1) > .block").click();

//         // DESELECT ALL
//         // cy.get('.filament-tables-checkbox-cell:nth-child(1) > .block').click();

//         cy.wait(1500);
//         cy.get(
//             ".filament-tables-bulk-actions-trigger > .filament-icon-button-icon"
//         ).click();

//         cy.get(
//             ".filament-dropdown-list-item:nth-child(1) > .filament-dropdown-list-item-label"
//         ).click();

//         // cy.get('.filament-tables-component > form:nth-child(3)').submit();
//         cy.wait(1500);
//     });
// });
