<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('代码');
            $table->string('name')->comment('名称');

            $table->string('industry')->comment('所属行业');
            $table->string('area')->comment('地区');
            
            $table->decimal('pe', 12, 2)->comment('市盈率');
            $table->decimal('outstanding', 12, 2)->comment('流通股本(亿)');
            $table->decimal('totals', 12, 2)->comment('总股本(亿)');
            $table->decimal('totalAssets', 12, 2)->comment('总资产(万)');
            $table->decimal('liquidAssets', 12, 2)->comment('流动资产');
            $table->decimal('fixedAssets', 12, 2)->comment('固定资产');
            $table->decimal('reserved', 12, 2)->comment('公积金');
            $table->decimal('reservedPerShare', 12, 2)->comment('每股公积金');
            $table->decimal('esp', 12, 2)->comment('每股收益');
            $table->decimal('bvps', 12, 2)->comment('每股净资');
            $table->decimal('pb', 12, 2)->comment('市净率');
            $table->integer('timeToMarket')->comment('上市日期');
            $table->decimal('undp', 12, 2)->comment('未分利润');
            $table->decimal('perundp', 12, 2)->comment(' 每股未分配');
            $table->decimal('rev', 12, 2)->comment('收入同比(%)');
            $table->decimal('profit', 12, 2)->comment('利润同比(%)');
            $table->decimal('gpr', 12, 2)->comment('毛利率(%)');
            $table->decimal('npr', 12, 2)->comment('净利润率(%)');
            $table->integer('holders')->comment('股东人数');
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
        Schema::dropIfExists('base_infos');
    }
}
