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
      $table->string('nama')->nullable();
      $table->date('periode_mulai')->nullable();
      $table->date('periode_purna')->nullable();
      $table->string('email');
      $table->string('notelp')->nullable();
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
