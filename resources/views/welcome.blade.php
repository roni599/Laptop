<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Laptop_Paradise</title>
    <link rel="icon" href="{{ asset('backend/assets/img/l_favicon.jpg') }}" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('backend') }}/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script>
        // Use PHP to echo the environment variable directly into the JavaScript
        window.appConfig = {
            jwtTTL: @json(env('JWT_TTL', 1440)) // Default to 1440 minutes (24 hours) if not set
        };
    </script>
    @vite('resources/css/app.css')
</head>

<body class="sb-nav-fixed">

    <div id="app"></div>
    @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('backend') }}/js/scripts.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('backend') }}/assets/demo/chart-area-demo.js"></script>
    <script src="{{ asset('backend') }}/assets/demo/chart-bar-demo.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('backend') }}/js/datatables-simple-demo.js"></script>
</body>

</html>
