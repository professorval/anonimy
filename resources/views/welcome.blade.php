<!DOCTYPE html>
<html lang="en">
    <head>
        @vite(['resources/js/app.js'])
        <meta name="csrf-token" content="{{csrf_token()}}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>