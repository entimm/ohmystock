<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDateKlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_klines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->comment('代码');
            $table->date('date')->comment('日期');
            $table->decimal('open', 8, 2)->comment('开盘价');
            $table->decimal('close', 8, 2)->comment('收盘价');
            $table->decimal('high', 8, 2)->comment('最高价');
            $table->decimal('low', 8, 2)->comment('最低价');
            $table->integer('volume')->comment('成交量');
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
        Schema::dropIfExists('date_klines');
    }
}
