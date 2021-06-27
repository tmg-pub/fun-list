<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('profiles', function (Blueprint $table) {
         $table->id();
         $table->foreignIdFor(\App\Models\User::class);
         $table->string( "name", 100 )->nullable();
         $table->string( "slug" )->unique()->nullable();
         $table->json( "fields" )->nullable();
         $table->integer( "views" )->default( 0 );
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('profiles');
   }
}
