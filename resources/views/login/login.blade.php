<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="public/assets/css/loader.css">
</head>

<body>
    <div class="container">

        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="card w-70 shadow-lg">
                <div class="card-header text-center">
                    Login Sincan
                </div>
                <div class="card-body row">
                    <div class="alert alert-warning" role="alert" style="display: none;">
                    </div>
                    <div class="col rounded-2 border border-primary-subtle">
                        <form action="#" method="post" class="login-form">
                            @csrf
                            <div class="mb-3">
                                <label for="emailId" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="emailId" placeholder="name@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="passwordId" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="passwordId" placeholder="name@example.com">
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                    <div class="col rounded-2 ms-1 border border-primary-subtle">
                        <ol>
                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
                            <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                            <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</li>
                            <li>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
                            <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                            <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <span class="loader position-fixed top-50 start-50 translate-middle" style="z-index: 999; display:none;"></span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="public/assets/js/app.js"></script>
</body>

</html>