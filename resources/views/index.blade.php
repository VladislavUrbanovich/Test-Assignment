<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/sass/app.sass', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="container">
            <button type="button" id="user_import" class="btn btn__primary">Импортировать пользователей</button>
            <div id="count_summary" class="hidden">
                <div>Всего: <span id="total_count"></span></div>
                <div>Добавлено: <span id="imported_count"></span></div>
                <div>Обновлено: <span id="updated_count"></span></div>
            </div>
        </div>
    </body>
</html>
