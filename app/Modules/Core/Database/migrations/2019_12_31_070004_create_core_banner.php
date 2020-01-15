<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreBanner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('core_banners', function (Blueprint $table) {
			$table->unsignedInteger('page_id');
			$table->unsignedInteger('domain_id');
			$table->string('position');
			$table->text('content')->nullable();
			$table->unique(['page_id', 'domain_id', 'position']);
			
			$table->foreign('page_id')->references('id')->on('core_pages')->onDelete('CASCADE');
			$table->foreign('domain_id')->references('id')->on('core_domains')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('core_banners');
    }
}
