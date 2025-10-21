<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('template_name');
            $table->json('payload');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['template_name']);
        });

        // Add document_id to existing tables
        Schema::table('memberships', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id')->nullable()->after('id');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('set null');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id')->nullable()->after('id');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove foreign keys and columns from existing tables first
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropColumn('document_id');
        });

        Schema::table('memberships', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropColumn('document_id');
        });

        Schema::dropIfExists('documents');
    }
};
