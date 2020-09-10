<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boostorder eCommerce Demo</title>

    <link rel="stylesheet" href="{{ asset('css/app.css')  }}">
</head>
<body>
    @include('common.navbar')

    <div class="container my-5">
    @yield('content')
    </div>
</body>
</html>