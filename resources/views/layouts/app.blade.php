<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/js/app.js') {{-- Inclua o build do Vue --}}
</head>
<body>
<div id="app"></div> {{-- Este será o contêiner para o Vue --}}
</body>
</html>
