@extends('layouts.app')

@section('content')

    <div class="kt-portlet">
        <div class="kt-portlet kt-portlet--mobile">

            <!-- HEADER -->
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand {{$icon}}"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        {{$title}}
                    </h3>
                </div>

                @if(!empty($url))
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="#" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i> Novo
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- CONTENT -->
            <div class="kt-portlet__body">

                <h3>Bem vindo {{Auth::user()->name}}</h3>

            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>


    </script>
@endsection