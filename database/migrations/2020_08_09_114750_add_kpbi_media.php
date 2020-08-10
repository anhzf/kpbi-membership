<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKpbiMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kpbi_member', function (Blueprint $table) {
            $table->foreignId('pt_icon')
                ->nullable()
                ->constrained('media')
                ->onDelete('Set NULL');
            $table->foreignId('kaprodi_img')
                ->nullable()
                ->constrained('media')
                ->onDelete('Set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kpbi_member', function(Blueprint $table) {
            $table->dropForeign('kpbi_member_pt_icon_foreign');
            $table->dropForeign('kpbi_member_kaprodi_img_foreign');
        });
    }
}
