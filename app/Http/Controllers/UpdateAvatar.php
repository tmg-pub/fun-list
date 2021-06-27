<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\ProcessBuilder;


class UpdateAvatar extends Controller
{
   /*
   // https://stackoverflow.com/a/14649689/3264295
   private function ResizeImage( $file, $w, $h, $crop=FALSE ) {
      list($width, $height) = getimagesize( $file );
      $r = $width / $height;
      if ($width > $height) {
         $width = ceil($width-($width*abs($r-$w/$h)));
      } else {
         $height = ceil($height-($height*abs($r-$w/$h)));
      }
      $newwidth  = $w;
      $newheight = $h;
      
      $src = imagecreatefromstring( file_get_contents($file );
      $dst = imagecreatetruecolor( $newwidth, $newheight );
      imagecopyresampled( $dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );

      return $dst;
  }*

   /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function __invoke(Request $request, \App\Models\Profile $profile )
   {
      if( !$profile->exists ) {
         return response()->json([
            'error' => "Profile doesn't exist."
         ], 400 );
      }
      
      if( $profile->exists && $profile->user_id != Auth::user()->id ) {
         // They don't own this profile.
         return response()->json([
            'error' => "That's not your profile."
         ], 403 );
      }

      if( $request->hasFile('picture') ) {

         $ext = $request->picture->extension();
         $original_path = $request->picture->path();
         $new_path = public_path() . "/avatar/" . $profile->id . ".jpg";

         // This feels like something begging to be hacked.
         $magick = env( 'IMAGEMAGICK' );
         system( "$magick -verbose \"$ext:$original_path\" -resize 150x150 \"$new_path\"", $result_code );
         if( $result_code != 0 ) {
            return response()->json([
               'error' => 'Image conversion failed.'
            ], 400);
         }
      } else {
         unlink( public_path() . "/avatar/" . $profile->id . ".jpg" );
      }
   }
}
