<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/js/app.js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
