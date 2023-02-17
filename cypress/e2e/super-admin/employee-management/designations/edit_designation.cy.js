describe("designations", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit('http://127.0.0.1:8000/cp-dashboard/designations/8/edit')
        cy.wait(1000);
        cy.login();
    });
    it('edit designation and save without name',()=>{
        cy.get('[dusk="filament.forms.data.name"]').clear();
        cy.contains("Department").should("be.visible");
        cy.wait(1000);
        cy.get('[dusk="filament.forms.data.department_id"]')
            .select("IT and Infrastructure")
            .wait(3000);
        cy.get("span:nth-child(3)").click();

        })

    it('save changes without any change',()=>{
        cy.get('.filament-form > .filament-page-actions > .text-white').click()
    })
    it('save changes with change values',()=>{
        cy.get('[dusk="filament.forms.data.name"]').clear().type('Hr');
        cy.contains("Department").should("be.visible");
        cy.wait(1000);
        cy.get('[dusk="filament.forms.data.department_id"]')
            .select("Human Resources")
            .wait(3000);
        cy.get("span:nth-child(3)").click();

    })
    it('cancel',()=>{
        cy.wait(2000);
        cy.get('.text-gray-800').click()
    })
    it('Delete',()=>{
        cy.get('.bg-danger-600 > .flex > span').click();
        cy.get('.bg-danger-600 span:nth-child(3)').click();
        cy.get('.filament-page > form:nth-child(2)').submit();

    })




});
