describe("Attendance Setting", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/login");
        cy.login();
        cy.get(
            `[x-data="{ label: 'Cranberry Punch Settings' }"] > .text-sm > .filament-sidebar-item > .items-center`
        ).click();
    });

    it("holiday days type ", () => {
        cy.get('[aria-controls="-holiday-types-tab"] > span').click();
        cy.get("#-holiday-types-tab .filament-button > .flex > span").click();

        cy.get(
            "#-holiday-types-tab .bg-white:nth-child(4) .flex:nth-child(4) .w-4:nth-child(2)"
        ).click();
        cy.get("span:nth-child(3)").click();
        cy.get(".filament-form").submit();
    });
});
