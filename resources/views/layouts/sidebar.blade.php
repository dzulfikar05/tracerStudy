<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('backoffice.dashboard.index') }}">
            <span class="align-middle">Tracer Study</span>
        </a>

        <ul class="sidebar-nav">
            <li class="menu-dashboard sidebar-item  {{ set_active('backoffice.dashboard.index') }}">
                <a class="sidebar-link  " href="{{ route('backoffice.dashboard.index') }}">
                    <i class="align-middle " data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item  {{ set_active('backoffice.content.index') }}">
                <a class="sidebar-link  " href="{{ route('backoffice.content.index') }}">
                    <i class="align-middle " data-feather="layout"></i> <span class="align-middle">Konten Website</span>
                </a>
            </li>

            {{-- <li class="sidebar-header">
                Master Data
            </li> --}}

            <li
                class=" sidebar-item {{ set_active('pendidikan') }} {{ set_active('backoffice.master.job-category.index') }}">
                <a data-bs-target="#masters" data-bs-toggle="collapse" class="sidebar-link collapsed  ">
                    <i class="align-middle " data-feather="layers"></i> <span class="align-middle">Master Data</span>
                </a>
                <ul id="masters"
                    class="sidebar-dropdown list-unstyled collapse
                    {{ set_show('backoffice.master.profession.index') }}
                    {{ set_show('backoffice.master.profession-category.index') }}
                    {{ set_show('backoffice.master.company.index') }}
                    {{ set_show('backoffice.master.user.index') }}"
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ set_active('backoffice.master.profession-category.index') }}"><a
                            class="sidebar-link"
                            href="{{ route('backoffice.master.profession-category.index') }}">Kategori Profesi</a>
                    </li>
                    <li class="sidebar-item {{ set_active('backoffice.master.profession.index') }}"><a
                            class="sidebar-link" href="{{ route('backoffice.master.profession.index') }}">Profesi</a>
                    </li>
                    <li class="sidebar-item {{ set_active('backoffice.master.company.index') }}"><a
                            class="sidebar-link" href="{{ route('backoffice.master.company.index') }}">Perusahaan</a>
                    </li>
                    <li class="sidebar-item {{ set_active('backoffice.master.user.index') }}"><a class="sidebar-link"
                            href="{{ route('backoffice.master.user.index') }}">User</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item  {{ set_active('backoffice.alumni.index') }}">
                <a class="sidebar-link  " href="{{ route('backoffice.alumni.index') }}">
                    <i class="align-middle " data-feather="users"></i> <span class="align-middle">Alumni</span>
                </a>
            </li>
            <!--atasan alumni-->
            <li class="sidebar-item  {{ set_active('backoffice.superior.index') }}">
                <a class="sidebar-link  " href="{{ route('backoffice.superior.index') }}">
                    <i class="align-middle " data-feather="users"></i> <span class="align-middle">Atasan Alumni</span>
                </a>
            </li>
            <li
                class="sidebar-item
                {{ set_active('backoffice.questionnaire.index') }}
                {{ set_active('backoffice.questionnaire.show') }}
                {{ set_active('backoffice.questionnaire.show-assessment') }}
                {{ set_active('backoffice.questionnaire.show-answer') }}">
                <a class="sidebar-link  " href="{{ route('backoffice.questionnaire.index') }}">
                    <i class="align-middle " data-feather="align-left"></i> <span class="align-middle">Kuisioner</span>
                </a>
            </li>
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
