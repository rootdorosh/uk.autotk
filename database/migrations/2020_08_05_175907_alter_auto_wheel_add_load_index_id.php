<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Modules\Auto\Models\{
    TireLoadIndex,
    Wheel
};

class AlterAutoWheelAddLoadIndexId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tire_load_index', function (Blueprint $table) {
            $table->unsignedInteger('pounds')->nullable()->change();
            $table->unsignedInteger('kilograms')->nullable()->change();
            $table->unsignedInteger('rank')->default(0)->change();
       });

        Schema::table('auto_wheel', function (Blueprint $table) {
            $table->unsignedInteger('load_index_id')->nullable();

            $table->foreign('load_index_id')
                ->references('id')
                ->on('tire_load_index')
                ->onDelete('SET NULL');
        });

        foreach (Wheel::whereRaw('load_index IS NOT NULL')->get() as $wheel) {
            dump($wheel->load_index);

            $attrs = ['index' => $wheel->load_index];
            $tireLoadIndex = TireLoadIndex::firstOrCreate($attrs, $attrs);
            $wheel->load_index_id = $tireLoadIndex->id;
            $wheel->save();
        }

        Schema::table('auto_wheel', function (Blueprint $table) {
            $table->dropColumn('load_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
