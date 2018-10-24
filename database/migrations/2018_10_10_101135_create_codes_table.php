<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('codes', function (Blueprint $table) {
      $table->increments('id');

      $table->integer('respondents_id')->unsigned()->references('id')->on('respondents')->index();

      $table->string('code')->unique();
      $table->boolean('active')->default(TRUE);
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
    Schema::dropIfExists('codes');
  }
}
