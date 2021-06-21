@extends('shell')

@section('content')
@if( $profile->exists )
   <h2>Edit your character profile</h2>
@else
   <h2>Create your character profile</h2>
@endif
<p>You can leave anything blank if you want.</p>

   <input type="hidden" name="profile_id" value="{{$profile->id}}">
   <table width="100%"><tbody><tr>
      <td style="vertical-align:top" width="180px">
         <p>
            <label for="name">Character Name</label><br>
            <input type="text" name="name" id="field_name" title="What is your full name?">
         </p>
         <p>
            <label for="slug">Profile URL</label><br>
            <label for="slug" name="slug" id="field_slug" class="slug">f-list.us/c/</label><input type="text" name="slug" class="slug">
         </p>
         <p>
            <label for="race">Race</label><br>
            <input type="text" name="race" id="field_race" title="What is your race on Azeroth?">
         </p>
         <p>
            <label for="age">Age</label><br>
            <input type="text" name="age" id="field_age" title="Enter your age in years or however you want to format it. Can also be vague with an adjective.">
         </p>
         <p>
            <label for="gender">Gender</label><br>
            <input type="text" name="gender" id="field_gender" title="Are you a boy or a girl?">
         </p>
         <p>
            <label for="color">Favorite Color</label><br>
            <input type="text" name="color" id="field_color" title="What is your favorite color?">
         </p>
         <p>
            <label for="bestfriend">Best Friend</label><br>
            <input type="text" name="bestfriend" id="field_bestfriend" title="You can always update this later, too.">
         </p>
         <p>
            <label for="bedtime">Bedtime</label><br>
            <input type="text" name="bedtime" id="field_bedtime" title="What time you usually go to bed to get a restful healthful sleep.">
         </p>
      </td>
      <td style="vertical-align:top; padding-left: 16px;">
         <p>Write some things about yourself!</p>
         <textarea class="bio" id="bio"></textarea>
         <p>Populate the lists below with the activities that you like or don't like!</p>
         <ul>
            <li>FAVE means you crave doing that thing!</li>
            <li>YES means that you would definitely be up for that fun activity!</li>
            <li>MAYBE means that you have reservations about something!</li>
            <li>NO means that you will NEVER DO THAT THING!</li>
         </ul>
         <div id="likesources">
            
         </div>
         <table class="likelist"><tbody>
            <tr>
               <td class="fave">
                  <p class="title">FAVE 😍</p>
               </td>
               <td class="yes">
                  <p class="title">YES 😃</p>
               </td>
               <td class="maybe">
                  <p class="title">MAYBE 🤔</p>
               </td>
               <td class="no">
                  <p class="title">NO 🙈</p>
               </td>
            </tr>
         </tbody></table>
      </td>
   </tr></tbody></table>
   <div class="edit_footer">
      <button class="publish">Publish!</button>
   </div>

<script>
    
</script>

<script src="js/edit.js"></script>
@endsection