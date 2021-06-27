<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DiscordAPI;

class Home extends Controller
{
   /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function __invoke(Request $request)
   {
      $username = "";
      if( Auth::check() ) {
         $discord_id = Auth::user()->discord_id;
         $discord_user = DiscordAPI::Fetch( "/users/$discord_id", [
            'bot' => config( 'app.discord.bot_token' )
         ]);
         $username = $discord_user['username'];
      }
      return view( 'home', [
         'username' => $username
      ]);
   }
}
