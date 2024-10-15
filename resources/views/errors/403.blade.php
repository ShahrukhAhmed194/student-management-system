<!DOCTYPE html>
<html lang="en">
<head>
    <!--  Title -->
    <title>Forbidden</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/img/favicon.png')}}" />
    <!-- Core Css -->
    <link  id="themeColors"  rel="stylesheet" href="{{ asset('assets/modernize/css/style.min.css') }}" />
</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <img src="{{ asset('assets/modernize/images/dreamers-loader.jpg') }}" alt="loader" class="lds-ripple img-fluid" />
</div>
<!-- Preloader -->
<div class="preloader">
    <img src="{{ asset('assets/modernize/images/dreamers-loader.jpg') }}" alt="loader" class="lds-ripple img-fluid" />
</div>
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-lg-6">
                    <div class="text-center">
                        <h1 class="fw-semibold mb-7 fs-9">403</h1>
                        <h4 class="fw-semibold mb-7">{{ __($exception->getMessage() ?: 'Forbidden') }}</h4>
                        <a class="btn btn-primary" href="/" role="button">Go Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  Import Js Files -->
<script src="{{ asset('assets/modernize/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modernize/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/modernize/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<!--  core files -->
<script src="{{ asset('assets/modernize/js/app.min.js') }}"></script>
<script src="{{ asset('assets/modernize/js/app.init.js') }}"></script>
<script src="{{ asset('assets/modernize/js/app-style-switcher.js') }}"></script>
<script src="{{ asset('assets/modernize/js/sidebarmenu.js') }}"></script>

<script src="{{ asset('assets/modernize/js/custom.js') }}"></script>
</body>
</html>
