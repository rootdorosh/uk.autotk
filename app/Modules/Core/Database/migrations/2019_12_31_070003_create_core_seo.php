<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreSeo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('core_seo', function (Blueprint $table) {
			$table->unsignedInteger('page_id');
			$table->unsignedInteger('domain_id');
			$table->string('url')->nullable();
			$table->string('title')->nullable();
			$table->string('description')->nullable();
			$table->string('keywords')->nullable();
			$table->string('h1')->nullable();
			$table->text('header_text')->nullable();
			$table->text('footer_text')->nullable();
			$table->string('breadc_label')->nullable();
			$table->string('breadc_title')->nullable();
			$table->unique(['page_id', 'domain_id']);
			
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
        Schema::dropIfExists('core_seo');
    }
}
