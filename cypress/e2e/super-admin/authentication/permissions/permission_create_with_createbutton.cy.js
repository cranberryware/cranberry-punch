

describe('permission test suit',()=>{
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit('http://127.0.0.1:8000/oa-dashboard/login');
        cy.login();
        cy.get(`[x-data="{ label: 'Authentication' }"] > .text-sm > :nth-child(3) > .items-center`).click()
    })
    // it('landing check',()=>{
    //     cy.log("hello")
    // })

    it('hit create button without enter any data',()=>{
        cy.get('.filament-button').click()
        cy.get('[dusk="filament.forms.data.name"]').clear()
        cy.get('[dusk="filament.forms.data.guard_name"]').clear()
        cy.get('.filament-page-actions > .text-white').click()
    })


    // it('hit create button without enter gaurd',()=>{
    //     cy.get('.filament-button').click()
    //     cy.get('[dusk="filament.forms.data.name"]').type('save')
    //     cy.get('[dusk="filament.forms.data.guard_name"]').clear()
    //     cy.get('.filament-page-actions > .text-white').click()
    // })
    
    // it('Hit create button without enter name',()=>{
    //     cy.get('.filament-button').click()
    //     cy.get('.filament-page-actions > .text-white').click()
    // })
    
    
    
    // it('create new permission',()=>{
    //     cy.get('.filament-button').click()
    //     cy.get('[dusk="filament.forms.data.name"]').type('save')
    //     cy.get('.filament-page-actions > .text-white').click()
    // })
    
})