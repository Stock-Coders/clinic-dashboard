<!DOCTYPE html>
<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('/images/favicon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('/images/favicon.png')}}" type="image/x-icon">

    <title>Error 403 - !عذرا</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/fontawesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/feather-icon.css')}}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/chartist.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/date-picker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/prism.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/vector-map.css')}}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{asset('/assets/dashboard/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/dashboard/css/responsive.css')}}">
</head>
    <body>
<!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="theme-loader">
            <div class="loader-p"></div>
        </div>
    </div>
<!-- Loader ends-->
<!-- page-wrapper Start       -->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
<!-- Page Header Start-->
        @include('layouts.dashboard.includes.header')
<!-- Page Header Ends                              -->
<!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon">
<!-- Page Sidebar Start-->
        @auth
        @include('layouts.dashboard.includes.sidebar')
        @endauth
<!-- Page Sidebar Ends-->
    <div class="page-body">
        {{-- @include('layouts.dashboard.includes.bookmark') --}}
<!-- Container-fluid starts-->
<main id="main">
    <div class="wrapper vh-100" id="error-404">
        <div class="align-items-center h-100 d-flex w-50 mx-auto">
          <div class="mx-auto text-center">
            <h1 class="display-1 m-0 font-weight-bolder text-muted" style="font-size:80px;"><i class="fa fa-lock f-50"></i> 403</h1>
            <h1 class="mb-1 text-muted font-weight-bold">!عذرا</h1>
            <h6 class="mb-3 text-muted">أنت غير مصرح لك بالدخول إلى هذه الصفحة</h6>
            <a href="{{ route('dashboard') }}" class="btn btn-lg btn-primary px-5">العودة إلى لوحة القيادة الرئيسية</a>
           </div>
        </div>
      </div>
  </main>

    </div>
<!-- footer start-->
    @auth
    @include('layouts.dashboard.includes.footer')
    @endauth
{{-- end-footer --}}
</div>
</div>
    <!-- latest jquery-->
    <script src="{{asset('/assets/dashboard/js/jquery-3.5.1.min.js')}}"></script>
    <!-- feather icon js-->
    <script src="{{asset('/assets/dashboard/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/icons/feather-icon/feather-icon.js')}}"></script>
    <!-- Sidebar jquery-->
    <script src="{{asset('/assets/dashboard/js/sidebar-menu.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/config.js')}}"></script>
    <!-- Bootstrap js-->
    <script src="{{asset('/assets/dashboard/js/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/bootstrap/bootstrap.min.js')}}"></script>
    <!-- Plugins JS start-->
    <script src="{{asset('/assets/dashboard/js/chart/chartist/chartist.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/chart/chartist/chartist-plugin-tooltip.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/chart/knob/knob.min.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/chart/knob/knob-chart.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/chart/apex-chart/apex-chart.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/chart/apex-chart/stock-prices.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/prism/prism.min.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/clipboard/clipboard.min.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/counter/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/counter/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/counter/counter-custom.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/custom-card/custom-card.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/notify/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/vector-map/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/vector-map/map/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/vector-map/map/jquery-jvectormap-us-aea-en.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/vector-map/map/jquery-jvectormap-uk-mill-en.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/vector-map/map/jquery-jvectormap-au-mill.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/vector-map/map/jquery-jvectormap-in-mill.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/vector-map/map/jquery-jvectormap-asia-mill.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/dashboard/default.js')}}"></script>
    {{-- <script src="{{asset('/assets/dashboard/js/notify/index.js')}}"></script> --}}
    <script src="{{asset('/assets/dashboard/js/datepicker/date-picker/datepicker.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/datepicker/date-picker/datepicker.en.js')}}"></script>
    <script src="{{asset('/assets/dashboard/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{asset('/assets/dashboard/js/script.js')}}"></script>
    {{-- <script src="{{asset('/assets/dashboard/js/theme-customizer/customizer.js')}}"></script> --}}
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>
