describe("Appraisal Forms", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/permissions/10/edit");
        cy.login();
    });
    it("Edit Permission", () => {
        cy.get('.filament-sidebar-close-overlay').click();

        cy.wait(2000);
        cy.contains("Name");
        cy.contains("Guard Name");
        cy.get('.col-span-1:nth-child(1) .text-sm').click();
        cy.get('.col-span-1:nth-child(1) .text-sm')
        .type(
            "hjh"
        );
        cy.wait(2000);
        cy.get('[dusk="filament.forms.data.guard_name"]').clear();
        cy.get('[dusk="filament.forms.data.guard_name"]').type("Web");
        cy.get('.filament-form').submit();
        cy.wait(2000);
        //role
        cy.get('[dusk="filament.tables.action.create"]').click();
        cy.wait(2000);
        cy.get('.px-4:nth-child(1) .col-span-1:nth-child(1) .text-sm:nth-child(1)')
        .type("view app");
        //create another
        cy.wait(2000);

        cy.get('.filament-tables-modal-button-action:nth-child(2) > .flex > span').click();
        cy.wait(2000);
        cy.get('.px-4:nth-child(1) .col-span-1:nth-child(1) .text-sm:nth-child(1)').type("employee14");
        cy.get(".filament-tables-component > form:nth-child(2)").submit();
        cy.wait(2000);
        //edit that role
        cy.get(
            ".filament-tables-row:nth-child(3) .filament-link:nth-child(1)"
        ).click();
        cy.wait(2000);

        cy.get('[dusk="filament.forms.mountedTableActionData.name"]').type(
            " view"
        );
        cy.wait(2000);
        cy.get(".filament-tables-component > form:nth-child(2)").submit();
        cy.wait(2000);

    });
})
