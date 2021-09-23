<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSkuPropertyOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sku_proprety_option', function (Blueprint $table) {
            $table->renameColumn('property_option', 'property_option_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sku_proprety_option', function (Blueprint $table) {
            $table->renameColumn('property_option_id', 'property_option');
        });
    }
}
