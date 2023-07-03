describe("designations", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/designations");
        cy.login();
        cy.get(
            `[x-data="{ label: 'Employee Management' }"] > .text-sm > :nth-child(2) > .items-center`
        ).click();
    });
    it("create with designation name only", () => {
        cy.get(".filament-button").click();
        cy.get('[dusk="filament.forms.data.name"]').type("Developer");
        cy.get("span:nth-child(3)").click();

    });

    it("create  without designation name ", () => {
        cy.get(".filament-button").click();
        cy.wait(1000);
        cy.contains("Department").should("be.visible");
        cy.wait(1000);
        cy.get('[dusk="filament.forms.data.department_id"]')
            .select("IT and Infrastructure")
            .wait(3000);
        cy.get("span:nth-child(3)").click();
    });
    it("create designation with all data", () => {
        cy.get(".filament-button").click();
        cy.get('[dusk="filament.forms.data.name"]').type("Developer");

        cy.contains("Department").should("be.visible");
        cy.get('[dusk="filament.forms.data.department_id"]')
            .select("IT and Infrastructure")
            .wait(3000);

        cy.get(".filament-page-actions > .text-white").click();
        cy.get("span:nth-child(3)").click();
    });
});
