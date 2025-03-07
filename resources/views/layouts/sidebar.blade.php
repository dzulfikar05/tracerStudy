<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">Tracer Study</span>
        </a>

        <ul class="sidebar-nav">
            <li class="menu-dashboard d-none sidebar-item  {{ set_active('dashboard') }}">
                <a class="sidebar-link  " href="/">
                    <i class="align-middle " data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            {{-- <li class="sidebar-header">
                Master Data
            </li> --}}

            <li class=" sidebar-item {{ set_active('pendidikan') }} {{ set_active('backoffice.master.job-category.index') }}">
                <a data-bs-target="#masters" data-bs-toggle="collapse" class="sidebar-link collapsed  ">
                    <i class="align-middle " data-feather="layers"></i> <span class="align-middle">Master Data</span>
                </a>
                <ul id="masters"
                    class="sidebar-dropdown list-unstyled collapse {{ set_show('pendidikan') }} {{ set_show('backoffice.master.job-category.index') }}"
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ set_active('backoffice.master.job-category.index') }}"><a class="sidebar-link"
                            href="{{ route('backoffice.master.job-category.index') }}">Kategori Profesi</a></li>
                </ul>
            </li>
            {{-- <li class="sidebar-item  {{ set_active('user') }}">
                <a class="sidebar-link  " href="user">
                    <i class="align-middle " data-feather="users"></i> <span class="align-middle">User</span>
                </a>
            </li> --}}

        </ul>

        {{-- <div class="sidebar-cta">
            <div class="sidebar-cta-content">
                <strong class="d-inline-block mb-2">Upgrade to Pro</strong>
                <div class="mb-3 text-sm">
                    Are you looking for more components? Check out our premium version.
                </div>
                <div class="d-grid">
                    <a href="upgrade-to-pro.html" class="btn btn-primary">Upgrade to Pro</a>
                </div>
            </div>
        </div> --}}
    </div>
</nav>
