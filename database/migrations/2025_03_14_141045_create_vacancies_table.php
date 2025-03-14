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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->index();
            $table->string('name')->nullable();
            $table->mediumText('url')->nullable();
            $table->boolean('premium');
            $table->boolean('has_test');
            $table->boolean('response_letter_required');
            $table->json('snippet')->nullable();
            $table->timestamp('published_at');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
