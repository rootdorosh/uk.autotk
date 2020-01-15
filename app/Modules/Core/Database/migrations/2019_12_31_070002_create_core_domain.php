<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreDomain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('core_domains', function (Blueprint $table) {
			$table->increments('id');
			$table->string('alias');
			$table->boolean('is_active')->default('0');
			$table->string('lang')->nullable();
			$table->string('code')->nullable();
			$table->integer('rank')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('core_domains');
    }
}
