describe('check dashboard', () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard");
        cy.login();
    }),
    // complete
    it('sidebar dashboard collapse',()=>{
        cy.get('.filament-sidebar-collapse-button').click();
        cy.get(`[x-data="{ label: '' }"] > .text-sm > .filament-sidebar-item > .items-center`).click();
        cy.wait(1000);
        cy.get('.filament-sidebar-close-button').click();
        cy.wait(1000);
    })

    // complete
    it('sidebar attendance buttons check',()=>{
        cy.get(`[x-data="{ label: 'Attendance Management' }"] > .text-sm > :nth-child(1)`).click()
        cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/attendances?tableFilters[check_in][period]=days&tableFilters[check_out][period]=days&tableSortColumn=check_in&tableSortDirection=desc');
       cy.get(1000);
        cy.get(`[x-data="{ label: 'Attendance Management' }"] > .text-sm > :nth-child(2) > .items-center`).click();
        cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/holidays');
       cy.get(1000);
       cy.get(`[x-data="{ label: 'Employee Management' }"] > .text-sm > :nth-child(1) > .items-center`).click();
       cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/departments');
       cy.get(1000);
       cy.get(`[x-data="{ label: 'Employee Management' }"] > .text-sm > :nth-child(2) > .items-center`).click();
        cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/designations');
       cy.get(1000);
       cy.get(`[x-data="{ label: 'Employee Management' }"] > .text-sm > :nth-child(3) > .items-center`).click();
       cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/employees');
       cy.get(1500);
       cy.get(`[x-data="{ label: 'Authentication' }"] > .text-sm > :nth-child(1) > .items-center`).click();
        cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/users');
       cy.get(1000);
       cy.get(`[x-data="{ label: 'Authentication' }"] > .text-sm > :nth-child(2) > .items-center`).click();
       cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/roles');
       cy.get(1000);
       cy.get(`[x-data="{ label: 'Authentication' }"] > .text-sm > :nth-child(3) > .items-center`).click();
        cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/permissions');
       cy.get(1000);
       cy.get(`[x-data="{ label: 'Cranberry Punch Settings' }"] > .text-sm > :nth-child(1) > .items-center`).click();
        cy.url().should('eq','http://127.0.0.1:8000/cp-dashboard/manage-attendance-settings');
       cy.get(1000);


    })


})
