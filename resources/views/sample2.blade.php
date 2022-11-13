<!doctype html>
<html>
  <head>
    <title>Gmail API demo</title>
    <meta charset="UTF-8">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
      .hidden{ display: none; }
    </style>
  </head>
  <body>
    <div class="container">
      <h1>Gmail API demo</h1>

      <button id="authorize-button" class="btn btn-primary hidden">Authorize</button>

      <table class="table table-striped table-inbox hidden">
        <thead>
          <tr>
            <th>From</th>
            <th>Subject</th>
            <th>Date/Time</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->

    <script type="text/javascript">
      var clientId = '154983458845-5o4n9q50rhj07tocf6qmcpoovuturc2u.apps.googleusercontent.com';
      var apiKey = 'AIzaSyASYyYoo7mdefIvFehlQes8h_1pUU0lbFw';
      var scopes = 'https://www.googleapis.com/auth/gmail.readonly';

      function handleClientLoad() {
            gapi.client.setApiKey(apiKey);
            window.setTimeout(checkAuth, 1);
        }

        function checkAuth() {
            gapi.auth.authorize({
            client_id: clientId,
            scope: scopes,
            immediate: true
            }, handleAuthResult);
        }

        function handleAuthClick() {
            gapi.auth.authorize({
            client_id: clientId,
            scope: scopes,
            immediate: false
            }, handleAuthResult);
            return false;
        }

        function handleAuthResult(authResult) {
        if(authResult && !authResult.error) {
            loadGmailApi();
            $('#authorize-button').remove();
            $('.table-inbox').removeClass("hidden");
        } else {
            $('#authorize-button').removeClass("hidden");
            $('#authorize-button').on('click', function(){
            handleAuthClick();
            });
        }
}

function loadGmailApi() {
  gapi.client.load('gmail', 'v1', displayInbox);
}

    </script>

    <!-- <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script> -->
    <script async defer src="https://apis.google.com/js/api.js" onload="handleClientLoad()"></script>
</body>
</html>
