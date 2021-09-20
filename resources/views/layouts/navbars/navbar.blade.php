<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent"  style="top: 0px; background: #f5f6fa !important;z-index: 200;">
    <div class="container-fluid">
        <div class="navbar-wrapper" style="min-width: 250px;">
            <div class="navbar-minimize d-inline">
                <button id="minimize-button" class="minimize-sidebar btn btn-link btn-just-icon" rel="tooltip" data-original-title="Sidebar toggle" data-placement="right">
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        
    </div>
</nav>


