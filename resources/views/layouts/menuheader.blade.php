<!-- begin:: Header Menu -->
<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">


    </div>
</div>

<!-- end:: Header Menu -->

<!-- begin:: Header Topbar -->
<div class="kt-header__topbar">

    <!--begin: Search -->

    <!--begin: Search -->
    <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown" id="kt_quick_search_toggle">

        <!--
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
            <span class="kt-header__topbar-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect id="bound" x="0" y="0" width="24" height="24" />
                        <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" id="Path-2" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                        <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" id="Path" fill="#000000" fill-rule="nonzero" />
                    </g>
                </svg> </span>
        </div>
        -->

        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
            <div class="kt-quick-search kt-quick-search--inline" id="kt_quick_search_inline">
                <form method="get" class="kt-quick-search__form">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
                        <input type="text" class="form-control kt-quick-search__input" placeholder="Search...">
                        <div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close"></i></span></div>
                    </div>
                </form>
                <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                </div>
            </div>
        </div>
    </div>

    <!--end: Search -->

    <!--end: Search -->

    <!--begin: Notifications -->
    <div class="kt-header__topbar-item dropdown">
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="true">

        </div>

    </div>

    <!--end: Notifications -->

    <!--begin: Quick Actions -->
    <div class="kt-header__topbar-item dropdown">

        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

        </div>
    </div>
    <!--begin: Quick panel toggler -->
    <div class="kt-header__topbar-item kt-header__topbar-item--quick-panel" data-toggle="kt-tooltip" title="Quick panel" data-placement="right">

    </div>

    <!--begin: User Bar -->
    <div class="kt-header__topbar-item kt-header__topbar-item--user">
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
            <div class="kt-header__topbar-user">
                <span class="kt-header__topbar-welcome kt-hidden-mobile">Olá,</span>
                <span class="kt-header__topbar-username kt-hidden-mobile">{{ Auth::user()->name }}</span>
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

            <!--begin: Head -->
            <div class="kt-notification">
                <a href="{{url('profiles/edit')}}" class="kt-notification__item">
                    <div class="kt-notification__item-icon">
                        <i class="flaticon-settings kt-font-success"></i>
                    </div>
                    <div class="kt-notification__item-details">
                        <div class="kt-notification__item-title kt-font-bold">
                            CONFIGURAÇÕES
                        </div>
                    </div>
                </a>
            </div>
            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url({{asset('/assets/media/misc/bg-1.jpg')}})">

                <div class="kt-user-card__name">
                    {{ Auth::user()->name }}<br />
                    <small>
                        Empresa: {{ Auth::user()->customer->name ?? 'Sat Company' }} <br />
                        Nível de Acesso: @if( Auth::user()->access_level == 'management' ) Administrador
                        @elseif ( Auth::user()->access_level == 'commercial' ) Comercial
                        @elseif ( Auth::user()->access_level == 'logistic' ) Logística
                        @elseif ( Auth::user()->access_level == 'production' ) Produção
                        @elseif ( Auth::user()->access_level == 'fleets' ) Gestão de Frotas
                        @elseif ( Auth::user()->access_level == 'fleetslarge' ) Ges. Grandes Frotas
                        @endif
                    </small>
                </div>
                <div class="kt-user-card__badge">
                    <a href="{{ route('logout') }}" class="btn btn-danger btn-elevate btn-pill btn-sm">Sair</a>
                </div>
            </div>

        </div>
    </div>

    <!--end: User Bar -->
</div>

<!-- end:: Header Topbar -->


<!-- end:: Header -->
