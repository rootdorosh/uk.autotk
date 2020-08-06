<?php

use Illuminate\Database\Migrations\Migration;

class TireDump extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = file_get_contents(base_path() . '/database/migrations/data/tire.sql');
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
