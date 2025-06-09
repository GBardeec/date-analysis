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
        Schema::table('vacancies', function (Blueprint $table) {
            $table->unsignedBigInteger('specialization_id')
                ->after('name')
                ->index();

            $table->foreign('specialization_id')
                ->references('id')
                ->on('specializations')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacancy', function (Blueprint $table) {
            $table->dropColumn('specialization_id');
        });
    }
};
