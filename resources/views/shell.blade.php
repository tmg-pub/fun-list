<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>
         @if( isset($title) )
            Fun-List - {{ $title }}
         @else
            Fun-List
         @endif
      </title>
      <link rel="stylesheet" href="{{ URL::asset('my.css') }}">
   </head>
   <body>
      <div class="header">
         <a href="/"><div class="logo"></div></a>
      </div>
      <main>
         @include( $content )
      </main>
      <footer></footer>
   </body>
</html>