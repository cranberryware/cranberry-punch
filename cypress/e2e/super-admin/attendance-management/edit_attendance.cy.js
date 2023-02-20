describe("create attendance check", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/attendances/13/edit");
        cy.login();
    });
    it("save edit attendance", () => {
        cy.get("a.filament-button").click();
        cy.get("#data\\.check_out").click();

        cy.get('[dusk="filament.forms.data.check_out.focusedYear"]')
            .clear()
            .type("2023");

        cy.get('[dusk="filament.forms.data.check_out.focusedMonth"]').select(
            "February"
        );
        cy.get('[dusk="filament.forms.data.check_out.focusedDate.16"]').click();
        //save
        cy.get("span:nth-child(3)").click();
        cy.get(".filament-form").submit();
    });
    it("cancel edit attendance", () => {
        cy.get("a.filament-button").click();
        cy.get("#data\\.check_out").click();

        cy.get('[dusk="filament.forms.data.check_out.focusedYear"]')
            .clear()
            .type("2023");

        cy.get('[dusk="filament.forms.data.check_out.focusedMonth"]').select(
            "February"
        );
        cy.get('[dusk="filament.forms.data.check_out.focusedDate.16"]').click();

        //For Cancel
        cy.get('[dusk="filament.admin.action.cancel"]').click();
        cy.wait(2000);
    });
    it("delete attendance", () => {
        cy.get("a.filament-button").click();
        cy.get("#data\\.check_out").click();

        cy.get('[dusk="filament.forms.data.check_out.focusedYear"]')
            .clear()
            .type("2023");

        cy.get('[dusk="filament.forms.data.check_out.focusedMonth"]').select(
            "February"
        );
        cy.get('[dusk="filament.forms.data.check_out.focusedDate.16"]').click();

        //For Cancel delete
        cy.get(".bg-danger-600").click();
        cy.get(".flex:nth-child(1) > span:nth-child(1)").click();
        cy.wait(2000);
    });
});
