@extends('layouts.app')

@section('styles')
    <style>
    </style>
@endsection

@section('content')

    <iframe
        onload='resizeIframe(this)'
        src="https://bi.satcompany.com.br/public/dashboard/e20b1269-17d9-420e-8fb6-c957b4055c5a"
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