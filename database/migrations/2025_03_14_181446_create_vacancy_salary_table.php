<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vacancy_salary', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vacancy_id')->index();
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
            $table->string('currency')->nullable();;
            $table->boolean('gross')->nullable();;

            $table->foreign('vacancy_id')
                ->references('id')
                ->on('vacancies')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancy_salary');
    }
};
