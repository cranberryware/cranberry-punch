Cypress.on('uncaught:exception', (err, runnable) => {
    return false;
  });
describe("Login spec", () => {
    it("should check incorrect login credentials", (email = "erin19@yahooooo.com", password = "passworddd") => {
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.contains("These credentials do not match our records.").should(
            "not.exist"
        );
        cy.get('input[type="email"]').should('have.value', '');
        cy.get('input[type="email"]').type(email);
        cy.get('input[type="password"]').should('have.value', '');
        cy.get('input[type="password"]').type(password);
        cy.get('input[type="checkbox"]').check();
        cy.get('button[type="submit"]').click();
        cy.contains("These credentials do not match our records.").should(
            "not.exist"
        );
    });
    it("should check correct login credentials", (email = "erin19@yahoo.com", password = "password") => {
        ;
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.get('input[type="email"]').type(email);
        cy.get('input[type="password"]').type(password);
        cy.get('input[type="checkbox"]').check();
        cy.get('button[type="submit"]').click();
    });
    it("should check incorrect admin login credentials", (email = "admin@example.com", password = "passworddd") => {
        
        cy.logout();
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.contains("These credentials do not match our records.").should(
            "not.exist"
        );
        cy.get('input[type="email"]').should('have.value', '');
        cy.get('input[type="email"]').type(email);
        cy.get('input[type="password"]').should('have.value', '');
        cy.get('input[type="password"]').type(password);
        cy.get('input[type="checkbox"]').check();
        cy.get('button[type="submit"]').click();
        cy.contains("These credentials do not match our records.").should(
            "not.exist"
        );
    });
    it("should check correct admin login credentials", (email = "admin@example.com", password = "password") => {
        
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.get('input[type="email"]').type(email);
        cy.get('input[type="password"]').type(password);
        cy.get('input[type="checkbox"]').check();
        cy.get('button[type="submit"]').click();
    });
    
});