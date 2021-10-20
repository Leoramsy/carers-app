<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent"
     style="top: 0px; background: #f5f6fa !important;z-index: 200;">
    <div class="container-fluid">
        <div class="navbar-wrapper" style="min-width: 250px;">
            <div class="navbar-minimize d-inline">
                <button id="minimize-button" class="minimize-sidebar btn btn-link btn-just-icon" rel="tooltip"
                        data-original-title="Sidebar toggle" data-placement="right">
                    <i class="fas fa-outdent visible-on-sidebar-regular"></i>
                    <i class="fas fa-indent  visible-on-sidebar-mini"></i>
                </button>
            </div>
            <div class="navbar-toggle d-inline">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" href="#">{{ $page ?? 'Home' }}</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse" id="navigation">
            <!-- Right Side Nav -->
            <ul class="navbar-nav ml-auto">
            @auth()
                <!-- USER DROP DOWN -->
                    <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            @if(isset($image))
                            @else
                                <div class="avatar-circle"
                                     style="float: left; background-image: url('https://avatars.dicebear.com/api/croodles-neutral/{{$initials}}.svg?mood[]=happy');">
                                </div>
                            @endif
                            <div style="float: right;"><b class="caret d-none d-lg-block d-xl-block"></b></div>
                            <b class="caret d-none d-lg-block d-xl-block"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-navbar" style="left: -130px;">
                            <!--
                            <li class="nav-link">
                                <a id="version_link" href="#" class="nav-item dropdown-item">About</a>
                            </li>
                            -->
                            <li class="nav-link">
                                <a href="{{ route('password.request') }}" class="nav-item dropdown-item">Reset
                                    Password</a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="nav-link">
                                <a href="#" class="nav-item dropdown-item"
                                   onclick="document.getElementById('logout-form').submit();">Log out</a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endauth
                @guest()
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item text-nowrap">
                            <!-- <a class="nav-link" href="#">Sign out</a> -->
                            <a href="{{ route('login') }}" style="color: black !important;">Login</a>
                        </li>
                        <li class="separator d-lg-none"></li>
                    </ul>
                @endguest
                <li class="separator d-lg-none"></li>
            </ul>
        </div>
    </div>
</nav>


