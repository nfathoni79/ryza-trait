<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>

            <a class="nav-link" href="{!! route('admin.categories.index') !!}">
                <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                Categories
            </a>

            <a class="nav-link" href="{!! route('admin.items.index') !!}">
                <div class="sb-nav-link-icon"><i class="fas fa-gem"></i></div>
                Items
            </a>
        </div>
    </div>

    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ Auth::user()->name }}
    </div>
</nav>
