<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;

class CheckSlug extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, string $slug )
    {
        $myid = intval($request->query( "profile", null ));
        
        $profile = Profile::where(["slug" => $slug])->first();
        
        $free = false;
        if( !$profile || $profile->id == $myid ) {
            $free = true;
        }

        return [
            "free" => $free
        ];
    }
}
