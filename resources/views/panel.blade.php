@extends( 'shell' )

@section( 'content' )

<h2>Your character profiles</h2>
<ul class="profile_list">
@foreach( $profiles as $profile )
   <li>
      <a href="/c/{{$profile->slug}}">{{$profile->name}}</a>
      <a href="/edit/{{$profile->id}}">(✍ Edit)</a>
   </li>
@endforeach
</ul>
<h2><a href="/edit">Create a new profile</a></h2>

@endsection