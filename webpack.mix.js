const mix = require('laravel-mix');

const __js =
mix.js('resources/js/app.js', 'public/js');

const arr = [
  require('postcss-import'),
  require('tailwindcss'),
];

__js.postCss('resources/css/app.css', 'public/css', arr);
const inProduction = mix.inProduction();
if (inProduction) {mix.version();}
