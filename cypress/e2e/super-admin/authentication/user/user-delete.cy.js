// describe("delete user", () => {
//     beforeEach(() => {
//         cy.visit("http://127.0.0.1:8000/oa-dashboard/users");
//         cy.login();
//         cy.wait(2000);
//     });

//     it("delete user", () => {
//         cy.get('.filament-tables-row:nth-child(1) > .filament-tables-checkbox-cell > .block').click();
//         cy.get('.filament-tables-bulk-actions-trigger > .filament-icon-button-icon').click();
//         // cy.get('.hover\3A bg-danger-500 > .filament-dropdown-list-item-label').click();
//         // cy.get('.flex > span:nth-child(3)').click();
//         // cy.get('.filament-tables-component > form:nth-child(3)').submit();

// cy.wait(1500);
// cy.get('.hover\\:bg-danger-500').click();
// cy.get('.filament-tables-component > form:nth-child(3)').submit();
//         cy.wait(1500);

//     });
// });

// ******************************SECOND WAY OF DELETE *********************************************

// describe("delete user", () => {
//     beforeEach(() => {
//         cy.visit("http://127.0.0.1:8000/oa-dashboard/users");
//         cy.login();
//     });

//     it("delete user", () => {
//         cy.contains("Edit")
//         .should("have.css", "background-color", "rgba(0, 0, 0, 0)")
//         .click();

//         cy.get('[dusk="filament.admin.action.delete"]').click();

//         cy.get('.bg-danger-600 > .flex > span').click();
//         cy.get('.bg-danger-600 span:nth-child(3)').click();
//         cy.wait(1500);
//         cy.get('.filament-page > form:nth-child(2)').submit();
//         cy.wait(2000);

//     })
// });

// ********************************************SELECT ALL AND DESELECT ALL*****************************************************************************

describe("delete user", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/oa-dashboard/users");
        cy.login();
    });

    it("delete user ", () => {
        // SELECT ALL
        cy.get(".filament-tables-checkbox-cell:nth-child(1) > .block").click();
        cy.wait(2000);
        // DESELECT ALL
        // cy.get(".filament-tables-checkbox-cell:nth-child(1) > .block").click();
        cy.wait(2000);
        cy.get('.filament-tables-bulk-actions-trigger > .filament-icon-button-icon').click();
        cy.get('.hover\\3A bg-danger-500 > .filament-dropdown-list-item-label').click();
        cy.get('.text-gray-800').click();
        cy.wait(1500);
    });
});
