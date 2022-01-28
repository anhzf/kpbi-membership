<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaprodisTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('kaprodis', function (Blueprint $table) {
      $table->id();
      $table->string('nama');
      $table->date('periode_mulai');
      $table->date('periode_purna');
      $table->string('email');
      $table->string('notelp');
      $table->foreignId('profile_id')
        ->constrained('kpbi_profiles')
        ->cascadeOnDelete();
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
    Schema::dropIfExists('kaprodis');
  }
}
