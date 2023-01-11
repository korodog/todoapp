<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Protection -->
    <meta name="csrf-token" content="{{ csrf_token() }}">   
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
    <link rel="stylesheet" href="/css/styles.css">
    <title>Todoアプリ</title>
</head>
<body>
    <edit id="app" :task="{{ ($task) }}"></edit>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>