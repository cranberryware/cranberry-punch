describe('Attendance Setting',()=>{
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit('http://127.0.0.1:8000/cp-dashboard/login');
        cy.login();
        cy.get(`[x-data="{ label: 'Cranberry Punch Settings' }"] > .text-sm > .filament-sidebar-item > .items-center`).click()
    })

    it('save with a empty ip field',()=>{
        cy.contains('Add to iP Locations Map').click()
        cy.get('.filament-page-actions > .filament-button').click()
    })
    it('Delete ',()=>{
        cy.contains('Add to iP Locations Map').click()
        cy.get('#-location-tab .bg-white:nth-child(2) .flex:nth-child(4) path:nth-child(1)').click();

    })


})
