<?php

use App\Models\Enums\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users CHANGE COLUMN role role ENUM('" . implode("','", UserRole::toArray()) . "') NULL DEFAULT NULL");
            // $table->enum('role', UserRole::toArray())->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No need to drop or etc. Because the values are come from the enum itself.
        // If the migration is run for the first time, the enum values will be automatically added in the creation of the users table.
    }
};
