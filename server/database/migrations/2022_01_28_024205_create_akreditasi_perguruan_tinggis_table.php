<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkreditasiPerguruanTinggisTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('akreditasi_perguruan_tinggis', function (Blueprint $table) {
      $table->id();
      $table->string('tipe'); // BAN-PT, internasional
      $table->string('peringkat');
      $table->date('tanggal_aktif')->nullable();
      $table->date('tanggal_kadaluarsa')->nullable();
      $table->foreignId('perguruan_tinggi_id')
        ->constrained('perguruan_tinggis')
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
    Schema::dropIfExists('akreditasi_perguruan_tinggis');
  }
}
