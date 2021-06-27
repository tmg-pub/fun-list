<?php

namespace App\Helpers;

class DiscordAPI {
   public static function Fetch( string $endpoint, $opts ) {
      $ch = curl_init( "https://discord.com/api/v8$endpoint" );

      $headers = [];

      $token  = $opts['token'] ?? null;
      $method = $opts['method'] ?? "GET";
      $body   = $opts['body'] ?? null;
      $bot    = $opts['bot'] ?? null;
      
      if( $token ) {
         $headers[] = "Authorization: Bearer $token";
      } else if( $bot ) {
         $headers[] = "Authorization: Bot $bot";
      }

      curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

      if( $method == "POST" ) {
         curl_setopt($ch, CURLOPT_POST, 1);
         if( isset($opts["nojson"]) ) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body );
         } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body) );
         }
      }

      $result = curl_exec($ch);

      return json_decode( $result, true );
   }
}