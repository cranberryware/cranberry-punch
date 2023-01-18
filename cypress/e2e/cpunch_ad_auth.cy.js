import { slowCypressDown } from "cypress-slow-down";

Cypress.on('uncaught:exception', (err, runnable) => {
  return false;
});
describe("Admin_User spec", () => {
    beforeEach(() => {
        slowCypressDown(200);
        cy.visit("http://localhost:8000/cp-dashboard/login");
        cy.adminLogin();
    });
    it("Should test Users section", () => {
        cy.log("Testing Users Section===================Start")
        cy.visit("http://localhost:8000/cp-dashboard/users");

        cy.log("Should test adding new user--------------")
        cy.contains("New User").click();
        cy.get('input[id="data.name"]').click();
        cy.get('input[id="data.name"]').type("Test");
        cy.get('input[id="data.email"]').click();
        cy.get('input[id="data.email"]').type("test@example.com");
        cy.get('input[id="data.password"]').click();
        cy.get('input[id="data.password"]').type("password");
        cy.get('input[id="data.passwordConfirmation"]').click();
        cy.get('input[id="data.passwordConfirmation"]').type("password");
        cy.get('input[name="search_terms"]').click();
        cy.get('div[id="choices--dataroles-item-choice-1"]').click();
        cy.get("body").click(0, 0);
        cy.get(".filament-form").submit();

        cy.log("Should test user edit------------------");
        cy.visit("http://localhost:8000/cp-dashboard/users");
        cy.get('input[id="tableSearchInput"]').click();
        cy.get('input[id="tableSearchInput"]').type("test").wait(1000);
        cy.contains("Edit").click();
        cy.get('input[id="data.name"]').click();
        cy.get('input[id="data.name"]').clear();
        cy.get('input[id="data.name"]').type("Testing");
        cy.get('input[id="data.email"]').click();
        cy.get('input[id="data.email"]').clear();
        cy.get('input[id="data.email"]').type("testing@example.com");
        cy.get('input[id="data.password"]').click();
        cy.get('input[id="data.password"]').type("password1");
        cy.get('input[id="data.passwordConfirmation"]').click();
        cy.get('input[id="data.passwordConfirmation"]').type("password1");
        cy.get(".choices__input--cloned").click();
        cy.get('input[name="search_terms"]').click();
        cy.get('button[class="choices__button"]').eq(0).click();
        cy.get('div[id="choices--dataroles-item-choice-2"]').click();
        cy.get("body").click(0, 0);
        cy.get(".filament-form").submit().wait(1000);

        cy.log("Should test delete functionality--------")
        cy.get(".bg-danger-600 > .flex > span").click();
        cy.get(".bg-danger-600 span:nth-child(3)").click();
        cy.get(".filament-page > form:nth-child(2)").submit();
        cy.url().should("contains", "http://localhost:8000/cp-dashboard/users");

        cy.log("Should test adding new user--------------")
        cy.contains("New User").click();
        cy.get('input[id="data.name"]').click();
        cy.get('input[id="data.name"]').type("Test");
        cy.get('input[id="data.email"]').click();
        cy.get('input[id="data.email"]').type("test@example.com");
        cy.get('input[id="data.password"]').click();
        cy.get('input[id="data.password"]').type("password");
        cy.get('input[id="data.passwordConfirmation"]').click();
        cy.get('input[id="data.passwordConfirmation"]').type("password");
        cy.get('input[name="search_terms"]').click();
        cy.get('div[id="choices--dataroles-item-choice-1"]').click();
        cy.get("body").click(0, 0);
        cy.get(".filament-form").submit();
        cy.contains("Users").click();
        cy.log("Testing Users Section===============End")


        cy.log('Testing the Roles section===============Start')
        cy.log('Should test add new role---------------')
        cy.visit('http://localhost:8000/cp-dashboard/roles');
        cy.contains('New Role').click();
        cy.get('input[id="data.name"]').click();
        cy.get('input[id="data.name"]').type('Test Role');
        cy.get('.filament-form').submit();

        cy.log('Should test attach permission----------')
        cy.contains('Attach').click().wait(500)
        cy.contains('Select an option').click();
        cy.get('input[name="search_terms"]').type('test').wait(500)
        cy.get('div[id="choices--mountedTableActionDatarecordId-item-choice-1"]').click()
        cy.get('.filament-tables-component > form:nth-child(2)').submit();


        cy.log('Should test add new permissions---------')
        cy.contains('New permission').click();
        cy.get('input[id="mountedTableActionData.name"]').click();
        cy.get('input[id="mountedTableActionData.name"]').type('New Test').wait(300);
        cy.get('.filament-tables-component > form:nth-child(2)').submit();

        cy.log('Should test detach permission----------')
        cy.get('.filament-tables-row:nth-child(1) .filament-link:nth-child(2)').click();
        cy.get('.flex > span:nth-child(3)').click();
        cy.get('.filament-tables-component > form:nth-child(2)').submit();

        cy.log('Sholud delete permission----------')
        cy.get('.filament-link:nth-child(3)').click();
        cy.get('.flex > span:nth-child(3)').click();
        cy.get('.filament-tables-component > form:nth-child(2)').submit().wait(2000);


        cy.log('Should test delete role-----------')
        cy.contains('Edit').click()
        cy.get('.bg-danger-600 > .flex > span').click();
        cy.get('.bg-danger-600 span:nth-child(3)').click();
        cy.get('.filament-page > form:nth-child(2)').submit();

        cy.log('Testing the Roles section===============End')

        cy.log('Testing the Permissions section===============Start')

        cy.visit('http://localhost:8000/cp-dashboard/permissions');
        cy.contains('New Permission').click();
        cy.get('input[id="data.name"]').click();
        cy.get('input[id="data.name"]').type('Test Permission');
        cy.get('.filament-form').submit();
        
        cy.log('Should test attach role----------')
        cy.contains('Attach').click().wait(500)
        cy.contains('Select an option').click();
        cy.get('input[name="search_terms"]').type('test-role').wait(500)
        cy.get('div[id="choices--mountedTableActionDatarecordId-item-choice-1"]').click()
        cy.get('.filament-tables-component > form:nth-child(2)').submit();


        cy.log('Should test add new role---------')
        cy.contains('New role').click();
        cy.get('input[id="mountedTableActionData.name"]').click();
        cy.get('input[id="mountedTableActionData.name"]').type('New Test Role').wait(300);
        cy.get('.filament-tables-component > form:nth-child(2)').submit();

        cy.log('Should test detach role----------')
        cy.get('.filament-tables-row:nth-child(1) .filament-link:nth-child(2)').click();
        cy.get('.flex > span:nth-child(3)').click();
        cy.get('.filament-tables-component > form:nth-child(2)').submit();

        cy.log('Sholud delete role----------')
        cy.get('.filament-link:nth-child(3)').click();
        cy.get('.flex > span:nth-child(3)').click();
        cy.get('.filament-tables-component > form:nth-child(2)').submit().wait(2000);


        cy.log('Should test delete permission-----------')
        cy.contains('Edit').click()
        cy.get('.bg-danger-600 > .flex > span').click();
        cy.get('.bg-danger-600 span:nth-child(3)').click();
        cy.get('.filament-page > form:nth-child(2)').submit();





        cy.log('Testing the Permissions section===============End')

    });
});
