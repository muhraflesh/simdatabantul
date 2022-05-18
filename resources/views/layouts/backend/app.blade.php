<html class="loading" lang="{{ app()->getLocale() }}" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  @section('head')
      @include('layouts.backend.head')
  @show
  
  <body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 2-columns" data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">
    <!-- BEGIN: Header-->
    @include('layouts.backend.header')
    <!-- END: Header-->

    <!-- BEGIN: SideNav-->
    @include('layouts.backend.sidebar')
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
      <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
          <!-- Search for small screen-->
          <div class="container">
            <div class="row">

              <div class="col s10 m6 l6">
                <h5 class="breadcrumbs-title mt-0 mb-0">{{ @$page_name }}</h5>
                @yield('breadcrumbs')
              </div>

              @yield('action')
            </div>
          </div>
        </div>
        <div class="col s12">
          <div class="container">
            <div class="section">
              @yield('content')
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END: Page Main-->
    
    <!-- BEGIN: Footer-->
    @include('layouts.backend.footer')
    
    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('js/vendors.min.js') }}" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script>
    function resizetable() {
      if($(window).width() < 976){
          if($('.vertical-layout.vertical-gradient-menu .sidenav-dark .brand-logo').length > 0){
            $('.vertical-layout.vertical-gradient-menu .sidenav-dark .brand-logo img').attr('src','{{ asset('images/logo/materialize-logo-color.png') }}');
          }
          if($('.vertical-layout.vertical-dark-menu .sidenav-dark .brand-logo').length > 0){
            $('.vertical-layout.vertical-dark-menu .sidenav-dark .brand-logo img').attr('src','{{ asset('images/logo/materialize-logo-color.png') }}');
          }
          if($('.vertical-layout.vertical-modern-menu .sidenav-light .brand-logo').length > 0){
            $('.vertical-layout.vertical-modern-menu .sidenav-light .brand-logo img').attr('src','{{ asset('images/logo/materialize-logo.png') }}');
          }
      }
      else{
          if($('.vertical-layout.vertical-gradient-menu .sidenav-dark .brand-logo').length > 0){
            $('.vertical-layout.vertical-gradient-menu .sidenav-dark .brand-logo img').attr('src','{{ asset('images/logo/materialize-logo.png') }}');
          }
          if($('.vertical-layout.vertical-dark-menu .sidenav-dark .brand-logo').length > 0){
            $('.vertical-layout.vertical-dark-menu .sidenav-dark .brand-logo img').attr('src','{{ asset('images/logo/materialize-logo.png') }}');
          }
          if($('.vertical-layout.vertical-modern-menu .sidenav-light .brand-logo').length > 0){
            $('.vertical-layout.vertical-modern-menu .sidenav-light .brand-logo img').attr('src','{{ asset('images/logo/materialize-logo-color.png') }}');
          }
        }
      }
      resizetable();
    </script>
    <script src="{{ asset('js/plugins.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/custom/custom-script.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/scripts/customizer.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/scripts/ui-alerts.js') }}" type="text/javascript"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    @stack('script')
    <!-- END PAGE LEVEL JS-->
  </body>
</html>