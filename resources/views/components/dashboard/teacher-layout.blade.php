<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Title -->
    <title>{{$title}}</title>
    <!-- Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Dreamers Academy" />
    <meta name="author" content="" />
    <meta name="keywords" content="Dreamers Academy" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/img/favicon.png')}}" />
    
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{asset('assets/modernize/libs/owl.carousel/dist/assets/owl.carousel.min.css')}}">
    
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="{{asset('assets/modernize/css/style.min.css')}}" />
    
    <!-- Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Prism Js -->
    <link rel="stylesheet" href="{{asset('assets/modernize/libs/prismjs/themes/prism.min.css')}}">
    
    <!-- datatable  Js -->
    <link rel="stylesheet" href="{{asset('assets/modernize/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/modernize/libs/toastr/toastr.css')}}">

    <style>
      #loader-main {
        width: 100%;
        height: 100%;
        top: 0;
        position: fixed;
        z-index: 999999;
        background-color: rgba(183, 198, 211, 0.4);
        overflow: hidden;
      }

      #loader2 {
        border: 4px solid #ffffff;
        border-radius: 50%;
        border-top: 4px solid #003662;
        width: 80px;
        height: 80px;
        position: absolute;
        left: 50%;
        right: 0;
        top: 50%;
        margin-left: -60px;
        margin-top: -60px;
        bottom: 0;
        animation: spin 2s linear infinite;
      }
    </style>
  </head>
  <body>
    <div class="loader-populate"></div>
    <!-- Preloader -->
    <div class="preloader">
      <img src="{{asset('assets/modernize/images/dreamers-loader.jpg')}}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="horizontal" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
      <!-- Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-lg-none">
              <a class="nav-link sidebartoggler ms-n3" id="sidebarCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item d-none d-lg-block">
                <a href="{{route('dashboard')}}" class="d-flex align-items-center">
                    <img height="50" src="{{asset('assets/img/Dreamers-Academy-Logo.png')}}" alt="">
                </a>
            </li>
          </ul>
          <div class="d-block d-lg-none">
            <a href="/" class="d-flex align-items-center">
                <img height="50" src="{{asset('assets/img/Dreamers-Academy-Logo.png')}}" alt="">
            </a>
          </div>
          <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="p-2">
              <i class="ti ti-dots fs-7"></i>
            </span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="d-flex align-items-center justify-content-between px-0 px-lg-8">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                  <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                      <img src="{{asset('assets/modernize/images/svgs/icon-flag-en.svg')}}" alt="" class="rounded-circle object-fit-cover round-20">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                      <div class="message-body" data-simplebar>
                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                          <div class="position-relative">
                            <img src="{{asset('assets/modernize/images/svgs/icon-flag-en.svg')}}" alt="" class="rounded-circle object-fit-cover round-20">
                          </div>
                          <p class="mb-0 fs-3">English (UK)</p>
                        </a>
                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                          <div class="position-relative">
                            <img src="{{asset('assets/modernize/images/svgs/icon-flag-bd.svg')}}" alt="" class="rounded-circle object-fit-cover round-20">
                          </div>
                          <p class="mb-0 fs-3">বাংলা (Bangla)</p>
                        </a>
                      </div>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="ti ti-bell-ringing"></i>
                      <div class="notification bg-primary rounded-circle"></div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                      <div class="d-flex align-items-center justify-content-between py-3 px-7">
                        <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                        <span class="badge bg-primary rounded-4 px-3 py-1 lh-sm">0 new</span>
                      </div>
                      <div class="message-body" data-simplebar>
                      </div>
                      <div class="py-6 px-7 mb-1">
                        <button class="btn btn-outline-primary w-100"> See All Notifications </button>
                      </div>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <div class="user-profile-img">
                          <img src="{{asset('assets/modernize/images/profile/user-1.jpg')}}" class="rounded-circle" width="35" height="35" alt="" />
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
                        <div class="py-3 px-7 pb-0">
                          <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                        </div>
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                          <img src="{{asset('assets/modernize/images/profile/user-1.jpg')}}" class="rounded-circle" width="80" height="80" alt="" />
                          <div class="ms-3">
                            <h5 class="mb-1 fs-3">{{auth()->user()->name}}</h5>
                            <span class="mb-1 d-block text-dark">{{auth()->user()->user_type}}</span>
                            <p class="mb-0 d-flex text-dark align-items-center gap-2">
                              <i class="ti ti-mail fs-4"></i> {{auth()->user()->email}}
                            </p>
                          </div>
                        </div>
                        <a href="{{route('logout')}}" class="btn btn-outline-primary w-100">Log Out</a>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
          </div>
        </nav>
      </header>
      <!-- Header End -->

      <!-- Sidebar Start -->
      <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav scroll-sidebar">
            @include('components.dashboard.inc.teacher._navBar')
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <!-- Sidebar End -->
      {{$slot}}
    </div>
    <!-- ======= Footer ======= -->
    <hr>
    <footer class=" text-center pb-3">
        <div class="fw-bold fs-3 text-primary">
            <a target="_blank" href="https://dreamersacademy.com.bd/terms-cond.html">Terms and Condition</a> | <a target="_blank" href="https://dreamersacademy.com.bd/return-policy.html">Return and Refund Policy</a> | <a target="_blank" href="https://dreamersacademy.com.bd/privacy-policy.html">Privacy Policy</a>
        </div>
        <div class="copyright fs-2">
            &copy; Copyright <strong><span>Dreamers Academy</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->
    <!-- Import Js Files -->
    <script src="{{asset('assets/modernize/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/modernize/libs/simplebar/dist/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/modernize/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- core files -->
    <script src="{{asset('assets/modernize/js/app.min.js')}}"></script>
    <script src="{{asset('assets/modernize/js/app.init.js')}}"></script>
    {{-- <script src="{{asset('assets/modernize/js/app.horizontal.init.js')}}"></script> --}}
    <script src="{{asset('assets/modernize/js/app-style-switcher.js')}}"></script>
    <script src="{{asset('assets/modernize/js/sidebarmenu.js')}}"></script>
    
    <script src="{{asset('assets/modernize/js/custom.js')}}"></script>
    <script src="{{asset('assets/modernize/libs/prismjs/prism.js')}}"></script>

    <!-- Page related files -->
    <script src="{{asset('assets/modernize/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/modernize/js/datatable/datatable-basic.init.js')}}"></script>

    <script src="{{ asset('assets/modernize/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/modernize/js/datatable/datatable-advanced.init.js') }}"></script>

    <script src="{{ asset('assets/modernize/libs/toastr/toastr.min.js') }}"></script>

    @toastr_render

   {{ $script ?? ''}}
  </body>
</html>