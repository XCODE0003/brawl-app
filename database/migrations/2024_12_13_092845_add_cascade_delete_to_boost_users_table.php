<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boost_users', function (Blueprint $table) {
            // Удаляем существующее ограничение внешнего ключа
            $table->dropForeign(['boost_id']);
            
            // Добавляем новое ограничение с cascade
            $table->foreign('boost_id')
                ->references('id')
                ->on('boosts')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('boost_users', function (Blueprint $table) {
            // Удаляем ограничение с cascade
            $table->dropForeign(['boost_id']);
            
            // Возвращаем обычное ограничение
            $table->foreign('boost_id')
                ->references('id')
                ->on('boosts');
        });
    }
};