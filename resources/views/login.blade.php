

<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Login | MyTrader</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/theam-default/assets/images/logo-round.png">

        <!-- preloader css -->
        <link rel="stylesheet" href="assets/theam-default/assets/css/preloader.min.css" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="assets/theam-default/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/theam-default/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/theam-default/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

        <style>
            @media only screen and (min-width: 768px) {
                .left-row{
                position: relative;
                }
                .center-img-column{
                    top: 50%;
                    position: absolute;
                    left: 50%;
                    transform: translate(-50%, -50%);
                }
            }
        </style>

    </head>

    <body>
       

    <!-- <body data-layout="horizontal"> -->
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-xxl-3 col-lg-4 col-md-5">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5 text-center">
                                        <a href="/" class="d-block auth-logo">
                                            <img src="/assets/theam-default/assets/images/logo-round.png" alt="" height="28"> <span class="logo-txt">MyTrader</span>
                                        </a>
                                    </div>
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Welcome Back !</h5>
                                            <p class="text-muted mt-2">Sign in to continue to MyTrader.</p>
                                        </div>
                                        <form class="mt-4 pt-2" id="login-form" action="/login-submit" method="POST">
                                        @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Email Address</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address">
                                                @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label"  >Password</label>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="">
                                                            <a href="#" class="text-muted">Forgot password?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                    <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="remember-check">
                                                        <label class="form-check-label" for="remember-check">
                                                            Remember me
                                                        </label>
                                                    </div>  
                                                </div>
                                                
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> MyTrader</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <div class="col-xxl-9 col-lg-8 col-md-7">
                        <div class="auth-bg pt-md-5 p-4 d-flex">
                            <div class="bg-overlay bg-primary"></div>
                            <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <!-- end bubble effect -->
                            <div class="row justify-content-center align-items-center center-img-column">
                                <div class="col-md-12">
                                    <img class="img-fluid" src="/assets/theam-default/assets/images/logo.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>


        <!-- JAVASCRIPT -->
        <script src="assets/theam-default/assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/theam-default/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/theam-default/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/theam-default/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/theam-default/assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/theam-default/assets/libs/feather-icons/feather.min.js"></script>
        <!-- pace js -->
        <script src="assets/theam-default/assets/libs/pace-js/pace.min.js"></script>
        <!-- password addon init -->
        <script src="assets/theam-default/assets/js/pages/pass-addon.init.js"></script>

    </body>

</html>