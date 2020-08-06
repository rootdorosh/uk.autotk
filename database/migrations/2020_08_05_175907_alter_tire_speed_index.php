<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Modules\Auto\Models\{
    TireSpeedIndex,
    Wheel
};

class AlterTireSpeedIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tire_speed_index', function (Blueprint $table) {
            $table->unsignedInteger('mph')->nullable()->change();
            $table->unsignedInteger('kmh')->nullable()->change();
            $table->unsignedInteger('rank')->default(0)->change();
        });

        Schema::table('auto_wheel', function (Blueprint $table) {
            $table->unsignedInteger('speed_index_id')->nullable();

            $table->foreign('speed_index_id')
                ->references('id')
                ->on('tire_speed_index')
                ->onDelete('SET NULL');
        });

        foreach (Wheel::whereRaw('speed_rating IS NOT NULL')->get() as $wheel) {
            dump($wheel->speed_rating);

            $attrs = ['code' => $wheel->speed_rating];
            $tireSpeedIndex = TireSpeedIndex::firstOrCreate($attrs, $attrs);
            $wheel->speed_index_id = $tireSpeedIndex->id;
            $wheel->save();
        }

        Schema::table('auto_wheel', function (Blueprint $table) {
            $table->dropColumn('speed_rating');
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
