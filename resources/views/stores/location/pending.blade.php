<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sign In | {{ $location['location_name'] }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @livewireStyles
</head>
<body>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand" href="#">
            {{ $location['location_name'] }}
        </span>
    </div>
</nav>
<!-- Page content-->
<div class="container">
    <div class="text-center mt-5">
        <h1>Welcome To {{ $location['location_name'] }}</h1>
        <p class="lead">A complete project boilerplate built with Bootstrap</p>
        <p>Bootstrap v5.1.3</p>
    </div>
    <div class="col-md-6 col-sm-12 m-auto">
        @livewire('show-pending', ['shopperUuid' => $shopper->uuid, 'aaa' => 2])
    </div>
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts

</body>
</html>
