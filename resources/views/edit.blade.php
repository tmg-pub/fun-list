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
         @foreach( $traits as $trait )
            <p title="{{$trait['tooltip']}}">
               <label for="{{$trait['name']}}">{{$trait['title']}}</label><br>
               @if( isset( $trait['prefix'] ) )
                  <label for="{{$trait['name']}}"
                         style="position: absolute; padding: 0"
                         id="field_{{$trait['name']}}_prefix">{{$trait['prefix']}}
                  </label><input type="text"
                                 class="trait"
                                 name="{{$trait['name']}}"
                                 id="field_{{$trait['name']}}"
                                 style="box-sizing: border-box; padding-left: {{$trait['prefixsize'}};"
                                 >
                  <script>
                     let prefixWidth = document.getElementById( "field_{{$trait['name']}}_prefix" )
                                          .offsetWidth;
                     document.getElementById( "field_{{$trait['name']}}" )
                        .style.paddingLeft = (prefixWidth + 4) + "px";
                  </script>
               @else
                  <input type="text"
                         class="trait"
                         name="{{$trait['name']}}"
                         id="field_{{$trait['name']}}">
               @endif
            </p>
         @endforeach
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
            <div class="fun">Tes</div>
            <div class="fun">Tes</div>
            <div class="fun">Tes</div>
            <div class="fun">Tes</div>
            <div class="fun">Tes</div>
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