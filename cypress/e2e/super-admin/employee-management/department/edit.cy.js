describe('department',()=>{
    beforeEach(()=>{
        cy.viewport(1160, 720);
        cy.visit('http://127.0.0.1:8000/cp-dashboard/departments/3/edit')
        cy.wait(1000);
        cy.login();

    })

    it('edit department and save without name',()=>{
        cy.get('[dusk="filament.forms.data.name"]').clear()
        cy.get('.filament-form > .filament-page-actions > .text-white').click()

        })
    it('edit department and save without description',()=>{
        cy.get('[dusk="filament.forms.data.description"]').clear()
        cy.get('.filament-form > .filament-page-actions > .text-white').click()

        })
    it('save changes without any change',()=>{
        cy.get('.filament-form > .filament-page-actions > .text-white').click()
    })
    it('save changes with change values',()=>{
        cy.get('[dusk="filament.forms.data.name"]').type('a')
        cy.get('[dusk="filament.forms.data.description"]').type('a')
        cy.get('.filament-form > .filament-page-actions > .text-white').click()
    })
    it('cancel',()=>{
        cy.wait(2000)
        cy.get('.text-gray-800').click()
    })
    it('Delete',()=>{
        cy.get('.bg-danger-600 > .flex > span').click();
        cy.get('.bg-danger-600 span:nth-child(3)').click();
        cy.get('.filament-page > form:nth-child(2)').submit();

    })
})
