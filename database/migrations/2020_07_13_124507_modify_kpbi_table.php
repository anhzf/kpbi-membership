<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyKpbiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kpbi_member', function(Blueprint $table) {
            $table->dropForeign('kpbi_member_user_id_foreign');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->nullable();
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
            $table->dropForeign('kpbi_member_user_id_foreign');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullable();
        });
    }
}
