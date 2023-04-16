describe("View Employees", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/employees/5");
        cy.login();

    });

    it("should visible view-employees form", () => {

        cy.get(".filament-page > .space-y-6").should("be.visible");
        cy.get(".h-7").eq(1).click();
        cy.contains("Marital Status").should("be.visible");
        cy.wait(3000);
        cy.get(".h-7").eq(2).click();
        cy.contains("Field of Study").should("be.visible");
        cy.contains("Highest Degree").should("be.visible");
        cy.wait(3000);
        cy.get(".h-7").eq(3).click();
        cy.contains("Passport Number").should("be.visible");
        cy.contains("UAN").should("be.visible");
        cy.contains("Aadhaar Number").should("be.visible");
        cy.contains("PAN Number").should("be.visible");
        cy.contains("Driving License Numbe").should("be.visible");
        cy.contains("Voter ID").should("be.visible");
        cy.wait(3000);
        cy.get(".h-7").eq(4).click();
        cy.wait(3000);
        cy.get(".h-7").eq(5).click();
        cy.wait(3000);
        cy.get(".h-7").eq(6).click();
        cy.wait(3000);
    });
});
