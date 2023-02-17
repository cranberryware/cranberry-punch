describe("Create Employee", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/employees");
        cy.login();
        cy.get(
            `[x-data="{ label: 'Employee Management' }"] > .text-sm > :nth-child(3) > .items-center`
        ).click();
    });

    it("Should check Create Employee form is visible or not after New Employees button clicked ", () => {


        //Fill the employee form
        cy.contains("Employee Code").should("be.visible").type("NTE-557");
        cy.get(".choices__inner")
            .eq(0)
            .should("be.visible")
            .type("Pitabas behera");
        cy.get(".choices__inner").eq(1).should("be.visible").type("CSE");
        cy.get(".choices__inner").eq(2).should("be.visible").type("developer");

        // **********************************************PERSONAL DETAILS**********************************************************
        cy.contains("First Name").should("be.visible").type("Aisurya");
        cy.contains("Last Name").should("be.visible").type("Das");
        cy.wait(1500);

        cy.wait(1500);
        cy.get(".col-span-1:nth-child(5) .bg-white:nth-child(4)").click();
        cy.get(".text-sm:nth-child(19)").click();

        cy.wait(3000);
        cy.get('[value="female"]').click();

        cy.contains("Birthday").should("be.visible").click();
        cy.get(".bg-primary-200").click();
        cy.get('[dusk="filament.forms.data.blood_group"]').select("B+");
        cy.get('[dusk="filament.forms.data.nationality"]').select("Maldives");
        cy.get('[dusk="filament.forms.data.country_of_birth"]').select(
            "Maldives"
        );

        // ************************************************FAMILY DETAILS*********************************************************
        cy.get(".h-7").eq(1).click();
        cy.contains("Marital Status").should("be.visible");
        cy.get('[dusk="filament.forms.data.marital_status"]').select(
            "Unmarried"
        );
        // ***************************************************EDUCATION DETAILS******************************************************
        cy.get(
            ".flex.items-center.justify-center.w-10.h-10.transform.rounded-full.text-primary-500"
        )
            .find(".h-7")
            .eq(2)
            .click();
        cy.contains("Field of Study").type("CSE");
        cy.contains("Highest Degree").type("MCA");


        // *****************************************************IDENTITY***********************************************************************
        cy.get(
            ".flex.items-center.justify-center.w-10.h-10.transform.rounded-full.text-primary-500"
        )
            .find(".h-7")
            .eq(3)
            .click();
        cy.contains("Passport Number").type("De567yr");
        cy.contains("UAN").type("uan");
        cy.contains("Aadhaar Number").type("234545678");
        cy.contains("PAN Number").type("4657der");
        cy.contains("Driving License Number").type("4567893456");
        cy.contains("Voter ID").type("KHTR87654");

        // *************************************************CONTACT DETAILS************************************************************************
        cy.get(
            ".flex.items-center.justify-center.w-10.h-10.transform.rounded-full.text-primary-500"
        )
            .find(".h-7")
            .eq(4)
            .click();
        cy.contains("Work Email").type("Aisurya@gmail.com");
        cy.contains("Work Phone 1").type("7789921698");
        cy.contains("Work Phone 2").type("234545678");
        cy.contains("Present Address Line 1").type("Patia");
        cy.contains("Present Address Line 2").type("Chandrasekharpur");
        cy.contains("Present Address City").type("BBSR");
        cy.get('[dusk="filament.forms.data.present_address_country"]').select(
            "Maldives"
        );
        cy.contains("Present Address State").type("Odisha");
        cy.contains("Present Address Post Code").type("754213");


        // ****************************************************************PERSONAL DETAILS*********************************************************
        cy.get(
            ".flex.items-center.justify-center.w-10.h-10.transform.rounded-full.text-primary-500"
        )
            .find(".h-7")
            .eq(5)
            .click();
        cy.contains("Personal Email").type("aisurya@gmail.com");
        cy.contains("Personal Phone").type("8658634958");
        cy.contains("Emergency Contact Name").type("234545678");
        cy.contains("Emergency Contact Relation").type("KDP");
        cy.contains("Emergency Contact Phone").type("8658634958");
        cy.contains("Permanent Address Line 1").type("BBSR");
        cy.contains("Permanent Address Line 2").type("Odisha");
        cy.contains("Permanent Address City").type("754213");
        cy.contains("Permanent Address State").type("BBSR");
        cy.get('[dusk="filament.forms.data.permanent_address_country"]').select(
            "Maldives"
        );
        cy.contains("Permanent Address Post Code").type("Odisha");


        // **********************************************************************FINANCIAL DETAILS******************************************************
        cy.get(
            ".flex.items-center.justify-center.w-10.h-10.transform.rounded-full.text-primary-500"
        )
            .find(".h-7")
            .eq(6)
            .click();
        cy.contains("Bank Account Number").type("675444534342");
        cy.contains("Bank Name").type("SBI");
        cy.contains("Bank IFSC Code").type("234545678");
        cy.contains("Bank MICR Code").type("78585");
        cy.contains("Bank SWIFT Code").type("M97907");
        cy.contains("Bank IBAN Code").type("ut876");
        cy.contains("Bank Address Line 1").type("Odisha");
        cy.contains("Bank Address Line 2").type("Odisha");
        cy.contains("Bank Address City").type("754213");
        cy.contains("Bank Address State").type("BBSR");
        cy.contains("Bank Address Post Code").type("754213");
        cy.get('[dusk="filament.forms.data.bank_address_country"]').select(
            "Maldives"
        );
        cy.contains("Bank Phone").type("75421357");
        cy.contains("Bank Email").type("aisurya@gmail.com");

        cy.get(".filament-page-actions > .text-white").click();
        cy.wait(1500);
    });
});
