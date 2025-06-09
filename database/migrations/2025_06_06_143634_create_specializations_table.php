<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('specializations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
//            $table->boolean('is_active')->nullable();
        });

        DB::table('specializations')->insert([
                ['id' => 156, 'name' => 'BI-аналитик, аналитик данных'],
                ['id' => 160, 'name' => 'DevOps-инженер'],
                ['id' => 10, 'name' => 'Аналитик'],
                ['id' => 12, 'name' => 'Арт-директор, креативный директор'],
                ['id' => 150, 'name' => 'Бизнес-аналитик'],
                ['id' => 25, 'name' => 'Гейм-дизайнер'],
                ['id' => 165, 'name' => 'Дата-сайентист'],
                ['id' => 34, 'name' => 'Дизайнер, художник'],
                ['id' => 36, 'name' => 'Директор по информационным технологиям (CIO)'],
                ['id' => 73, 'name' => 'Менеджер продукта'],
                ['id' => 155, 'name' => 'Методолог'],
                ['id' => 96, 'name' => 'Программист, разработчик'],
                ['id' => 164, 'name' => 'Продуктовый аналитик'],
                ['id' => 104, 'name' => 'Руководитель группы разработки'],
                ['id' => 157, 'name' => 'Руководитель отдела аналитики'],
                ['id' => 107, 'name' => 'Руководитель проектов'],
                ['id' => 112, 'name' => 'Сетевой инженер'],
                ['id' => 113, 'name' => 'Системный администратор'],
                ['id' => 148, 'name' => 'Системный аналитик'],
                ['id' => 114, 'name' => 'Системный инженер'],
                ['id' => 116, 'name' => 'Специалист по информационной безопасности'],
                ['id' => 121, 'name' => 'Специалист технической поддержки'],
                ['id' => 124, 'name' => 'Тестировщик'],
                ['id' => 125, 'name' => 'Технический директор (CTO)'],
                ['id' => 126, 'name' => 'Технический писатель'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specializations');
    }
};
