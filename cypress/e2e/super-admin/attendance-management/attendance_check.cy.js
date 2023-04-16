describe("check_attendance", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/login");
        cy.login();
        cy.get(
            `[x-data="{ label: 'Attendance Management' }"] > .text-sm > :nth-child(1) > .items-center`
        ).click();
    });
    it('landing check',()=>{
        cy.get('button.filament-button');
    })
    //Calendar and List View
    it('buttons check',()=>{
        cy.get('button.filament-button').click();
        cy.wait(4000);
        cy.get('button.filament-button').click();
        cy.wait(4000);
    })

    //choose columns
    it(' choose columns employee code mode',()=>{
        cy.get('.flex-col > .filament-tables-actions-container > .filament-link').click()
        cy.get('[value="employee.employee_code"]').click()
        cy.get('[x-show="! isUploadingFile"]').click()
    })
    it(' choose columns check in employee name mode',()=>{
        cy.get('.flex-col > .filament-tables-actions-container > .filament-link').click()
        cy.get('[value="employee.full_name"]').click()
        cy.get('[x-show="! isUploadingFile"]').click()
    })
    //Search bar
    it("search functionality", () => {
        cy.get("#tableSearchInput").click();
        cy.get("#tableSearchInput").type("lora");

        cy.wait(2000);
    });

    // filters
    it("check filter condition", () => {
        cy.get(".filament-tables-filters-trigger").click();

        cy.contains("Deleted records").should("be.visible");
        cy.get('[dusk="filament.forms.tableFilters.trashed.value"]')
            .select("0")
            .should("have.value", "0")
            .wait(3000);
        cy.get('[dusk="filament.forms.tableFilters.trashed.value"]')
            .select("1")
            .should("have.value", "1")
            .wait(3000);
        cy.get('[dusk="filament.forms.tableFilters.trashed.value"]')
            .select("")
            .should("have.value", "")
            .wait(3000);
        cy.contains("Check in").should("be.visible");

        cy.get('[dusk="filament.forms.tableFilters.check_in.clause"]')
            .select("Is equal to")
            .should("have.value", "equal")
            .wait(3000);
        cy.get(
            ".col-span-1:nth-child(2) .filament-forms-fieldset-component > .grid"
        ).click();
        cy.get(".pl-3").click();
        cy.get(
            '[dusk="filament.forms.tableFilters.check_in.value.focusedYear"]'
        )
            .clear()
            .type("2023");

        cy.get(
            '[dusk="filament.forms.tableFilters.check_in.value.focusedMonth"]'
        ).select("February");
        cy.get(
            '[dusk="filament.forms.tableFilters.check_in.value.focusedDate.16"]'
        ).click();
        cy.wait(2000);
        cy.get(".space-x-2").click();

        cy.contains("Check in ip").should("be.visible");
        cy.get('[dusk="filament.forms.tableFilters.check_in_ip.clause"]')
            .select("Is not set")
            .should("have.value", "not_set")
            .wait(3000);
        cy.contains("Check out").should("be.visible");

        cy.get('[dusk="filament.forms.tableFilters.check_out.clause"]')
            .select("Is equal to")
            .should("have.value", "equal")
            .wait(3000);
        cy.get(
            ".col-span-1:nth-child(2) .filament-forms-fieldset-component > .grid"
        ).click();
        cy.get('[id="tableFilters.check_out.value"]').click();
        cy.get(
            '[dusk="filament.forms.tableFilters.check_out.value.focusedYear"]'
        )
            .clear()
            .type("2023");

        cy.get(
            '[dusk="filament.forms.tableFilters.check_out.value.focusedMonth"]'
        ).select("February");
        cy.get(
            '[dusk="filament.forms.tableFilters.check_out.value.focusedDate.17"]'
        ).click();
        cy.wait(2000);
        cy.contains("Check out ip").should("be.visible");
        cy.get('[dusk="filament.forms.tableFilters.check_out_ip.clause"]')
            .select("Is not set")
            .should("have.value", "not_set")
            .wait(3000);
        cy.get(".text-danger-600").dblclick();
        cy.get(
            ".filament-tables-filters-trigger > .filament-icon-button-icon"
        ).click();
        cy.wait(2000);
    });
//pagination
    it("pagination", () => {
        cy.get("li:nth-child(2) > .filament-tables-pagination-item").click();
        cy.wait(2000);

        cy.get(
            "div.justify-center > .flex > #tableRecordsPerPageSelect"
        ).select("50");
        cy.wait(3000);
        cy.get(
            "div.justify-center > .flex > #tableRecordsPerPageSelect"
        ).select("25");
        cy.wait(3000);
    });
});
