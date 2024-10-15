<!DOCTYPE html>
<html lang="en">
  <head>
    <!--  Title -->
    <title>Dreamers Academy - {{$title}}</title>

    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Dreamers Academy" />
    <meta name="author" content="" />
    <meta name="keywords" content="Dreamers Academy" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!--  Favicon -->
    <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Core Css -->
    <link  id="themeColors"  rel="stylesheet" href="{{asset('assets/modernize/css/style.min.css')}}" />

  </head>
  <body>
      <!-- Preloader -->
    <div class="preloader">
      <img src="{{asset('assets/modernize/images/dreamers-loader.jpg')}}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
      <img src="{{asset('assets/modernize/images/dreamers-loader.jpg')}}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
      <div class="position-relative overflow-hidden radial-gradient min-vh-100">
          <div class="position-relative z-index-5">
          <div class="row">
            <div class="col-xl-7 col-xxl-8 col-sm-12 col-md-7">
              <a href="https://dreamersacademy.com.bd/" class="text-nowrap logo-img d-block px-2 py-2 w-100">
                  <img src="{{asset('assets/img/logo.png')}}" width="180" alt="Dreamers Academy">
              </a>
              <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
                  <img src="{{asset('assets/modernize/images/backgrounds/login-security.svg')}}" alt="" class="img-fluid" width="500">
              </div>
            </div>
              {{$slot}}
          </div>
          </div>
      </div>
    </div>
    <!--  Import Js Files -->
    <script src="{{asset('assets/modernize/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/modernize/libs/simplebar/dist/simplebar.min.js')}}"></script>
    <!--  core files -->
    <script src="{{asset('assets/modernize/js/app.min.js')}}"></script>
    <script src="{{asset('assets/modernize/js/app.init.js')}}"></script>
    <script src="{{asset('assets/modernize/js/app-style-switcher.js')}}"></script>
    <script src="{{asset('assets/modernize/js/sidebarmenu.js')}}"></script>
    <script src="{{asset('assets/modernize/js/custom.js')}}"></script>
  </body>
</html>