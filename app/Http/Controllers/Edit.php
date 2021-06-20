<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Edit extends Controller
{
   /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function __invoke(Request $request, \App\Models\Profile $profile )
   {
      if( $profile->exists && $profile->user_id != Auth::user()->id ) {
         // They don't own this profile.
         return redirect( 'panel' );
      }
      //
      return view( 'shell', [
         'content' => 'edit',
         'profile' => $profile
      ]);
   }
}
