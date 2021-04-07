<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpbiMemberTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
  Schema::create('kpbi_member', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')
    ->constrained('users')
    ->nullable();
    $table->string('jenjang')->nullable();
    $table->text('nama_prodi')->nullable();
    $table->text('jurusan')->nullable();
    $table->text('fakultas')->nullable();
    $table->json('pt')->nullable();
    $table->string('status')->nullable();
    $table->json('akreditasi_prodi')->nullable();
    $table->string('akreditasi_pt')->nullable();
    $table->text('web_prodi')->nullable();
    $table->json('alamat_kampus')->nullable();
    $table->json('kaprodi')->nullable();
    $table->text('email_prodi')->nullable();
    $table->string('no_telp_prodi')->nullable();
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
  Schema::dropIfExists('kpbi_member');
  }
}
