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
        Schema::create('employers', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->index();
            $table->unsignedBigInteger('vacancy_id')->index();
            $table->string('name');
            $table->string('url');
            $table->boolean('accredited_it_employer');
            $table->boolean('trusted');

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
        Schema::dropIfExists('employers');
    }
};
