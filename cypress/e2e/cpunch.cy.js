import { slowCypressDown } from "cypress-slow-down";
describe("empty spec", () => {
    beforeEach(() => {
        // slowCypressDown(500);
        cy.viewport(1440, 900);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.login();
        cy.visit("http://localhost:8000/cp-dashboard");
    });
    it("should checkin and checkout", () => {
        // slowCypressDown(500);
        cy.get(".cp-attendance-clock-btn").click();
        cy.contains("Confirm").click();
        cy.get(".cp-attendance-clock-btn").click();
        cy.contains("Confirm").click();
    });
    it("should check sidebar links", () => {
        // slowCypressDown(500);
        cy.contains("Attendance Kiosk").click();
        cy.contains("Attendances").click();
    });
    it("should check the calender view", () => {
        // slowCypressDown(500);
        cy.visit("http://localhost:8000/cp-dashboard/attendances");
        cy.contains("Calendar View").click();
        cy.contains("List View").click();
        cy.logout();
    });
});
