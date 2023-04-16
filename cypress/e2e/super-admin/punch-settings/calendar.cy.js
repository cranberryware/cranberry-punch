describe("Attendance Setting", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/login");
        cy.login();
        cy.get(
            `[x-data="{ label: 'Cranberry Punch Settings' }"] > .text-sm > .filament-sidebar-item > .items-center`
        ).click();
    });

    it("calendar", () => {
        cy.get('[aria-controls="-calendar-cell-colors-tab"] > span').click();
        cy.get("#-calendar-cell-colors-tab").click();
        cy.get(
            "#-calendar-cell-colors-tab .filament-button > .flex > span"
        ).click();
        cy.get(
            "#-calendar-cell-colors-tab .filament-forms-repeater-component > .relative"
        ).click();
        cy.get(".bg-white:nth-child(6) li .w-4").click();


    });
    it("calendar add color with no values ", () => {
        cy.get('[aria-controls="-calendar-cell-colors-tab"] > span').click();
        cy.get("#-calendar-cell-colors-tab").click();
        cy.get(
            "#-calendar-cell-colors-tab .filament-button > .flex > span"
        ).click();
        cy.get("span:nth-child(3)").click();
        cy.get(".filament-form").submit();
    });

});
