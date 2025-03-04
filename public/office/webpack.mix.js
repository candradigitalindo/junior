const mix = require("laravel-mix");
require("laravel-mix-purgecss");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("src/js/app.js", "dist/js")
    .js("src/js/ckeditor-classic.js", "dist/js")
    .js("src/js/ckeditor-inline.js", "dist/js")
    .js("src/js/ckeditor-balloon.js", "dist/js")
    .js("src/js/ckeditor-balloon-block.js", "dist/js")
    .js("src/js/ckeditor-document.js", "dist/js");
mix.sass("src/sass/app.scss", "dist/css")
    .options({
        processCssUrls: false,
    })
    .autoload({
        "cash-dom": ["cash"],
    })
    .purgeCss({
        content: [
            "./src/**/*.{php,html,js,jsx,ts,tsx,vue}",
            "./src/**/*.{php,html,js,jsx,ts,tsx,vue}",
            "./node_modules/*.{php,html,js,jsx,ts,tsx,vue}",
            "./*.html",
        ],
        safelist: {
            deep: [/^fc-/, /fc$/],
        },
    })
    .browserSync({
        proxy: "arcone-rubick-html.test",
        files: ["src/**/*.*"],
    });
