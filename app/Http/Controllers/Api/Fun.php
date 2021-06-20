<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Fun extends Controller
{
   private function ExtractName( string $filename ): string {
      return preg_replace( '/\..*/', "", basename( $filename ) );
   }

   private function BuildFunList() {
      $funs = glob( public_path('fun/*.txt') );
      
      return array_map( function( $f ) {
         return [
            'name' => $this->ExtractName($f),
            'desc' => file_get_contents($f)
         ];
      }, $funs );
   }
   /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function __invoke(Request $request)
   {
      //
      return $this->BuildFunList();
   }
}
