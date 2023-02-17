describe("holidays", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/login");
        cy.login();
        cy.get(
            `[x-data="{ label: 'Attendance Management' }"] > .text-sm > :nth-child(2) > .items-center`
        ).click();
    });

    it("Add new holiday", () => {
        cy.get(".filament-button").click();
        cy.get(
            `[x-data="dateTimePickerFormComponent({
            displayFormat: 'MMM D, YYYY',
            firstDayOfWeek: 1,
            isAutofocused: false,
            locale: 'en',
            shouldCloseOnDateSelection: false,
            state: $wire.entangle('data.date'),
        })"]`
        ).click();
        cy.get('[dusk="filament.forms.data.date.focusedDate.25"]').click();
        cy.get(".filament-main-content").click();
        cy.get('[id="data.holiday_name"]').type("x-mass");
        cy.contains("Holiday Type ").click();
        cy.get('[dusk="filament.forms.data.holiday_type"').select("National");
        cy.get(".focus\\3Aring-white").click();
    });
    it("Add new holiday with a blank field", () => {
        cy.get(".filament-button").click();
        cy.get(
            `[x-data="dateTimePickerFormComponent({
            displayFormat: 'MMM D, YYYY',
            firstDayOfWeek: 1,
            isAutofocused: false,
            locale: 'en',
            shouldCloseOnDateSelection: false,
            state: $wire.entangle('data.date'),
        })"]`
        ).click();
        cy.get('[dusk="filament.forms.data.date.focusedDate.25"]').click();
        cy.get(".filament-main-content").click();

        cy.contains("Holiday Type ").click();
        cy.get('[dusk="filament.forms.data.holiday_type"').select("National");
        cy.get(".focus\\3Aring-white").click();
    });
});
