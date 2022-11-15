@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar', ['status' => 'email'])
@endsection

@section('content')

<div class="container-fluid bg-light">
    <h3 class="py-2 pl-3">Emails</h3>
    <p class="lead">{{ $mail->textHtml }}</p>
</div>
@if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<a href="{{ route('mail.compose') }}" class="btn btn-info mt-1">Ecrire un mail</a>
<div class="m-2 row">
    <div class="col">
        <div class="card-body bg-light mb-1">
            <a href="#">Boite de reception</a>
        </div>
        <div class="card-body bg-light mb-1">
            <a href="#">Boite d'envoi</a>
        </div>
        <div class="card-body bg-light mb-1">
            <a href="#">Corbeille</a>
        </div>
    </div>
</div>

<script>
    function gisLoaded() {
        tokenClient = google.accounts.oauth2.initTokenClient({
          client_id: CLIENT_ID,
          scope: SCOPES,
          callback: async function(response) {

          }, // defined later
        });
        gisInited = true;
        maybeEnableButtons();
    }

    function tokenCallback(response) {

    }

    function gapiLoaded() {
        gapi.load('client', initializeGapiClient);
    }

    async function initializeGapiClient() {
        await gapi.client.init({
          apiKey: API_KEY,
          discoveryDocs: [DISCOVERY_DOC],
        });
        gapiInited = true;
        maybeEnableButtons();
    }
</script>

<script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
<script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>
@endsection
