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
                danger: colors.rose,
                primary: colors.slate,
                success: colors.green,
                warning: colors.yellow,
            },
        },
        variables: {
            DEFAULT: {
                color: {
                    gray: {
                        DEFAULT: "#AAAAAA",
                        50: "#F1F1F1",
                        100: "#E7E7E7",
                        200: "#D3D3D3",
                        300: "#BEBEBE",
                        400: "#AAAAAA",
                        500: "#8E8E8E",
                        600: "#727272",
                        700: "#565656",
                        800: "#3A3A3A",
                        900: "#1E1E1E",
                    },
                    danger: colors.rose,
                    primary: colors.slate,
                    success: colors.green,
                    warning: colors.yellow,
                },
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("@mertasan/tailwindcss-variables"),
    ],
};
