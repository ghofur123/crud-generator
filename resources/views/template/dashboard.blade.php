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

        <br>
        <br>
        <br>
        <div class="card" style="display: none;">
            <div class="card-header d-flex justify-content-between">
                <a href="#" class="btn btn-primary btn-input-class" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Create</a>
                <form class="d-flex w-30 search-table" action="#" role="search" method="post">
                    <input name="searchTerm" type="text" class="form-control me-2 search-input-form" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success btn-search" type="submit" style="display: none;">Search</button>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-striped table-data-result">
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content-class">

            </div>
        </div>
    </div>


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