<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        @php
    $words = explode(' ', $setting->nama_perusahaan);
    $word  = '';
    foreach ($words as $w) {
        if (!empty($w)) {
            $word .= $w[0];
        }
    }
@endphp

        <span class="logo-mini">{{ $word }}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ $setting->nama_perusahaan }}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color: #005564;">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Basculer la navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav"  >
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('img/UIDT.png') }}" class="user-image img-profil"
                            alt="UFR SES - UFR SET">
                        <span class="hidden-xs">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="background-color: #005564;">
                            <img src="{{ asset('img/UIDT.png') }}" class="img-circle img-profil"
                                alt="UFR SES - UFR SET">

                            <p>
                                {{ auth()->user()->name }} - {{ auth()->user()->email }}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('user.profil') }}" class="btn btn-primary btn-flat">Mon Profil</a>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="btn btn-danger btn-flat"
                                    onclick="$('#logout-form').submit()"><i class="fa fa-power-off"></i> Se deconnecter</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
    @csrf
</form>