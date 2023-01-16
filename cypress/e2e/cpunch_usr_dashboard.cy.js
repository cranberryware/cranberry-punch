import { slowCypressDown } from "cypress-slow-down";
Cypress.on('uncaught:exception', (err, runnable) => {
    return false;
  });
describe("User_Dashboard spec", () => {
    beforeEach(() => {
        slowCypressDown(200);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.login();
    });
    it("Should test dashboard", (email = "erin19@gmail.com", name = "Peggie Holmes", password="password") => {
        
        cy.log("Should test the Punch_In & Punch_out button----------------" );
        slowCypressDown(300);
        cy.get(".cp-attendance-clock-btn").click();
        cy.contains("Confirm").click();
        cy.get(".cp-attendance-clock-btn").click();
        cy.contains("Confirm").click();
        cy.get(".filament-tables-filters-trigger").click()
        cy.get('select[id="tableFilters.attendance_month.value"]').select("November 2022")
        cy.get(".filament-tables-filters-trigger").click()

        cy.log("Should test side bar links----------------")
        cy.contains("Attendance Kiosk").click();
        cy.contains("Attendances").click();

        cy.log("Should test attendances section-----------------");
        cy.visit("http://localhost:8000/cp-dashboard/attendances");
        cy.contains("Calendar View").click();
        cy.contains("List View").click();

        cy.log("Should test profile section------------------");
        cy.visit("http://localhost:8000/cp-dashboard/profile");
        cy.get('input[id="formData.name"]').clear();
        cy.get('input[id="formData.email"]').clear();
        cy.get('input[id="formData.name"]').should("have.value",'');
        cy.get('input[id="formData.email"]').should("have.value",'');
        cy.get('input[id="formData.name"]').type(name);
        cy.get('input[id="formData.email"]').type(email);
        cy.contains("Save changes").click();


        cy.get('input[id="formData.current_password"]').type("wrong_current_password")
        cy.get('input[id="formData.new_password"]').type("new_password")
        cy.get('input[id="formData.new_password_confirmation"]').type("diff_new_password")
        cy.contains("Save changes").click();


        cy.get('input[id="formData.current_password"]').clear()
        cy.get('input[id="formData.new_password"]').clear()
        cy.get('input[id="formData.new_password_confirmation"]').clear()

        cy.get('input[id="formData.current_password"]').type("password")
        cy.get('input[id="formData.new_password"]').type("newPassword")
        cy.get('input[id="formData.new_password_confirmation"]').type("newPassword")
        cy.contains("Save changes").click();

        cy.get('input[id="formData.email"]').clear();
        cy.get('input[id="formData.current_password"]').clear()
        cy.get('input[id="formData.new_password"]').clear()
        cy.get('input[id="formData.new_password_confirmation"]').clear()
        cy.get('input[id="formData.email"]').type("erin19@yahoo.com");
        cy.get('input[id="formData.current_password"]').type("newPassword")
        cy.get('input[id="formData.new_password"]').type("password")
        cy.get('input[id="formData.new_password_confirmation"]').type("password")
        cy.contains("Save changes").click();
        cy.logout();
    });
});
