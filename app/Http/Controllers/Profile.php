<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Profile extends Controller
{
   /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function __invoke(Request $request, string $slug )
   {
      $profile = \App\Models\Profile::where( 'slug', $slug )->first();
      if( !$profile ) {
         return view( 'notfound' );
      } else {
         // This can get spammy. Oh well!
         $profile->views++;
         $profile->save();

         $data = $profile->attributesToArray();

         $trait_list = [
            "race", "age", "gender", "pronouns",
            "color", "bestfriend", "bedtime",
         ];

         // English only :)
         $trait_localized = [
            "name" => "Name",
            "race" => "Race",
            "age"  => "Age",
            "gender" => "Gender",
            "pronouns" => "Pronouns",
            "color" => "Color",
            "bestfriend" => "Best Friend",
            "bedtime" => "Bed Time"
         ];

         $hidden_traits = [
            "name" => true,
            "slug" => true
         ];

         $known_trait = [];
         foreach( $trait_list as $trait )
            $known_trait[$trait] = true;
         
         $extra_traits = [];
         foreach( $profile->fields["traits"] as $key => $value ) {
            if( !isset($known_trait[$key]) && !$hidden_traits[$key] ) {
               $extra_traits[] = $key;
            }
         }

         $trait_list = array_merge( $trait_list, $extra_traits );

         $likesections = [
            'fave' => [
               'header' => 'FAVE 😍',
            ],
            'yes' => [
               'header' => 'YES 😃',
            ],
            'maybe' => [
               'header' => 'MAYBE 🤔',
            ],
            'no' => [
               'header' => 'NO 🙈',
            ],
         ];

         $pp = public_path();
         $pid = $profile->id;

         return view( 'profile', [
            'profile'         => $profile,
            'trait_list'      => $trait_list,
            'trait_localized' => $trait_localized,
            'likesections'    => $likesections,
            'canedit'         => Auth::check() && Auth::user()->id == $profile->user_id,
            'has_avatar'      => file_exists( "$pp/avatar/$pid.jpg" ),
         ]);
      }


   }
}
