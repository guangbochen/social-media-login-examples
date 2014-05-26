<?php
namespace api;
use User;
use Input;
use View;
use Session;
use Redirect;
use JsonHandler;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

// All the error handlers are at the file app/start/global.php line 56
class FacebookApisController extends \BaseController 
{
  private $fb_session;

  /**
   * contructor to initialise instance
   */
  public function __construct()
  {
    $this->fb_session = FacebookSession::setDefaultApplication(\Constants::FB_APPID, \Constants::FB_SECRET);
  }

  /**
   * this method sign in user with their Facebook Account
   * URI: /fb/signin?state=...
   * @state is generated in the loginController
   * @return @view
   */
  public function signInWithFacebook()
  {
    $input = json_decode(json_encode(Input::all()));

    // Ensure that this is no request forgery via validate state token
    if ($input->state != (Session::get('state'))) 
    {
      return JsonHandler::raiseError ('Invalid state parameter', 401);
    }

    //initialise facebook Session 
    $this->fb_session = new FacebookSession($input->fb_access_token);

    // Get the GraphUser object for the current user:
    $profile = (new FacebookRequest(
      $this->fb_session, 'GET', '/me'
    ))->execute()->getGraphObject(GraphUser::className());

    // user has successfully connected with token,
    // register as new user if not exist then login into the app
    $user = FacebookApisController::register($profile);
    \Auth::login($user);
    return Redirect::to('/dashboard');
  }

  /**
   * this method register Facebook user as new user when they are first time sign in
   * @param $profile, fb user profile
   * @return user object
   */
  public function register($profile)
  {
    $email = $profile->getProperty('email');
    $is_user  = \User::where('email', $email)->first();
    //register signed in Facebook user if not exist
    if(empty($is_user))
    {
      $newUser = (object) array(
        'email' => $email,
        'first_name' => $profile->getProperty('first_name'),
        'last_name' => $profile->getProperty('last_name'),
        'gender' => $profile->getProperty('gender'),
      );
      return $user = \User::make($newUser);
    }
    return $is_user;
  }
}

