describe('department',()=>{
    beforeEach(()=>{
        cy.viewport(1160, 720);
        cy.visit('http://127.0.0.1:8000/cp-dashboard/login');
        cy.login();
        cy.get(`[x-data="{ label: 'Employee Management' }"] > .text-sm > :nth-child(1) > .items-center`).click()
    })
    it('page data check ',()=>{
        cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/departments')
        cy.get('.filament-tables-row:nth-child(1) .filament-link:nth-child(1)').click();
        cy.contains('Administration');
        cy.contains('Administration department');
        cy.contains('Parent department');

    })

    it('close button check ',()=>{
        cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/departments')
        cy.get('.filament-tables-row:nth-child(1) .filament-link:nth-child(1)').click();
        cy.wait(2000);
        cy.get('.filament-button > .flex > span').click();

    })
})
