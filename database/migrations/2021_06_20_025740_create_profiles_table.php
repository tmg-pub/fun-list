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
         $table->string( "name", 100 );
         $table->string( "slug" )->unique();
         $table->string( "age", 30 );
         $table->string( "gender", 30 );
         $table->string( "race", 30 );
         $table->string( "timezone", 30 );
         $table->text( "additional_fields" );
         $table->integer( "views" );
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
