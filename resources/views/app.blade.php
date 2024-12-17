<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="HandheldFriendly" content="true">
    <style>
    /* html,
    body {
        touch-action: manipulation;
        -ms-touch-action: manipulation;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        user-select: none;
        overscroll-behavior: none;
    }

    * {
        -webkit-tap-highlight-color: transparent;
    } */
    </style>
    <script>
    // document.addEventListener('gesturestart', function(e) {
    //     e.preventDefault();
    // });
    // document.addEventListener('touchmove', function(e) {
    //     if (e.scale !== 1) {
    //         e.preventDefault();
    //     }
    // }, {
    //     passive: false
    // });

    window.Telegram.WebApp.ready();

    window.Telegram.WebApp.setHeaderColor('#000000');

    window.Telegram.WebApp.expand();
    window.Telegram.WebApp.expand();
    </script>
    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>