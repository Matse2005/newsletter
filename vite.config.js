// import { defineConfig } from "vite";
// import laravel from "laravel-vite-plugin";
// import tailwindcss from "@tailwindcss/vite";

// export default defineConfig({
//     plugins: [
//         tailwindcss(),
//         laravel({
//             input: [
//                 "resources/css/app.css",
//                 "resources/js/app.js",
//                 "resources/css/filament/newsletter/theme.css",
//             ],
//             refresh: true,
//         }),
//     ],
// });

import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});
