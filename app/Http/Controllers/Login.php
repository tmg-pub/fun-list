<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
   private function DiscordRequest( string $endpoint, $opts ) {
      $ch = curl_init( "https://discord.com/api/v8$endpoint" );
  
      $headers = [];
  
      $token  = $opts["token"] ?? null;
      $method = $opts["method"] ?? "GET";
      $body   = $opts["body"] ?? null;
  
      if( $token ) {
         $headers[] = "Authorization: Bearer $token";
      }
  
      curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  
      if( $method == "POST" ) {
         curl_setopt($ch, CURLOPT_POST, 1);
         if( isset($opts["nojson"]) ) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body );
         } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body) );
         }
      }
  
      $result = curl_exec($ch);
  
      return json_decode( $result, true );
   }

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
         return redirect()->away( env("DISCORD_LOGIN_URL") );
      }

      //
      // So this section is after authorization from the above redirect. We will receive a
      // code from Discord to get our access token. Pass that to the /oauth2/token
      // endpoint along with the original authorization details such as redirect and
      // scope.
      $token = $this->DiscordRequest( '/oauth2/token', [
         'nojson' => true,
         'method' => 'POST',
         
         'body' => [
            'client_id'     => env( 'DISCORD_CLIENTID' ),
            'client_secret' => env( 'DISCORD_SECRET' ),
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => env( 'DISCORD_REDIRECT_URL' ),
            'scope'         => 'identify'
         ]
      ]);

      if( isset($token['error']) ) {
         dd( $token );
         return "todo, error page :)";
      }

      $token = $token['access_token'];
      $identity = $this->DiscordRequest( '/users/@me', [
         'token' => $token
      ]);

      $user = \App\Models\User::firstOrCreate([
         'discord_id' => $identity['id']
      ]);

      Auth::login( $user, $remember = true );

      return redirect()->route( 'panel' );
   }
}
