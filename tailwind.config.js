const colors = require("tailwindcss/colors");

module.exports = {
    content: ["./resources/**/*.blade.php", "./vendor/filament/**/*.blade.php"],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                blue: {
                    50: "#32a0bf",
                    100: "#2896b5",
                    200: "#1e8cab",
                    300: "#1482a1",
                    400: "#0a7897",
                    500: "#006e8d",
                    600: "#006483",
                    700: "#005a79",
                    800: "#00506f",
                    900: "#004665",
                },
                danger: colors.red,
                primary: colors.slate,
                success: colors.emerald,
                warning: colors.amber,
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("@mertasan/tailwindcss-variables"),
    ],
};
