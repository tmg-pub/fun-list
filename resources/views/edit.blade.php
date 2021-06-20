@extends('shell')

@section('content')
@if( $profile->exists )
    <h2>Edit your character profile</h2>
@else
    <h2>Create your character profile</h2>
@endif

<form>
    <input type="hidden" name="profile_id" value="{{$profile->id}}">
    <table width="100%"><tbody><tr>
        <td style="vertical-align:top" width="180px">
            <p>
                <label for="name">Character Name</label><br>
                <input type="text" name="name" title="What is your full name?!">
            </p>
            <p>
                <label for="slug">Profile URL</label><br>
                <label for="slug" class="slug">f-list.us/c/</label><input type="text" name="slug" class="slug">
            </p>
            <p>
                <label for="race">Race</label><br>
                <input type="text" name="race">
            </p>
            <p>
                <label for="age">Age</label><br>
                <input type="text" name="age">
            </p>
            <p>
                <label for="gender">Gender</label><br>
                <input type="text" name="gender">
            </p>
            <p>
                <label for="color">Favorite Color</label><br>
                <input type="text" name="color">
            </p>
            <p>
                <label for="bestfriend">Best Friend</label><br>
                <input type="text" name="bestfriend">
            </p>
            <p>
                <label for="timezone">Timezone (OOC!)</label><br>
                <input type="text" name="timezone">
            </p>
        </td>
        <td style="vertical-align:top; padding-left: 16px;">
            <p>Populate the lists below with the activities that you like or don't like!</p>
            <ul>
                <li>FAVE means you crave doing that thing!</li>
                <li>YES means that you would definitely be up for that fun activity!</li>
                <li>MAYBE means that you have reservations about something!</li>
                <li>NO means that you will NEVER DO THAT THING!</li>
            </ul>
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
</form>

<script>
    
</script>

<script src="js/edit.js"></script>
@endsection