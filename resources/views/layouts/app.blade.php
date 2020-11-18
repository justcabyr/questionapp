<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Question App') }}</title>

    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @yield('content')
<script src="/js/app.js"></script>
</body>
</html>
