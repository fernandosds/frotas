@extends('layouts.app')

@section('styles')
    <style>
    </style>
@endsection

@section('content')


    <iframe
        onload='resizeIframe(this)'
        src="https://bi.satcompany.com.br/public/dashboard/{{$hash}}"
        frameborder="0"
        width="100%"
        height="2500px"
        allowtransparency
    ></iframe>

@endsection

@section('scripts')
    <script>

    </script>
@endsection
