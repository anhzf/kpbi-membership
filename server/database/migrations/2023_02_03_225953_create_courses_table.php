<?php

use App\Models\Enums\SemesterType;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('education_program_id');
            $table->foreign('education_program_id')->references('id')->on('education_programs')->onDelete('cascade');
            $table->string('name');
            $table->string('code');
            $table->integer('credits');
            $table->text('description')->nullable();
            $table->string('lecturer');
            $table->json('info')->nullable(); // CPMK will be stored here
            $table->enum('semester', SemesterType::toArray());
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
        Schema::dropIfExists('courses');
    }
};
