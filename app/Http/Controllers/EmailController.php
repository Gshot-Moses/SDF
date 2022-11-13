<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use PhpImap\MailBox;
//use Google\Client;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Client;
//use Webklex\IMAP\Facades\Client;

class EmailController extends Controller
{

    private $client;

    public function __construct() {
        $this->client = new \Google\Client();
        $this->client->setAuthConfig('C:/Projects/SDF/storage/client_secret.json');
        $this->client->addScope(\Google\Service\Drive::DRIVE_METADATA_READONLY);
        $this->client->setRedirectUri('http://localhost:8000/redirect');
    }

    public function index() {
        //$client = new Google\Client();
        //$client->setAuthConfig('C:/Projects/SDF/storage/client_secret.json');
        //$client->addScope(Google\Service\Gmail::GMAIL);
        //$redirect_uri = 'http://localhost:8000/mails';
        //$client->setRedirectUri($redirect_uri);
        //if (isset($_GET['code'])) {
        //    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        //}

        
        //$this->client->addScope(\Google\Service\Drive::DRIVE_METADATA_READONLY);
        
        // offline access will give you both an access and refresh token so that
        // your app can refresh the access token without user interaction.
        $this->client->setAccessType('offline');
        // Using "consent" ensures that your application always receives a refresh token.
        // If you are not using offline access, you can omit this.
        $this->client->setPrompt('consent');
        $this->client->setIncludeGrantedScopes(true);   // incremental auth
        $auth_url = $this->client->createAuthUrl();
        return redirect($auth_url);

        // $cm = new ClientManager($options = []);
        // $client = $cm->make([
        //     'host'          => 'imap.gmail.com',
        //     'port'          => 993,
        //     'encryption'    => 'ssl',
        //     'validate_cert' => false,
        //     'username'      => 'moussamohamansani@gmail.com',
        //     'password'      => 'defdjamicon',
        //     'protocol'      => 'imap'
        // ]);
        // //Client::account('default');
        // $client->connect();
        // $folders = $client->getFolders();
        // $mail = 'error';
        //return view('mails.index', ['mail' => 'mails']);
    }

    public function mails(Request $req) {
        // $cm = new ClientManager($options = []);
        // //dd($this->client->getAccessToken());
        // $clientMail = $cm->make([
        //     'host'          => 'imap.gmail.com',
        //     'port'          => 993,
        //     'encryption'    => 'ssl',
        //     'validate_cert' => true,
        //     'username'      => 'moussamohamansani@gmail.com',
        //     'password'      => $req->input('token'),
        //     'protocol'      => 'imap',
        //     'authentication' => "oauth"
        // ]);
        // Client::account('default');
        // $clientMail->connect();
        // $folders = $clientMail->getFolders();
        // $mail = 'error';
        return redirect('https://mail.ovh.net/roundcube/');
        //return view('mails.index', ['mail' => $folders]);
    }

    public function redirectGoogleAuth(Request $req) {
        $code = $req->input('code');
        //$client = new \Google\Client();
        $this->client->authenticate($code);
        $token = $this->client->getAccessToken();
        //$this->client->setAccessToken($token['access_token']);
        //dd($token);
        return redirect('http://localhost:8000/mails?token='.$token['access_token']);
        //return view('test', ['token' => $token]);
    }

    public function compose() {
        return view('mails.compose');
    }
}
