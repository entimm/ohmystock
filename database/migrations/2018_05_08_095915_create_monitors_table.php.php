<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->comment('代码');
            $table->boolean('going')->default(true)->comment('进行中');
            $table->date('start')->nullable()->comment('开始时间');
            $table->date('end')->nullable()->comment('结束时间');
            $table->integer('group')->comment('分组');
            $table->timestamps();
            $table->unique(['code', 'group']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitors');
    }
}
