describe("delete Employee", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/employees/9/edit");
        cy.login();
    });

    it("delete an employee ", () => {
        cy.get(".bg-danger-600").click();
        //cancel
        cy.get(".filament-page-modal-button-action:nth-child(1)").click();
        cy.wait(1000);
        //delete
        cy.get(".bg-danger-600").click();
        cy.get(".bg-danger-600 span:nth-child(3)").click();
        cy.get(".filament-page > form:nth-child(2)").submit();
    });
});
