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
                green: {
                    150: "#ECFBF6",
                    250: "#B5E2D4",
                    350: "#B4E3D4",
                    450: "#54B999",
                    550: "#0ACF83",
                    650: "#007C56",
                    750: "#059669",
                },
                gray: {
                    20: "#F1F1F1",
                    30: "#F5F5F5",
                    750: "#565656",
                },
                primary: {
                   200: "#64748B",
                },
              
                danger: colors.red,
                primary: colors.slate,
                success: colors.emerald,
                warning: colors.amber,
            },
            screens: {
                xxs: "325px",

                xs: "415px",

                sm: "640px",
                // => @media (min-width: 640px) { ... }

                md: "768px",
                // => @media (min-width: 768px) { ... }

                lg: "1024px",
                // => @media (min-width: 1024px) { ... }

                xl: "1280px",
                // => @media (min-width: 1280px) { ... }

                "2xl": "1536px",
                // => @media (min-width: 1536px) { ... }
            },
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("@mertasan/tailwindcss-variables"),
    ],
};
