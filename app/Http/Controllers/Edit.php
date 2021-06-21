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

      $traits = [
         [
            'name'    => 'name',
            'title'   => 'Character Name',
            'tooltip' => 'What is your full name?',
         ],
         [
            'name'    => 'slug',
            'title'   => 'Profile URL',
            'tooltip' => 'How users will find your profile. Can contain letters, numbers, and dashes.',
            'prefix'  => 'f-list.us/c/',
            'prefixsize' => '75px'
         ],
         [
            'name'    => 'race',
            'title'   => 'Race',
            'tooltip' => 'What is your race on Azeroth?',
         ],
         [
            'name'    => 'age',
            'title'   => 'Age',
            'tooltip' => 'Enter your age in years or however you want to format it. Can also be vague with an adjective.',
         ],
         [
            'name'    => 'gender',
            'title'   => 'Gender',
            'tooltip' => 'Are you a boy or a girl?',
         ],
         [
            'name'    => 'color',
            'title'   => 'Favorite Color',
            'tooltip' => 'What is your favorite color?',
         ],
         [
            'name'    => 'bestfriend',
            'title'   => 'Best Friend',
            'tooltip' => 'You can always update this later, too.',
         ],
         [
            'name'    => 'bedtime',
            'title'   => 'Bedtime',
            'tooltip' => 'What time you usually go to bed to get a restful healthful sleep.',
         ],
      ];
      //
      return view( 'edit', [
         'profile' => $profile,
         'traits' => $traits
      ]);
   }
}
