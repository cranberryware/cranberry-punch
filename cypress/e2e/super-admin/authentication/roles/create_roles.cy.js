describe('roles suit', () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit('http://127.0.0.1:8000/cp-dashboard/login');
        cy.login();
        cy.get(`[x-data="{ label: 'Authentication' }"] > .text-sm > :nth-child(2) > .items-center > .flex`).click()
        cy.get('.filament-button').click()
    })

    it('create new role without role name',()=>{
        cy.get('.filament-page-actions > .text-white').click()
    })
    it('create new role without any data -vecase', () => {
        cy.get('[dusk="filament.forms.data.guard_name"]').clear()
        cy.get('.filament-page-actions > .text-white').click()
    })
    it('create with entering only rolename',()=>{
        cy.get('[dusk="filament.forms.data.name"]').type("devloper")
        cy.get('[dusk="filament.forms.data.guard_name"]').clear()
        cy.get('.filament-page-actions > .text-white').click()
    })
    it('create new role with the role exists before',()=>{
        cy.get('[dusk="filament.forms.data.name"]').type("hr-manager")
        cy.get('.filament-page-actions > .text-white').click()
    })
    it('create successfull role',()=>{
        cy.get('[dusk="filament.forms.data.name"]').type("writer")
        cy.get('.filament-page-actions > .text-white').click()
    })
})
