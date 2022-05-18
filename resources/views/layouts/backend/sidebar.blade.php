<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
      <div class="brand-sidebar">
        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="{{ route('backend::dashboard') }}"><img src="{{ asset('images/logo/materialize-logo-color.png') }}" alt="materialize logo"/><span class="logo-text hide-on-med-and-down">Materialize</span></a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
      </div>
      <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
        @include('layouts.backend.sidebar_items')
        <!-- <li class="bold">
          <a class="waves-effect waves-cyan active" href="app-email.html">
            <i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Dashboard</span>
          </a>
        </li> -->
        
        <!-- <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Dashboard</span><span class="badge badge pill orange float-right mr-10">3</span></a>
          <div class="collapsible-body">
            <ul class="collapsible collapsible-sub" data-collapsible="accordion">
              <li><a class="collapsible-body" href="dashboard-modern.html" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Modern</span></a>
              </li>
              <li><a class="collapsible-body" href="dashboard-ecommerce.html" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>eCommerce</span></a>
              </li>
              <li><a class="collapsible-body" href="dashboard-analytics.html" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Analytics</span></a>
              </li>
            </ul>
          </div>
        </li> -->
        
      </ul>
      <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
    </aside>