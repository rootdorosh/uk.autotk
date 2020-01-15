<?php

namespace App\Modules\Core\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Core\Models\Domain;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'title' => 'United States',
                'alias' => 'autotk.com',
                'code' => 'us',
            ],
            [
                'title' => 'Great britain',
                'alias' => 'autotk.co.uk',
                'code' => 'gb',
            ],
            [
                'title' => 'Germany',
                'alias' => 'autotk.de',
                'code' => 'de',
            ],
            [
                'title' => 'France',
                'alias' => 'autotk.fr',
                'code' => 'fr',
            ],
            [
                'title' => 'Italy',
                'alias' => 'autotk.it',
                'code' => 'it',
            ],
            [
                'title' => 'Spain',
                'alias' => 'autotk.es',
                'code' => 'es',
            ],
            [
                'title' => 'Ukraine',
                'alias' => 'autotk.com.ua',
                'code' => 'ua',
            ],
            [
                'title' => 'Czech Republic',
                'alias' => 'autotk.cz',
                'code' => 'cz',
            ],
            [
                'title' => 'Switzerland',
                'alias' => 'autotk.ch',
                'code' => 'ch',
            ],
            [
                'title' => 'Switzerland',
                'alias' => 'autotk.ch',
                'code' => 'ch',
            ],
            [
                'title' => 'China',
                'alias' => 'autotk.cn',
                'code' => 'cn',
            ],
            [
                'title' => 'Sweden',
                'alias' => 'autotk.se',
                'code' => 'se',
            ]
        ];
        
        foreach ($items as $i => $item) {
            if (Domain::where('alias', '=', $item['alias'])->first() === null) {
                $item['is_active'] = 1;
                $item['rank'] = $i;
                $item['lang'] = 'en';
                
                foreach (config('translatable.locales') as $locale) {
                    $item[$locale]['title'] = $item['title'];
                }
                
                $domain = Domain::create($item);
                echo $domain->alias . "\n";
            }
        }        
    }
}
