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

Route::get('/', function() {
    return view('welcome');
})->name( 'index' );

Route::get('/test', function() {
    $user = User::factory()->create();
    /*
    $user->name = "hey";
    $user->email = "foo6";
    $user->password = "foo";
    $user->test1 = "bar";

    //$user->save();*/
    return $user;
})->middleware('auth');

Route::get( '/login', \App\Http\Controllers\Login::class )->name('login');

Route::get( '/logout', \App\Http\Controllers\Logout::class )->name('logout');

Route::get( '/panel', \App\Http\Controllers\Panel::class )->name( 'panel' );