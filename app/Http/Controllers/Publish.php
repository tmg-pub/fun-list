<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Models\Profile;
use HTMLPurifier;
use HTMLPurifier_Config;

class Publish extends Controller
{
   private static function SanitizeSlug( $slug ) {
      return preg_replace( '/[^A-Za-z0-9-]/', "", $slug );
   }
   /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function __invoke(Request $request)
   {
      if( !Auth::check() ) {
         return response()->json([
            'error' => 'You need to be logged in for this endpoint.'
         ], 403 );
      }
      $input = json_decode($request->getContent(), true);
      $profile = $input['profile'] ?? null;
      if( $profile ) {
         $profile = Profile::where(['id' => $profile])->first();
         if( $profile ) {
            if( Auth::user()->id != $profile->user_id ) {
               return response()->json([
                  'error' => 'This profile does not belong to the user.'
               ], 403);
            }
         }
      }

      if( !$profile ) {
         // We are doing an update!
         $profile = Profile::create([
            'user_id' => Auth::user()->id
         ]);
      }
      
      $purifier_config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($purifier_config);
      $clean_bio = $purifier->purify( $input['bio'] );

      $profile->fields = [
         'bio' => $clean_bio,
         'traits' => $input['traits'],
         'likes' => $input['likes'],
      ];
      $profile->name = $input['traits']['name'];

      $profile->save();

      try {
         $profile->slug = self::SanitizeSlug($input['traits']['slug']);
         $profile->save();

         return response()->json([
            'status' => 'okay',
            'id' => $profile->id
         ]);
      } catch( QueryException $e ) {
         $errorCode = $e->errorInfo[1];
         if($errorCode == 1062){
            // houston, we have a duplicate entry problem
            return response()->json([
               'status' => 'okay',
               'slug' => 'in-use',
               'id' => $profile->id
            ]);
         }
      }
   }
}
