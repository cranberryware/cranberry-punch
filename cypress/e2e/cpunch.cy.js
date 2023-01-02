describe('empty spec', () => {
  it('Successfully loads', () => {
    cy.visit('http://localhost:8000/')
    cy.viewport(1440,900)

  })
})