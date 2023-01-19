import { slowCypressDown } from "cypress-slow-down";
Cypress.on('uncaught:exception', (err, runnable) => {
  return false;
});
describe("Admin_Department spec", () => {
    beforeEach(() => {
        slowCypressDown(500);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.adminLogin();
    });
    it("Should test the Employee Management section", () => {
      // cy.log("Testing Department section===============Start")
      
      // cy.log("Should test add new department---------------" )
      // cy.visit('http://localhost:8000/cp-dashboard/departments');
      // cy.contains('New Department').click();
      // cy.get('input[id="data.name"]').click();
      // cy.get('input[id="data.name"]').type('Test Dept');
      // cy.get('textarea[id="data.description"]').click();
      // cy.get('textarea[id="data.description"]').type('This dept. is fro testing');
      // cy.get('select[id="data.parent_id"]').select('Technology').should('have.value', '9')
      // cy.get('.filament-form').submit();

      // cy.log("Should test Edit Department--------------")
      // cy.visit('http://localhost:8000/cp-dashboard/departments');
      // cy.contains('Test Dept').click();
      // cy.get('textarea[id="data.description"]').click();
      // cy.get('textarea[id="data.description"]').clear();
      // cy.get('textarea[id="data.description"]').type('This dept. is for testing and development');
      // cy.get('select[id="data.parent_id"]').select('IT and Infrastructure').should('have.value', '6')
      // cy.get('.filament-form').submit();
      // cy.url().should('contains', 'http://localhost:8000/cp-dashboard/departments');
      

      // cy.log("Should test delete department-----------")
      // cy.contains('Test Dept').click().wait(500);
      // cy.contains('Delete').click().wait(1000);
      // cy.get('.filament-page > form:nth-child(2)').submit().wait(500);
      // cy.log("Testing Department section===============End")

      // cy.log("Testing the Designations section=============Start")
      
      // cy.log("Should test add new designation--------------")
      // cy.visit('http://localhost:8000/cp-dashboard/designations');
      // cy.contains('New Designations').click();
      // cy.get('input[id="data.name"]').click();
      // cy.get('input[id="data.name"]').type('Test Designation');
      // cy.get('select[id="data.department_id"]').select("Administration").should("have.value", "1");
      // cy.get("body").click(0, 0);
      // cy.get('.filament-form').submit();
      // cy.get('li:nth-child(9) span').click();
      
      // cy.log("Should test Edit designation--------------")
      // cy.contains('Test Designation').click();
      // cy.get('input[id="data.name"]').click();
      // cy.get('input[id="data.name"]').clear();
      // cy.get('input[id="data.name"]').type('Testing Designation');
      // cy.get('select[id="data.department_id"]').select("Technology").should("have.value", "9");
      // cy.get('span:nth-child(3)').click();
      // cy.get('li:nth-child(9) span').click();

      // cy.log("Should test Delete designation---------------")
      // cy.contains('Testing Designation').click();
      // cy.get('.bg-danger-600 > .flex > span').click();
      // cy.get('.bg-danger-600 span:nth-child(3)').click();
      // cy.get('.filament-page > form:nth-child(2)').submit();
      // cy.log("Testing the Designation section================End")

      cy.log('Testing the Employees section================Start')

      cy.log('Should test add new employee-------------')
      cy.visit('http://localhost:8000/cp-dashboard/employees')
      cy.contains('New Employee').click();
      cy.get('input[id="data.employee_code"]').click();
      cy.get('input[id="data.employee_code"]').type('NTE-464');
      cy.get('input[id="data.first_name"]').click();
      cy.get('input[id="data.first_name"]').type('Test');
      cy.get('input[id="data.middle_name"]').click();
      cy.get('input[id="data.middle_name"]').type('test');
      cy.get('input[id="data.last_name"]').click();
      cy.get('input[id="data.last_name"]').type('Test');
      cy.get('input[id="data.gender-male"]').click();
      cy.get('input[id="data.date_of_birth"]').click();
      cy.contains('19').click();

      cy.get('.col-span-1:nth-child(5) .w-20').type('1991');
      cy.get('.col-span-1:nth-child(5) .w-20').click();
      cy.get('#data\.birthday').click();
      cy.get('.col-span-1:nth-child(6) .w-20').type('2000');
      cy.get('.col-span-1:nth-child(6) .w-20').click();
      cy.get('.col-span-1:nth-child(6) .w-20').type('1999');
      cy.get('.col-span-1:nth-child(6) .w-20').click();
      cy.get('.col-span-1:nth-child(6) .w-20').type('1998');
      cy.get('.col-span-1:nth-child(6) .w-20').click();
      cy.get('.col-span-1:nth-child(6) .w-20').dblclick();
      cy.get('.col-span-1:nth-child(6) .w-20').type('1990');
      cy.get('.col-span-1:nth-child(6) .w-20').click();
      cy.get('.col-span-1:nth-child(6) .w-20').dblclick();
      cy.get('.col-span-1:nth-child(6) .text-sm:nth-child(7)').click();
      cy.get('#data\.personal .col-span-1:nth-child(9) .flex:nth-child(1)').click();
      cy.get('#data\.blood_group').click();
      cy.get('#data\.blood_group').type('0');
      cy.get('#data\.nationality').click();
      cy.get('#data\.nationality').type('IN');
      cy.get('#data\.country_of_birth').click();
      cy.get('#data\.country_of_birth').type('IN');
      cy.get('#data\.family .filament-forms-section-header').click();
      cy.get('#data\.marital_status').click();
      cy.get('#data\.marital_status').type('unmarried');
      cy.get('span:nth-child(3)').click();
      cy.get('.filament-form').submit();
      cy.url().should('contains', 'http://localhost:8000/cp-dashboard/employees');





      cy.log('Testing the Employees section================End')
    });
});
