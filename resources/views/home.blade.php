
<table width="100%"><tbody>
   <tr>
      <td style="vertical-align: top">
         <h1>Welcome to F-list.us!</h1>
         <p>There is nothing like an F-list to help other roleplayers to know what you like to do for fun when you are hanging out!</p>

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