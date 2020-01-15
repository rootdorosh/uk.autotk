<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreDomainLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('core_domains_lang', function (Blueprint $table) {
			$table->increments('translation_id');
			$table->integer('domain_id')->unsigned();
			$table->string('locale', 5)->index();
			$table->string('title')->nullable();        
          
            $table->unique(['domain_id', 'locale']);
            $table->foreign('domain_id')->references('id')->on('core_domains')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('core_domains_lang');
    }
}
