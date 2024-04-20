<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <link rel="stylesheet" href="public/assets/css/loader.css">
</head>

<body>
    <span class="loader position-absolute top-50 start-50 translate-middle" style="z-index: 1060;display:none;"></span>
    <div class="container">

        @include('template.nav')

        @yield('content')
    </div>


    @include('modal')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="public/assets/js/url.js"></script>


    <script src="public/assets/js/modul.ajax.js"></script>
    <!-- <script src="public/assets/js/uiconstants.js"></script>
    <script src="public/assets/js/formconstants.js"></script>
    <script src="public/assets/js/apihandler.js"></script> -->
    <!-- <script src="public/assets/js/tableupdater.js"></script> -->
    <!-- <script src="public/assets/js/all.js"></script> -->
    <script src="public/assets/js/function.js"></script>
    <script src="public/assets/js/dashboard.js"></script>
    <script src="public/assets/js/create.js"></script>

    <script src="public/assets/js/setting.js"></script>
</body>

</html>