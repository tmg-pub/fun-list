<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>
         @yield( 'title', 'Fun-List' )
      </title>
      <link rel="stylesheet" href="{{ URL::asset('my.css') }}">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="/js/timers.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
      @yield( 'head', '' )
   </head>
   <body>
      <div class="header">
         <a href="/"><img src="/img/banner.png" class="logo"></div></a>
      </div>
      <div id="header_border"></div>
      <main>
         @yield('content')
      </main>
      <footer><a href="mailto:{{config('app.admin_email')}}">Submit Feedback</a></footer>
   </body>
</html>