const { defineConfig } = require("cypress");

module.exports = defineConfig({
  e2e: {
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
  env: {
    auth0_username: 'aman@email.com',
    auth0_password: 'aman@email.com',
    // auth0_domain: process.env.REACT_APP_AUTH0_DOMAIN,
    // auth0_audience: process.env.REACT_APP_AUTH0_AUDIENCE,
    // auth0_scope: process.env.REACT_APP_AUTH0_SCOPE,
    // auth0_client_id: process.env.REACT_APP_AUTH0_CLIENTID,
    // auth0_client_secret: process.env.AUTH0_CLIENT_SECRET
  }
});
