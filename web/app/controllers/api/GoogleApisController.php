<?php
namespace api;
use User;
use Input;
use View;
use Session;
use Redirect;
use JsonHandler;

class GoogleApisController extends \BaseController 
{

  private $client;
  private $plus;

  /**
   * contructor to initialise instance
   */
  public function __construct()
  {
    $this->client = new \Google_Client();
    $this->client->setApplicationName(\Constants::APPLICATION_NAME);
    $this->client->setClientId(\Constants::GOOLE_CLIENT_ID);
    $this->client->setClientSecret(\Constants::CLIENT_SECRET);
    $this->client->setRedirectUri('postmessage');
    $this->plus = new \Google_Service_Plus($this->client);
  }

  // Upgrade given auth code to token, and store it in the session.
  // POST body of request should be the authorization code.
  // Example URI: /connect?state=...&gplus_id=...
  public function signInWithGoogle()
  {
    $input = json_decode(json_encode(Input::all()));

    /* // Ensure that this is no request forgery via validate state token */
    if ($input->state != Session::get('state')) 
    {
      return JsonHandler::raiseError ('Invalid state parameter', 401);
    }

    // Exchange the OAuth 2.0 authorization code for user credentials.
    $this->client->authenticate($input->g_access_code);

    $profile = $this->plus->people->get('me');

    // user has successfully connected with token,
    // register new Google user and login into the app
    $user = GoogleApisController::register($profile->toSimpleObject());
    \Auth::login($user);
    return Redirect::to('/dashboard');
  }

  //Register Google user if is new 
  public function register($profile)
  {
    // get Google user profile 
    $email = (object) $profile->emails[0];
    $is_user  = \User::where('email', $email->value)->first();

    //register signed in Google user if not exist
    if(empty($is_user))
    {
      $newUser = (object) array(
        'email' => $email->value,
        'first_name' => $profile->name['givenName'],
        'last_name' => $profile->name['familyName'],
        'gender' => $profile->gender,
      );
      return $user = \User::make($newUser);
    }
    return $is_user;
  }
}

