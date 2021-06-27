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
            'prefix'  => env('APP_DOMAIN') . '/c/',
            'prefixsize' => '73px'
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
            'name'    => 'pronouns',
            'title'   => 'Pronouns',
            'tooltip' => 'You don\'t really need to fill in gender!',
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

      $serialized_profile = base64_encode(json_encode($profile->attributesToArray()));
      $pp = public_path();
      $pid = $profile->id;
      
      return view( 'edit', [
         'profile'     => $profile,
         'traits'      => $traits,
         'fundata'     => \App\Helpers\BuildFunList::GetSerialized(),
         'profiledata' => $serialized_profile,
         'has_avatar'  => file_exists( "$pp/avatar/$pid.jpg" ),
      ]);
   }
}
