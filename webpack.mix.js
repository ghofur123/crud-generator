const mix = require('laravel-mix');
mix.webpackConfig({
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"],
            plugins: ["@babel/plugin-syntax-dynamic-import"]
          }
        }
      }
    ]
  }
});
require('jquery');
mix.js('resources/js/app.js', 'public/js/app.js')
   .sass('resources/sass/app.scss', 'public/css/app.css')
   .postCss('resources/css/app.css', 'public/css/app.css', [
       // PostCSS plugins, if any
   ]);
mix.css('public/assets/css/loader.css', 'public/css/app.css');
mix.js('public/assets/js/dashboard.js', 'public/js/app.js');