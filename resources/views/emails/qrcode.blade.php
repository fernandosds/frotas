
<div style="width: 100%; text-align: center; padding: 30px; font-family:Tahoma; font-size: 18px; color: #696969">
    <img src="https://www.satcompany.com.br/wp-content/uploads/Logo-home.png" style="width: 200px;"><hr />

    <h3>QRCode de validação de embarque</h3>

    Olá {{$user->name}}, <br /><br />

    Para realizar embarques de íscas com seu usuário é necessário realizar a validação através do QRCode abaixo.<br />
    Para isso utilize o <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=pt_BR&gl=US">Google Authenticator</a><br /><br />

    {!! $qrcode !!}

    <br /><br /><hr />
    <a href="https://www.satcompany.com.br"> www.satcomany.com.br</a>

</div>