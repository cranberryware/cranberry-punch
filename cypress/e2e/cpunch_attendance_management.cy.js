import { slowCypressDown } from "cypress-slow-down";
Cypress.on('uncaught:exception', (err, runnable) => {
  return false;
});
describe("Attendance_Management spec", () => {
    beforeEach(() => {
        slowCypressDown(200);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.adminLogin();
    });
    it("Should test the Attendance section", (employeeId = "NTE-006: Rafael Wehner", name = "Rafael Wehner") => {
        cy.log("Should test calander view & List view button-----------------");
        cy.visit("http://localhost:8000/cp-dashboard/attendances");
        cy.contains("Calendar View").click();
        cy.contains("List View").click();

        cy.log("Should test the New Attendance button-----------------");
        cy.contains("New Attendance").click();
        cy.get('div[class="cp-attendance-empId-field"]').type(employeeId);
        cy.get('div[id="choices--dataemployee_id-item-choice-1"]').click();
        cy.get('div[class="cp-attendance-user-field"]').type(name);
        cy.get('div[id="choices--datauser_id-item-choice-1"]').click();
        cy.get('input[id="data.check_in"]').click().wait(500);
        cy.contains("23").click().wait(500);
        cy.get("body").click(0, 0);
        cy.get('[x-show="! isUploadingFile"]').click();

        cy.log("Should test the attendance table and the edit attendance functionality------------");
        cy.contains("Attendances").click();
        cy.get(".filament-tables-row:nth-child(1) .filament-link:nth-child(1)").click().wait(1000);
        cy.get(".text-gray-800 > .flex > span").click().wait(500);
        cy.contains("NTE").click().wait(500);
        cy.get('div[class="cp-attendance-empId-field"]').type(employeeId);
        cy.get('div[id="choices--dataemployee_id-item-choice-1"]').click();
        cy.get('div[class="cp-attendance-user-field"]').type(name);
        cy.get('div[id="choices--datauser_id-item-choice-1"]').click();
        cy.get('input[id="data.check_in"]').click().wait(500);
        cy.contains("23").click().wait(500);
        cy.get("body").click(0, 0);
        cy.get(".col-span-1:nth-child(4) .bg-white:nth-child(4)").click();
        cy.get("body").click(0, 0);
        cy.get(".filament-form").submit();

        cy.log("Should test the add Holiday--------------------");
        cy.visit("http://localhost:8000/cp-dashboard/holidays");
        cy.contains("New holiday").click();
        cy.get('input[id="data.date"]').click().wait(500);
        cy.contains("23").click().wait(500);
        cy.get('input[id="data.holiday_name"]').type("Test Holiday");
        cy.get('select[id="data.holiday_type"]')
            .select("test holiday")
            .should("have.value", "test-holiday");
        cy.get('button[id="data.is_confirmed"]').click();
        cy.get('button[id="data.is_confirmed"]').click();
        cy.get("span:nth-child(3)").click();

        cy.log("Should test the Edit Holiday---------------------");
        cy.visit("http://localhost:8000/cp-dashboard/holidays");
        cy.contains("Test Holiday").click();
        cy.contains("Edit").click();
        cy.get('input[id="data.date"]').click().wait(500);
        cy.contains("23").click().wait(500);
        cy.get('input[id="data.holiday_name"]').clear();
        cy.get('input[id="data.holiday_name"]').type("Updated Test Holiday");
        cy.get('select[id="data.holiday_type"]')
            .select("Another test holiday")
            .should("have.value", "another-test-holiday");
        cy.get('button[id="data.is_confirmed"]').click();
        cy.get('button[id="data.is_confirmed"]').click();
        cy.contains("Save changes").click();

        cy.log("Should test the delete holiday------------------");
        cy.contains("Delete").click();
        cy.get(".filament-page-modal-button-action:nth-child(2)").click();
        cy.get(".filament-page > form:nth-child(2)").submit();
    });
});
