<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationTranslationLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('translations_lang', function (Blueprint $table) {
			$table->increments('translation_id');
			$table->integer('trans_id')->unsigned();
			$table->string('locale', 5)->index();
			$table->string('value')->nullable();        
          
            $table->unique(['trans_id', 'locale']);
            $table->foreign('trans_id')->references('id')->on('translations')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('translations_lang');
    }
}
