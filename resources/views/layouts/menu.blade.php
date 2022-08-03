<!-- begin:: Aside -->
<div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
    <div class="kt-aside__brand-logo">
        <a href="/">
            <img alt="Logo" src="{{url('logos/logo_sat_branco.svg')}}" width="60%" />
        </a>
    </div>
    <div class="kt-aside__brand-tools">
        <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
            <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon id="Shape" points="0 0 24 0 24 24 0 24" />
                        <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) " />
                        <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) " />
                    </g>
                </svg></span>
            <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon id="Shape" points="0 0 24 0 24 24 0 24" />
                        <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero" />
                        <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) " />
                    </g>
                </svg></span>
        </button>

    </div>
</div>

<!-- end:: Aside -->

<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">

            @if( Auth::user()->type == 'sat' || Auth::user()->type == 'ext')
            <!-- CLIENTE EXTERNO ______________________________________________________________________________________________________________________ -->
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">MENU</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">

                <a href="{{url('/')}}" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-home"></i></span>
                    <span class="kt-menu__link-text">Home</span>
                </a>
            </li>

            <!-- EMBARQUES -->
            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_boarding ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-shipping-fast"></i></span>
                    <span class="kt-menu__link-text">Embarques</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('boardings')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Em Andamento</span></a></li>
                    </ul>
                </div>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('boardings/finished')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Encerrados</span></a></li>
                    </ul>
                </div>
                @if (Auth::user()->email != 'admin@satcompany.com.br')
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('boardings/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Novo</span></a></li>
                    </ul>
                </div>
                @endif
            </li>
            <!--
            <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{url('monitoring/')}}" class="kt-menu__link ">
                    <span class="kt-menu__link-icon"><i class="fa fa-map-marker"></i></span>
                    <span class="kt-menu__link-text">Monitoramento</span>
                </a>
            </li>
            -->

            <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{url('stocks/')}}" class="kt-menu__link ">
                    <span class="kt-menu__link-icon"><i class="fa fa-box-open"></i></span>
                    <span class="kt-menu__link-text">Estoque</span>
                </a>
            </li>

            <!-- HIST. CONTRATOS -->
            <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{url('contracts/history/')}}" class="kt-menu__link ">
                    <span class="kt-menu__link-icon"><i class="fa fa-history"></i></span>
                    <span class="kt-menu__link-text">Hist. Contratos</span>
                </a>
            </li>
            @endif
            @if (Auth::user()->email != 'admin@satcompany.com.br')

            @if( Auth::user()->access_level == 'management' )

            <!-- ADMIN. SISTEMA ______________________________________________________________________________________________________________________ -->
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">GERÊNCIA</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_users ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <!-- USUÁRIOS -->
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-user icon-menu"></i></span>
                    <span class="kt-menu__link-text">Usuários</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>

                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('management/users/')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista usuários</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('management/users/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Novo Usuário</span></a></li>
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_logs ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <!-- LOGS -->
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-signal"></i></span>
                    <span class="kt-menu__link-text">Logs</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('management/logs/')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Logs</span></a></li>
                    </ul>
                </div>
            </li>

            <!-- TECNOLOGIA
                            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_technologies ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">

                                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                    <span class="kt-menu__link-icon"><i class="fa fa-signal"></i></span>
                                    <span class="kt-menu__link-text">TECNOLOGIA</span>
                                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('management/devices/technologies/')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista tecnologia</span></a></li>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('management/devices/technologies/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Nova tecnologia</span></a></li>
                                    </ul>
                                </div>

                            </li>
                            -->

            <!--  TIPO DE CARGA
                            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_loads ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">

                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                    <span class="kt-menu__link-icon"><i class="fa fa-truck-moving"></i></span>
                                    <span class="kt-menu__link-text">TIPO DE CARGAS</span>
                                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('management/typeofloads/')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista cargas</span></a></li>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('management/typeofloads/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Novo tipo de carga</span></a></li>
                                    </ul>
                                </div>

                            </li>
                            -->
            <!-- LOCAIS DE ACOMODAÇÃO
                            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_locations ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">

                                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                    <span class="kt-menu__link-icon"><i class="fa fa-truck-loading"></i></span>
                                    <span class="kt-menu__link-text">LOCAIS DE ACOMODAÇÃO</span>
                                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('management/accommodationlocations/')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista loc. acomodação</span></a></li>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('management/accommodationlocations/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Cadastro acomodação</span></a></li>
                                    </ul>
                                </div>

                            </li>
                        -->

            @endif

            <!-- ACESSOS EXCLUSIVOS SAT COMPANY -->
            @if( Auth::user()->type == 'sat' )

            @if( Auth::user()->access_level == 'management' || Auth::user()->access_level == 'commercial' )

            <!-- COMERCIAL ______________________________________________________________________________________________________________________ -->
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">COMERCIAL</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_customers ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <!-- CLIENTES -->
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-users"></i></span>
                    <span class="kt-menu__link-text">Clientes</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('commercial/customers/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Novo cliente</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('commercial/customers/')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista cliente</span></a></li>
                    </ul>
                </div>

            </li>

            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_contracts ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <!-- CONTRATOS -->
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-file-contract"></i></span>
                    <span class="kt-menu__link-text">Contratos</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('commercial/contracts/')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista contratos</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('commercial/contracts/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Novo contrato</span></a></li>
                    </ul>
                </div>

            </li>

            @endif

            @if( Auth::user()->access_level == 'management' || Auth::user()->access_level == 'production' )

            <!-- PRODUÇÃO ______________________________________________________________________________________________________________________ -->
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">PRODUÇÃO</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            <!-- ÍSCAS -->
            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_devices ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-truck-moving"></i></span>
                    <span class="kt-menu__link-text">Produtos</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('production/devices/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Upload de planilha</span></a></li>
                    </ul>
                </div>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('production/devices/')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista de Produtos</span></a></li>
                    </ul>
                </div>
            </li>

            @endif

            @if( Auth::user()->access_level == 'management' || Auth::user()->access_level == 'logistic' )

            <!-- LOGÍSTICA ______________________________________________________________________________________________________________________ -->
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">LOGÍSTICA</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_logistics ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <!-- LOGISTICA -->
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-boxes"></i></span>
                    <span class="kt-menu__link-text">Logísticas</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('logistics/contracts')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Contr. Pendentes</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('logistics/contracts/completed')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Contr. Finalizados</span></a></li>
                    </ul>
                </div>
            </li>

            @endif

            <!-- FIM DOS ACESSOS EXCLUSIVOS SAT COMPANY -->
            @endif

            @if( Auth::user()->type == 'sat' || Auth::user()->type == 'fle')

            @if( Auth::user()->access_level == 'management' || Auth::user()->access_level == 'fleets' )
            <!-- LOCADORA ______________________________________________________________________________________________________________________ -->

            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">GESTÃO DE FROTAS</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            <!--
                    @if( Auth::user()->access_level == 'management' ||  auth()->user()->accessMenu('monitoring') )
                <li class="kt-menu__item {{$menu_open_fleets_monitoring ?? ''}}" aria-haspopup="true">
                            <a href="{{url('fleets/monitoring')}}" class="kt-menu__link ">
                                <span class="kt-menu__link-icon"><i class="fas fa-globe"></i></span>
                                <span class="kt-menu__link-text">Monitoramento</span>
                            </a>
                        </li>
                    @endif
-->
            @if(Auth::user()->access_level == 'management' || auth()->user()->accessMenu('dashboard') )
            <li class="kt-menu__item " aria-haspopup="true" {{$menu_open_fleets_dashbaord ?? ''}}>
                <a href="{{url('fleets/dashboard')}}" class="kt-menu__link ">
                    <span class="kt-menu__link-icon"><i class="fas fa-chart-line"></i></span>
                    <span class="kt-menu__link-text">Dashboard</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->access_level == 'management' || auth()->user()->accessMenu('driver') )
            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_drivers ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <!-- MOTORISTAS -->
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-user-tie"></i></span>
                    <span class="kt-menu__link-text">Motoristas</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('fleets/drivers')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista Motorista</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('fleets/drivers/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Novo Motorista</span></a></li>
                    </ul>
                </div>
            </li>
            @endif
            @if( Auth::user()->access_level == 'management' || auth()->user()->accessMenu('fleet_car') )
            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_cars ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <!-- CARROS -->
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-car-side"></i></span>
                    <span class="kt-menu__link-text">Frota de carros</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('fleets/cars')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista de Veículos</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('fleets/cars/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Novo veículo</span></a></li>
                    </ul>
                </div>
            </li>
            @endif
            @if( Auth::user()->access_level == 'management' || auth()->user()->accessMenu('card') )
            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_cards ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <!-- CARTÕES -->
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-address-card"></i></span>
                    <span class="kt-menu__link-text">Cartões</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('fleets/cards')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista Cartões</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('fleets/cards/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Novo Cartão</span></a></li>
                    </ul>
                </div>
            </li>
            @endif

            <!--
                    @if( Auth::user()->access_level == 'management' ||  auth()->user()->accessMenu('cost') )
                <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_costs ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                <span class="kt-menu__link-icon"><i class="fa fa-money-bill-wave"></i></span>
                                <span class="kt-menu__link-text">Custos</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('fleets/costs')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lista Custos</span></a></li>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('fleets/costs/new')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Novo Custo</span></a></li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    -->
            @endif
            @endif

            @if( Auth::user()->type == 'sat' || Auth::user()->type == 'gfl')

            @if( Auth::user()->access_level == 'management' || Auth::user()->access_level == 'fleetslarge' )

            <!-- GRANDES FROTAS ______________________________________________________________________________________________________________________ -->
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">GRANDES FROTAS</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_fleetslarges ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <!-- GRANDES FROTAS -->
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-car-side"></i></span>
                    <span class="kt-menu__link-text">Grid</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('fleetslarges')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Dashboard</span></a></li>
                        <!-- <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('logistics/contracts/completed')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Mapa</span></a></li> -->
                    </ul>
                </div>
            </li>
            @if( Auth::user()->customer_id == 8)
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">MONITORAMENTO</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_monitoramento ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <!-- GRANDES FROTAS -->
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-map-marker-alt"></i></span>
                    <span class="kt-menu__link-text">Central de Monitoramento</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('fleetslarges.garagem.list')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Garagem</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('fleetslarges.alerta.list')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Grupo Alerta</span></a></li>
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item " aria-haspopup="true" {{$menu_open_fleets_dashbaord ?? ''}}>
                <a href="{{route('fleetslarges.poligono.index')}}" class="kt-menu__link ">
                    <span class="kt-menu__link-icon"><i class="fas fa-map-marked-alt"></i></span>
                    <span class="kt-menu__link-text">Mapa Monitoramento</span>
                </a>
            </li>
            @endif

            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_fleetslarges ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">



            <!-- Iframe Santander -->
                @if( Auth::user()->customer_id == 8 || Auth::user()->customer_id == 13)
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">ANÁLISE DE DADOS</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_fleetslarges_iframe ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-chart-bar"></i></span>
                    <span class="kt-menu__link-text">Análise</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('fleetslarges.analyzeInstallation')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Instalações</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('fleetslarges.analyzeCar')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Veículos (Telemetria)</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('fleetslarges.analyzeBase')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Base</span></a></li>
                    </ul>
                </div>
            </li>

            @endif
            <!-- Menu Movida -->
            @if( Auth::user()->customer_id == 7)
            <!-- Iframe Movida -->
            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_fleetslarges_iframe ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-chart-bar"></i></span>
                    <span class="kt-menu__link-text">Análise</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('fleetslarges.analyzeFrota')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Frota</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('fleetslarges.analyzeEventos')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Eventos</span></a></li>
                    </ul>
                </div>
            </li>
            @endif

            <!-- Iframe SOMPO -->
            <!--
            @if( Auth::user()->customer_id == 6)

            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_fleetslarges_iframe ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-chart-bar"></i></span>
                    <span class="kt-menu__link-text">Análise</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('fleetslarges.analyzeFrotaSompo')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Frota</span></a></li>
                    </ul>
                </div>
            </li>

            @endif
-->


            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">MAPA</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            <!-- Mapa Geral -->
            @if( Auth::user()->customer_id == 7 || Auth::user()->customer_id == 8 || Auth::user()->customer_id == 11 || Auth::user()->customer_id == 13)
            <li class="kt-menu__item " aria-haspopup="true" {{$menu_open_fleets_dashbaord ?? ''}}>
                <a href="{{route('fleetslarges.monitoring.allCars')}}" class="kt-menu__link ">
                    <span class="kt-menu__link-icon"><i class="fas fa-map-marked-alt"></i></span>
                    <span class="kt-menu__link-text">Mapa Geral</span>
                </a>
            </li>
            @endif
            @endif
            @endif
            @endif

            @if( Auth::user()->customer_id == 8 || Auth::user()->customer_id == 13)
            <!--
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">RELATÓRIOS</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu {{$menu_open_fleetslarges_iframe ?? ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="fa fa-file-export"></i></span>
                    <span class="kt-menu__link-text">Relatório</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Subheaders</span></span></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('fleetslarges.analyzeInstallation')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Frustrados - Clientes</span></a></li>
                    </ul>
                </div>
            </li>
-->
            @endif
        </ul>
    </div>
</div>
