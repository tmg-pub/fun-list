<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DiscordAPI;

class Login extends Controller
{

   /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function __invoke(Request $request)
   {
      $code = $request->query( 'code', '' );
      if( $code == '' ) {
         // Initiate login sequence.
         return redirect()->away( config('app.discord.oauth.login_url') );
      }
      
      //
      // So this section is after authorization from the above redirect. We will receive a
      // code from Discord to get our access token. Pass that to the /oauth2/token
      // endpoint along with the original authorization details such as redirect and
      // scope.
      $token = DiscordAPI::Fetch( '/oauth2/token', [
         'nojson' => true,
         'method' => 'POST',
         
         'body' => [
            'client_id'     => config( 'app.discord.oauth.clientid' ),
            'client_secret' => config( 'app.discord.oauth.secret' ),
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => config( 'app.discord.oauth.redirect_url' ),
            'scope'         => 'identify'
         ]
      ]);

      if( isset($token['error']) ) {
         dd( $token );
         return "todo, error page :)";
      }

      $token = $token['access_token'];
      $identity = DiscordAPI::Fetch( '/users/@me', [
         'token' => $token
      ]);

      $user = \App\Models\User::firstOrCreate([
         'discord_id' => $identity['id']
      ]);
      
      Auth::login( $user, $remember = true );

      return redirect()->route( 'panel' );
   }
}
