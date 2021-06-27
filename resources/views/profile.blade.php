@extends( 'shell' )

@section( 'head' )
@include( 'fundata' )
<script src="/js/funtooltips.js"></script>
@endsection

@section( 'content' )
<div class="profile-view">
<!--///////////////////////////////////////////////////////////////////////////////////-->
<h1>{{$profile->name}}

@if( $canedit )
   <a href="/edit/{{$profile->id}}" title="Edit" style="font-size: 0.6em">[Edit]</a>
@endif
</h1>
<table class="layout-tc"><tbody><tr>
   <td class="left-column">
      @if( $has_avatar )
         <img class="avatar" src="/avatar/{{$profile->id}}.jpg">
      @endif
      <ul class="traitlist">
         <?php
            $traits = $profile->fields["traits"];
         ?>
         @foreach( $trait_list as $traitname )
            @if( isset($traits[$traitname]) && !empty($traits[$traitname]) )
               <li>
                  <span class="traitname">
                     {{$trait_localized[$traitname] ?? $traitname}}:
                  </span>
                  <span class="traitvalue">{{$traits[$traitname]}}</span>
               </li>
            @endif
         @endforeach
      </ul>
   </td>
   <td class="right-column">
      @if( !empty($profile->fields["bio"]) )
         <div class="bio">
            {!!str_replace("\n","<br>",$profile->fields["bio"])!!}
         </div>
      @endif
      <table class="likelist"><tbody>
         <tr>
            @foreach( $likesections as $key => $sec )
               <td class="{{$key}}" data-liketype="{{$key}}">
                  <p class="title">{{$sec['header']}}</p>
                  <ul>
                     @foreach( $likes[$key] as $like )
                        <?php
                           $likeclass = "";
                           if( isset($like['desc']) ) {
                              $likeclass .= " custom";
                           }
                        ?>
                        <li class="{{$likeclass}}">
                           <span class="fun-item" 
                                 data-name="{{$like['name']}}"
                                 @if( isset($like['desc']) )
                                    data-desc="{{$like['desc']}}"
                                 @endif
                                 >
                              {{$like["name"]}}
                           </span>
                        </li>
                     @endforeach
                  </ul>
               </td>
            @endforeach
         </tr>
      </tbody></table>
   </td>
</tr></tbody></table>

<div id="funtip" style="display:none">
   <div class="title"></div>
   <div class="desc"></div>
</div>

<script src="/js/profile.js"></script>

<!--///////////////////////////////////////////////////////////////////////////////////-->
</div>
@endsection