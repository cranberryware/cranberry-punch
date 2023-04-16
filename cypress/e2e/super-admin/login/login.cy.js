describe("login test suit", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/cp-dashboard/login");
    });

    it("login test without any data", () => {
        cy.get(".bg-primary-600").click();
        cy.go("forward");
        cy.get("#email");
    });
    it("login with google click check", () => {
        cy.get(".flex-col:nth-child(2)").click();
        cy.wait(2000);
    });
    it("login with correct credential positive test case", () => {
        cy.get("#email").type("admin@example.com");
        cy.get("#password").type("password");
        cy.get(".bg-primary-600").click();
        cy.wait(2000);
    });
    it("login only with wrong credentials", () => {
        cy.get("#email").type("aisurya.das@nettantra.net");
        cy.get("#password").type("pp");
        cy.get(".bg-primary-600").click();
        cy.go("forward");
        cy.get(".filament-forms-field-wrapper-error-message").should(
            "have.css",
            "color",
            "rgb(220, 38, 38)"
        );
        cy.wait(1000);
    });
    it("login error msg", () => {
        cy.get("#email").type("aisurya.dash@nettantra.net");
        cy.get("#password").type("passwords");
        cy.get(".bg-primary-600").click();

    });
    it("login error msg", () => {
        cy.get("#email").type("aisurya.dash@nettantra.net");
        cy.get("#password").type("passwords");
        cy.get(".bg-primary-600").click();

    });
    it("login error msg color check", () => {
        cy.get("#email").type("aisurya.dash@nettantra.net");
        cy.get("#password").type("passwords");
        cy.get(".bg-primary-600").click();
        cy.go("forward");
        cy.get(".filament-forms-field-wrapper-error-message").should(
            "have.css",
            "color",
            "rgb(220, 38, 38)"
        );
    });
    it("login with correct credential negetive test case(after too many wrong attempts)", () => {
        cy.get("#email").type("admin@example.com");
        cy.get("#password").type("password");
        cy.get(".bg-primary-600").click();
        cy.go("forward");
        cy.get(".filament-forms-field-wrapper-error-message");
    });

});
