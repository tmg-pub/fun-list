<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get( '/', \App\Http\Controllers\Home::class )
   ->name( 'home' );

Route::get( '/test', function() {
   $user = User::factory()->create();
   /*
   $user->name = "hey";
   $user->email = "foo6";
   $user->password = "foo";
   $user->test1 = "bar";

   //$user->save();*/
   return $user;
})->middleware('auth');

Route::get( '/login', \App\Http\Controllers\Login::class )
   ->name('login');

Route::get( '/logout', \App\Http\Controllers\Logout::class )
   ->name('logout');

Route::get( '/panel', \App\Http\Controllers\Panel::class )
   ->name( 'panel' )
   ->middleware('auth');

Route::get( '/c/{slug}', \App\Http\Controllers\Profile::class )
   ->name( 'profile' );

Route::get( '/edit/{profile?}', \App\Http\Controllers\Edit::class )
   ->name( 'edit' )
   ->middleware('auth');

Route::get( '/api/fun', \App\Http\Controllers\Api\Fun::class );
Route::get( '/api/checkslug/{slug}', \App\Http\Controllers\Api\CheckSlug::class );

Route::post( '/publish', \App\Http\Controllers\Publish::class );
Route::post( '/update_avatar/{profile}', \App\Http\Controllers\UpdateAvatar::class );
