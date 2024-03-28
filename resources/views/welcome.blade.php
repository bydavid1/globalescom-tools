<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Global Escom</title>
        <link href="https://fonts.cdnfonts.com/css/gill-sans-mt-2" rel="stylesheet">
        @vite('resources/scss/app.scss')
    </head>
    <body>
        <div id="app"></div>
        <script >
            window.appUrl = @json(config('app.url'));
            window.pass = @json(config('app.psswd'));
        </script>
        @vite('resources/js/app.js')
    </body>
</html>
