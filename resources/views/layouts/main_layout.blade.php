@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bazzar</title>

    <link rel="shortcut icon" href="{{ asset('build/assets/favicon.png') }}" type="image/x-icon">

    
</head>
<body>
    
    @yield('content')
    
</body>
</html>