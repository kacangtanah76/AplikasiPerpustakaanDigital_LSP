<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <style>
        body {
            background: linear-gradient(135deg, #F9F6EE , #f7f2eb);
            height: 100vh;
        }

        .card {
            border-radius: 15px;
            background-color: #EFEBE9;
        }

        .btn-brown {
            background-color: #6D4C41;
            color: white;
        }

        .btn-brown:hover {
            background-color: #4E342E;
        }

        .btn-outline-brown {
            border: 1px solid #6D4C41;
            color: #6D4C41;
        }

        .btn-outline-brown:hover {
            background-color: #6D4C41;
            color: white;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>