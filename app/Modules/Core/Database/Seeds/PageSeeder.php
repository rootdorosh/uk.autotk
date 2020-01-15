<?php

namespace App\Modules\Core\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Core\Models\{
    Domain,
    Page,
    Seo
};

class PageSeeder extends Seeder
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
                'alias' => 'home',
                'title' => 'Home',
                'url' => '/',
            ],
            [
                'alias' => 'wheels',
                'title' => 'Wheels',
                'url' => '/wheels/',
            ],
            [
                'alias' => 'wheels.make',
                'title' => 'Wheels make',
                'url' => '/wheels/{makeAlias}',
                'params' => [
                    'make' => 'Название марки',
                    'count' => 'Количество моделей в текущей марке, выводим числом',
                    'start_year' => 'Самый ранний год который есть в этой марки, выводим числом',
                    'start_model_year' => 'Заголовок самой ранней модели, выводим текстом',
                    'count_most_rims' => 'Определяем какая модель имеет больше всего комбинаций дисков за все годы, включая повторы. '.
                        'Логика такая: Берем модель - считаем кол-во записей у нее по дискам по каждому году, суммируем (не убираем дубли размеров дисков по годам), ' .
                        'сортируем все модели по количеству записей, и отбираем модель с самым большим количеством комбинаций. Выводим числом',
                    'model_most_rims'  => 'Также выводим заголовок данной модели из выборки выше',
                    //Все условия выше делаем для рынка EUDM
                ],
            ],
            [
                'alias' => 'wheels.make.model',
                'title' => 'Wheels make model',
                'url' => '/wheels/{makeAlias}/{modelAlias}',
            ],
        ];
        
        foreach ($items as $i => $item) {
            $page = Page::where('alias', '=', $item['alias'])->first();
            
            if ($page === null) {
                $page = Page::create([
                    'alias' => $item['alias'],
                    'title' => $item['title'],
                ]);
                
                foreach (Domain::get() as $domain) {
                    $seo = Seo::create([
                        'page_id' => $page->id,
                        'domain_id' => $domain->id,
                        'title' => $item['title'],
                        'url' => $item['url'],
                    ]);
                }
                
                echo "\t Add page: $page->alias \n";
            } else {
               unset($item['url']);
               $page->update($item); 
            }
        }        
    }
}
