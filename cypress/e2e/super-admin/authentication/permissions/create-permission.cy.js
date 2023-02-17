describe("Appraisal Forms", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/permissions");
        cy.login();
    });

    it("create Permission", () => {
        cy.get(".filament-sidebar-close-overlay").click();

        cy.get('[dusk="filament.admin.action.create"]').click();
        cy.wait(2000);
        cy.get(".col-span-1:nth-child(1) .text-sm").type(
            "View Appraisal response"
        );
        cy.get('[dusk="filament.forms.data.guard_name"]').clear();
        cy.get('[dusk="filament.forms.data.guard_name"]').type("Web");

        cy.get(".filament-form").submit();
    });
    it("create Empty Permission", () => {
        cy.get(".filament-sidebar-close-overlay").click();

        cy.wait(2000);
        cy.get('[dusk="filament.admin.action.create"]').click();
        cy.wait(2000);

        cy.get('[dusk="filament.forms.data.guard_name"]').clear();
        cy.wait(1000);
        cy.get(".filament-form").submit();
        cy.wait(2000);
    });
    it("create without Permission name", () => {
        cy.get(".filament-sidebar-close-overlay").click();

        cy.wait(2000);
        cy.get('[dusk="filament.admin.action.create"]').click();
        cy.wait(2000);
        cy.get(".filament-form").submit();
    });

    it("create with Permission name", () => {
        cy.get(".filament-sidebar-close-overlay").click();

        cy.wait(2000);
        cy.get('[dusk="filament.admin.action.create"]').click();
        cy.wait(2000);
        cy.get(".col-span-1:nth-child(1) .text-sm").type(
            "View Appraisal response"
        );

        cy.get(".filament-form").submit();
    });
});
