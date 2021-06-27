@extends( 'shell' )

@section( 'head' )
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>window.ProfileData = "{{ $profiledata }}"</script>
@include( 'fundata' )
<script src="/js/funtooltips.js"></script>
@endsection

@section( 'content' )
@if( $profile->exists )
   <h2>Edit your character profile</h2>
@else
   <h2>Create your character profile</h2>
@endif
<p>You can leave whatever you don't care about blank.</p>

<table class="layout-tc"><tbody><tr>
   <td class="left-column">
      <div class="traitlist">
         <?php
            if( $has_avatar ) {
               $avatar_path = "/avatar/" . $profile->id . ".jpg";
            } else {
               $avatar_path = "/avatar/none.jpg";
            }
         ?>
         <img src="{{$avatar_path}}" id="avatar_preview" class="avatar">
         <script>
            window.HasAvatar = {{$has_avatar ? "true" : "false"}};
         </script>
         <button id="change_avatar" style="display:none">Change Avatar</button>
         <button id="remove_avatar" style="display:none">Remove Avatar</button>

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
                                 style="box-sizing: border-box;"
                                 >
                  <script>
                     {
                        const fixThis = function( count ) {
                           let prefixWidth = document.getElementById( "field_{{$trait['name']}}_prefix" )
                                                .offsetWidth;
                           document.getElementById( "field_{{$trait['name']}}" )
                              .style.paddingLeft = (prefixWidth + 0) + "px";
                           if( count > 0 ) {
                              // Nice and hacky :)
                              setTimeout( () => {
                                 fixThis( count - 1 );
                              }, 1500);
                           }

                        }
                        fixThis( 10 );
                     }
                  </script>
               @else
                  <input type="text"
                        class="trait"
                        name="{{$trait['name']}}"
                        id="field_{{$trait['name']}}">
               @endif
            </p>
         @endforeach
      </div>
   </td>
   <td class="right-column">
      <p>Write some things about yourself!</p>
      <textarea class="bio editable-textbox" id="bio"></textarea>
      <p>Populate the lists below with the activities that you like or don't like!</p>
      <ul>
         <li>FAVE means you crave doing that thing!</li>
         <li>YES means that you would definitely be up for that fun activity!</li>
         <li>MAYBE means that you have reservations about something!</li>
         <li>NO means that you will NEVER DO THAT THING!</li>
      </ul>
      <div id="funbox" class="fundrop">
      </div>
      <table class="likelist"><tbody>
         <tr>
            <td class="fave fundrop" data-liketype="fave">
               <p class="title">FAVE 😍</p>
            </td>
            <td class="yes fundrop" data-liketype="yes">
               <p class="title">YES 😃</p>
            </td>
            <td class="maybe fundrop" data-liketype="maybe">
               <p class="title">MAYBE 🤔</p>
            </td>
            <td class="no fundrop" data-liketype="no">
               <p class="title">NO 🙈</p>
            </td>
         </tr>
      </tbody></table>
      <p>You can also add CUSTOM activities!</p>
      <div class="custom-activity-form">
         <p>
            <label>Activity Name</label><br>
            <input type="text" id="custom-fun" class="trait">
         </p>
         <p>
            <label>Description</label><br>
            <textarea id="custom-fun-desc" class="editable-textbox"></textarea>
         </p>
         <p>
            <button data-level="fave" class="add-custom-fun">FAVE</button>
            <button data-level="yes" class="add-custom-fun">YES</button>
            <button data-level="maybe" class="add-custom-fun">MAYBE</button>
            <button data-level="no" class="add-custom-fun">NO</button>
         </p>
      </div>
   </td>
</tr></tbody></table>
<div class="edit_footer">
   <button class="publish" id="button_publish">Publish!</button>
</div>

<div id="funtip" style="display:none">
   <div class="title"></div>
   <div class="desc"></div>
</div>

<script src="/js/edit.js"></script>

{{--
<form method="POST" action="/update_avatar/{{$profile->id}}" style="height:800px">
   <input name="picture" type="file">
   <input name="_token" value="{{ csrf_token() }}">
   <input type="submit">
</form>--}}

@endsection