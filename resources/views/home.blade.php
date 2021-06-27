@extends( 'shell' )

@section( 'content' )
<table width="100%"><tbody>
   <tr>
      <td style="vertical-align: top">
         @auth
            <h1>Welcome back, {{$username}}!</h1>
         @endauth

         @guest
            <h1>Welcome to {{ucfirst(config('app.domain'))}}!</h1>
         @endguest

         <p>There is nothing like an F-list to help other role-players to know what you like to do for fun!</p>

         @guest
         <h2><a href="{{ route('panel') }}">Create a profile!</a></h2>
         <p>Logging in is done through Discord. Once you log in you can create or edit your character profiles!</p>
         @endguest

         @auth
         <h2><a href="{{ route('panel') }}">Manage your character profiles</a></h2>
         <h2><a href="{{ route('logout') }}">Log out</a></h2>
         @endauth
      </td>
      <td>
         <img src="/img/friends.jpg">
      </td>
   </tr>
</tbody></table>
@endsection