import { slowCypressDown } from "cypress-slow-down";
describe("Dashboard spec", () => {
    beforeEach(() => {
        slowCypressDown(200);
        cy.viewport(1440, 900);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.login();
        cy.visit("http://localhost:8000/cp-dashboard");
    });
    it("should checkin and checkout", () => {
        slowCypressDown(200);
        cy.get(".cp-attendance-clock-btn").click();
        cy.contains("Confirm").click();
        cy.get(".cp-attendance-clock-btn").click();
        cy.contains("Confirm").click();
    });
    it("should check sidebar links", () => {
        slowCypressDown(200);
        cy.contains("Attendance Kiosk").click();
        cy.contains("Attendances").click();
    });
    it("should check the calender view", () => {
        slowCypressDown(200);
        cy.visit("http://localhost:8000/cp-dashboard/attendances");
        cy.contains("Calendar View").click();
        cy.contains("List View").click();
    });
});
