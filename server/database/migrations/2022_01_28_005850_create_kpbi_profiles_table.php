<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpbiProfilesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('kpbi_profiles', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')
        ->constrained('users')
        ->cascadeOnDelete();
      $table->enum('jenjang', ['S1', 'S2', 'S3']);
      $table->string('nama_prodi');
      $table->string('nama_jurusan')->nullable();
      $table->string('nama_fakultas');
      $table->string('nama_perguruan_tinggi'); // computed
      $table->string('link');
      $table->string('email_kantor_prodi');
      $table->string('notelp_kantor_prodi');
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
    Schema::dropIfExists('kpbi_profiles');
  }
}
