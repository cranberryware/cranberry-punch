

describe("edit Employee", () => {
    beforeEach(() => {
        cy.viewport(1160, 720);
        cy.visit("http://127.0.0.1:8000/cp-dashboard/employees/7/edit");
        cy.login();
    });


    it("edit Employee", () => {
        cy.get(".flex > .text-primary-600").eq(0).should("be.visible").click();


        cy.get('[placeholder="Employee Code"]').clear().type("333");

        cy.get('[placeholder="First Name"]').clear().type("Saumya");
        cy.get('[placeholder="Middle Name"]').clear().type("rani");
        cy.get('[placeholder="Last Name"]').clear().type("Panigrahi");
        cy.get('[value="female"]').click();
        cy.get(
            ":nth-child(5) > .filament-forms-field-wrapper > .space-y-2 > .filament-forms-date-time-picker-component > .relative"
        ).eq(0).click();
        cy.get(
            ':nth-child(5) > .filament-forms-field-wrapper > .space-y-2 > .filament-forms-date-time-picker-component > .hidden > .space-y-3 > [role="grid"]'
        );

        cy.get(
            ":nth-child(6) > .filament-forms-field-wrapper > .space-y-2 > .filament-forms-date-time-picker-component > .relative"
        ).click();
        cy.get('[dusk="filament.forms.data.blood_group"]').select("B+");
        cy.get('[dusk="filament.forms.data.nationality"]').select("Maldives");
        cy.get('[dusk="filament.forms.data.country_of_birth"]').select(
            "Maldives"
        );
        cy.get(".h-7").eq(1).click();
        cy.contains("Marital Status").should("be.visible");
        cy.get('[dusk="filament.forms.data.marital_status"]').select(
            "Unmarried"
        );
        cy.get(".h-7").eq(2).click();
        cy.contains("Field of Study").should("be.visible");
        cy.contains("Highest Degree").should("be.visible");
        cy.get('[placeholder="Field of Study"]')
            .clear()
            .type("Computer Science");
            cy.get('[placeholder="Highest Degree"]')
            .clear()
            .type("B-tech");

        cy.get(".h-7").eq(3).click();
        cy.contains("Passport Number").should("be.visible");
        cy.contains("UAN").should("be.visible");
        cy.contains("Aadhaar Number").should("be.visible");
        cy.contains("PAN Number").should("be.visible");
        cy.contains("Driving License Numbe").should("be.visible");
        cy.contains("Voter ID").should("be.visible");

        cy.get('[placeholder="Passport Number"]').clear().type("Sa45er");
        cy.get('[placeholder="UAN"]').clear().type("UAN");
        cy.get('[placeholder="Aadhaar Number"]').clear().type("3360545678");
        cy.get('[placeholder="PAN Number"]').clear().type("4657der");
        cy.get('[placeholder="Driving License Number"]')
            .clear()
            .type("2367893456");
        cy.get('[placeholder="Voter ID"]').clear().type("KHTR87654");

        cy.get(".h-7").eq(4).click();
        cy.get('[placeholder="Work Email"]').clear().type("saumyarani@nettantra.net");
        cy.get('[placeholder="Work Phone 1"]').clear().type("87858634958");
        cy.get('[placeholder="Work Phone 2"]').clear().type("804545678");
        cy.get('[placeholder="Present Address Line 1"]').clear().type("ssp");
        cy.get('[placeholder="Present Address Line 2"]').clear().type("anno");
        cy.get('[placeholder="Present Address City"]').clear().type("BBSR");
        cy.get('[placeholder="Present Address State"]').clear().type("Odisha");
        cy.get('[placeholder="Present Address Post Code"]').clear().type("754210");
        cy.get('[dusk="filament.forms.data.present_address_country"]').select(
            "Maldives"
        );

        cy.get(".h-7").eq(5).click();
        cy.get('[placeholder="Personal Email"]').clear().type("saumyarani@gmail.com");
        cy.get('[placeholder="Personal Phone"]').clear().type("6358634958");
        cy.get('[placeholder="Emergency Contact Name"]').clear().type("234545678");
        cy.get('[placeholder="Emergency Contact Relation"]').clear().type("KDP");
        cy.get('[placeholder="Emergency Contact Phone"]').clear().type("8658634958");
        cy.get('[placeholder="Permanent Address Line 1"]').clear().type("BBSR");
        cy.get('[placeholder="Permanent Address Line 2"]').clear().type("Odisha");
        cy.get('[placeholder="Permanent Address City"]').clear().type("754213");
        cy.get('[placeholder="Permanent Address State"]').clear().type("BBSR");
        cy.get('[placeholder="Permanent Address Post Code"]').clear().type("Odisha");
        cy.get('[dusk="filament.forms.data.permanent_address_country"]').select(
            "Maldives"
        );

        cy.get(".h-7").eq(6).click();
        cy.get('[placeholder="Bank Account Number"]').clear().type("3325864342");
        cy.get('[placeholder="Bank Name"]').clear().type("SBI");
        cy.get('[placeholder="Bank IFSC Code"]').clear().type("SBIN001234");
        cy.get('[placeholder="Bank MICR Code"]').clear().type("SBIN001234");
        cy.get('[placeholder="Bank SWIFT Code"]').clear().type("-w0394");
        cy.get('[placeholder="Bank IBAN Code"]').clear().type("ut876");
        cy.get('[placeholder="Bank Address Line 1"]').clear().type("Odisha");
        cy.get('[placeholder="Bank Address Line 2"]').clear().type("Odisha");
        cy.get('[placeholder="Bank Address City"]').clear().type("754213");
        cy.get('[placeholder="Bank Address State"]').clear().type("BBSR");
        cy.get('[placeholder="Bank Address Post Code"]').clear().type("754213");
        cy.get('[placeholder="Bank Phone"]').clear().type("63421351");
        cy.get('[placeholder="Bank Email"]').clear().type("saumyarani@gmail.com");
        cy.get('[dusk="filament.forms.data.bank_address_country"]').select(
            "Maldives"
        );
        cy.get(".space-y-6 > .filament-page-actions > .text-white").click();
    });
});
