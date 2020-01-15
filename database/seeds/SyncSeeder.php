<?php

use Illuminate\Database\Seeder;
use App\Modules\User\Database\Seeds\PermissionsTableSeeder;
use App\Modules\User\Database\Seeds\UsersTableSeeder;
use App\Modules\User\Database\Seeds\ConnectRelationshipsSeeder;
use App\Modules\Translation\Database\Seeds\TranslationSeeder;
use App\Modules\Core\Database\Seeds\PageSeeder;

class SyncSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->call(UsersTableSeeder::class);
       $this->call(PermissionsTableSeeder::class);
       $this->call(ConnectRelationshipsSeeder::class);
       $this->call(TranslationSeeder::class);
       $this->call(PageSeeder::class);
       
    }
}
