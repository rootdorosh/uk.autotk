<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoModelViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_model_views', function (Blueprint $table) {
            $table->integer('model_id')->unsigned();
            $table->integer('domain_id')->unsigned();
            $table->integer('create_time')->unsigned();
			
            $table->foreign('model_id')->references('id')->on('auto_model')->onDelete('cascade');                                
            $table->foreign('domain_id')->references('id')->on('core_domains')->onDelete('cascade');                                
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_model_views');
    }
}
