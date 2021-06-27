<?php

namespace App\Helpers;

class BuildFunList {
   private static function ExtractName( string $filename ): string {
      return preg_replace( '/\..*/', "", basename( $filename ) );
   }

   public static function Get() {
      $funs = glob( public_path('fun/*.txt') );
      
      return array_map( function( $f ) {
         return [
            'name' => self::ExtractName($f),
            'desc' => file_get_contents($f)
         ];
      }, $funs );
   }

   public static function GetSerialized() {
      return base64_encode(json_encode(self::Get()));
   }
}
