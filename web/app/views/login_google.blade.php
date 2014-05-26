@section('head')
@parent
<!-- extending header goes here -->
<!-- Place this asynchronous JavaScript just before your </body> tag -->
<script type="text/javascript">
(function() {
  var po = document.createElement('script'); 
  po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/client:plusone.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();

var helper = (function() {
  var authResult = undefined;

  return {
    /**
     * Hides the sign-in button and connects the server-side app after
     * the user successfully signs in.
     * @param {Object} authResult An Object which contains the access token and
     *   other authentication information.
     */
    onSignInCallback: function(authResult) {
      if (authResult['access_token']) {
        // The user is signed in
        this.authResult = authResult;
        helper.connectServer();
      } else if (authResult['error']) {
        // There was an error, which means the user is not signed in.
        console.log(authResult['error']);
      }
    },
      /**
       * Calls the server endpoint to connect the app for the user. The client
       * sends the one-time authorization code to the server and the server
       * exchanges the code for its own tokens to use for offline API access.
       * For more information, see:
       *   https://developers.google.com/+/web/signin/server-side-flow
       */
      connectServer: function() {
        $.ajax({
          type: 'POST',
            url: '/google/signin?state={{ $STATE }}',
            contentType: 'application/octet-stream; charset=utf-8',
            success: function(result) {
              //redirect to user dashboard page after logged in
              window.location.replace("/users/settings");
            },
              processData: false,
              data: this.authResult.code
        });
      },
  };
})();
/* Place in the header is required for solving callback undefined*/
function onSignInCallback(authResult) {
  helper.onSignInCallback(authResult);
};
</script>
@stop

  <div id="gConnect">
    <button class="g-signin"
      data-scope="https://www.googleapis.com/auth/plus.profile.emails.read https://www.googleapis.com/auth/plus.login"
      data-requestvisibleactions="http://schemas.google.com/AddActivity"
      data-callback="onSignInCallback"
      data-clientId="{{ $GOOLE_CLIENT_ID }}"
      data-accesstype="offline"
      data-cookiepolicy="single_host_origin"
      data-theme="dark" data-height="tall" data-width="wide">
    </button>
  </div>

