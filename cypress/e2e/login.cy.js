describe("Login spec", () => {
    it("should check correct login credentials", (email = "erin19@yahoo.com", password = "password") => {
        cy.viewport(1440, 900);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.get('input[type="email"]').type(email);
        cy.get('input[type="password"]').type(password);
        cy.get('input[type="checkbox"]').check();
        cy.get('button[type="submit"]').click();
    });
    it("should check incorrect login credentials", (email = "erin19@yahooooo.com", password = "passworddd") => {
        cy.viewport(1440, 900);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.contains("These credentials do not match our records.").should(
            "not.exist"
        );
        cy.get('input[type="email"]').type(email);
        cy.get('input[type="password"]').type(password);
        cy.get('input[type="checkbox"]').check();
        cy.get('button[type="submit"]').click();
        cy.contains("These credentials do not match our records.").should(
            "not.exist"
        );
    });
});
