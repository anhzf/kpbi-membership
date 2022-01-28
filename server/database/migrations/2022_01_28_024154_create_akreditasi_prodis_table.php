<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkreditasiProdisTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('akreditasi_prodis', function (Blueprint $table) {
      $table->id();
      $table->string('tipe'); // BAN-PT, internasional
      $table->string('peringkat');
      $table->date('tanggal_aktif')->nullable();
      $table->date('tanggal_kadaluarsa')->nullable();
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
    Schema::dropIfExists('akreditasi_prodis');
  }
}
