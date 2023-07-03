describe("Attendance Setting", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/login");
        cy.login();
        cy.get(
            `[x-data="{ label: 'Cranberry Punch Settings' }"] > .text-sm > .filament-sidebar-item > .items-center`
        ).click();
    });

    it("save weekly days off color", () => {
        cy.get(".filament-forms-tabs-component-button-active > span").click();
        cy.get('[aria-controls="-weekly-days-off-tab"] > span').click();
        cy.get("div:nth-child(6) .text-primary-600").click();
        cy.get("div:nth-child(20) .text-primary-600").click();
        cy.get("span:nth-child(3)").click();
        cy.get(".filament-form").submit();
    });
});
