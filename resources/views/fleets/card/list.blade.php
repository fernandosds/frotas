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

            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{url('fleets/cards/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i> Novo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="kt-portlet__body">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nº de série</th>                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cards as $card)
                    <tr id="_tr_user_{{$card->id}}">
                        <th scope="row">{{$card->id}}</th>                        
                        <td>{{$card->serial_number}}</td>                        
                        <td>
                            <div class="pull-right">
                                <a href="{{url('fleets/cards/edit')}}/{{$card->id}}" class="btn btn-sm btn-info"><span class="fa fa-fw fa-edit"></span> Detalhes</a>
                                <button type="button" class="btn btn-sm  btn-danger btn-delete-card" data-id="{{$card->id}}">
                                    <span class="fa fa-fw fa-trash"></span> Deletar
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $cards->links() !!}
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    /* Deletar */
    $('.btn-delete-card').click(function() {
        var id = $(this).data('id');
        var url = "{{url('fleets/cards/delete')}}/" + id;
        ajax_delete(id, url)
    })
</script>
@endsection