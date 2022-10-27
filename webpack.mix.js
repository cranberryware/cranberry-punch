const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss"); /* Add this line at the top */

mix.sass("resources/scss/open-attendance.scss", "public/css")
    .options({
        postCss: [tailwindcss("./tailwind.config.js")],
    })
    .version();
