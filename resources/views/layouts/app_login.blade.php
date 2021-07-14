@include('layouts._head')

    <body class="kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

        <!-- begin:: Page -->
        <div class="kt-grid kt-grid--ver kt-grid--root">
            <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

                    <!--begin::Aside-->
                    <div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside" style="background-image: url(../assets/media//bg/bg-4.jpg);">
                        <div class="">
                            <img src="{{url('logos/logo.svg')}}">
                        </div>
                        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
                            <div class="kt-grid__item kt-grid__item--middle">
                                <h3 class="kt-login__title">SatCompany</h3>
                                <h4 class="kt-login__subtitle">
                                    <small><i class="fa fa-box"></i></small> Rastreamento de Cargas <br />
                                    <small><i class="fa fa-truck"></i></small> Gestão de Frotas
                                </h4>
                            </div>
                        </div>
                        <div class="kt-grid__item">
                            <div class="kt-login__info">
                                <div class="kt-login__copyright">
                                    &copy {{date('Y')}} SatCompany
                                </div>
                                <div class="kt-login__menu">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper" style="background-image: url(../assets/media/bg/bg-3.jpg);">
                        <div class="kt-login__body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>

     @include('layouts._includes_js')

    @yield('scripts')

    </body>

</html>
