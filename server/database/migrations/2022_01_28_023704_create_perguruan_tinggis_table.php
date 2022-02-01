<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerguruanTinggisTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('perguruan_tinggis', function (Blueprint $table) {
      $table->id();
      $table->string('nama_singkat');
      $table->string('nama_lengkap');
      $table->enum('status', ['NEGERI', 'SWASTA'])->nullable();
      $table->string('kota')->nullable();
      $table->string('provinsi')->nullable();
      $table->string('alamat')->nullable();
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
    Schema::dropIfExists('perguruan_tinggis');
  }
}
