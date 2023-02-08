<?php

use App\Models\EducationProgramHead;
use App\Models\Enums\EducationProgramHeadStatus;
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
        Schema::create('education_program_heads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('education_programs')->onDelete('cascade');
            $table->enum('status', EducationProgramHeadStatus::toArray())->default(EducationProgramHead::DEFAULT_STATUS->value);
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
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
        Schema::dropIfExists('education_program_heads');
    }
};
