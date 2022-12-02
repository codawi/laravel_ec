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
        Schema::create('delivery_settings', function (Blueprint $table) {
            $table->id();

            // 最短配送日(整数値)
            $table->integer('shortest_delivery_dates');

            // 表示する選択肢の数（整数値）
            $table->integer('options');

            // 15時以降の注文か（真偽値）
            $table->boolean('change_delivery_dates');

            // 土日配送不可（真偽値）
            $table->boolean(('delivery_not_possible'));

            // 都道府県データ（北海道、沖縄、それ以外）
            $table->integer('prefecture');

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
        Schema::dropIfExists('delivery_settings');
    }
};
