describe("create attendance check", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/login");
        cy.login();
        cy.get(
            `[x-data="{ label: 'Attendance Management' }"] > .text-sm > :nth-child(1) > .items-center`
        ).click();
    });
    it("check landing", () => {
        cy.get("a.filament-button").click();
        cy.get(":nth-child(1) > .grid-cols-1 > :nth-child(1)").type("lora");
        cy.get('[data-value="1"]').click();
        cy.get(":nth-child(1) > .grid-cols-1 > :nth-child(2)").type("dil");
        cy.get('[data-value="20"]').click();

        cy.get('[id="data.check_in"]').click();
        cy.get('[dusk="filament.forms.data.check_in.focusedYear"]')
            .clear()
            .type("2023");

        cy.get('[dusk="filament.forms.data.check_in.focusedMonth"]').select(
            "February"
        );
        cy.get('[dusk="filament.forms.data.check_in.focusedDate.16"]').click();
        cy.get('[id="data.check_out"]').click();
        cy.get('[dusk="filament.forms.data.check_out.focusedYear"]')
            .clear()
            .type("2023");

        cy.get('[dusk="filament.forms.data.check_out.focusedMonth"]').select(
            "February"
        );
        cy.get('[dusk="filament.forms.data.check_out.focusedDate.16"]').click();
        cy.get("span:nth-child(3)").click();
        cy.get(".filament-form").submit();

        cy.wait(2000);
        cy.get(":nth-child(1) > .grid-cols-1 > :nth-child(2)").type("ard");
        cy.get('[data-value="34"]').click();

        cy.get("span:nth-child(3)").click();
        cy.get(".filament-form").submit();
        cy.wait(4000);
        //For Cancel delete
        cy.get(".bg-danger-600").click();
        cy.get(".flex:nth-child(1) > span:nth-child(1)").click();
        cy.wait(2000);


    });
});
