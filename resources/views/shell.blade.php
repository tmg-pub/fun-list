<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>
         @yield( 'title', 'Fun-List' )
      </title>
      <link rel="stylesheet" href="{{ URL::asset('my.css') }}">
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
   </head>
   <body>
      <div class="header">
         <a href="/"><div class="logo"></div></a>
      </div>
      <main>
         @yield('content')
      </main>
      <footer></footer>
   </body>
</html>