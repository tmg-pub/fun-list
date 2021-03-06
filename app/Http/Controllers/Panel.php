<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\Profile;

class Panel extends Controller
{
   /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function __invoke(Request $request)
   {
      $profiles = Profile::select('name', 'id', 'slug')
                  ->where( 'user_id', Auth::user()->id )
                  ->get();
      if( count($profiles) == 0 ) {
         // They have no profiles! Create one!
         return redirect()->route( 'edit' );
      }
      return view( 'panel', [
         'profiles' => $profiles
      ]);
   }
}
