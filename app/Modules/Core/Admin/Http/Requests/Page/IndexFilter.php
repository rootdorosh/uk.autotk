<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Admin\Http\Requests\Page;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseFilter;
use App\Modules\Core\Models\Page;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Core
 *
 */
class IndexFilter extends BaseFilter
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('core.page.index');
    }
        
    /*
     * @return  array
     */
    public function rules(): array
    {
        $rules = parent::rules() + [
            'sort_attr' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'id',
                    'alias',
                    'title',
                ]),
            ],
            'alias' => [
                'nullable',
                'string',
            ],
            'title' => [
                'nullable',
                'string',
            ],
            'id' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ];
        
        return $rules;
    }
            
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
        $query = Page::query();
        if ($this->id !== null) {
            $query->where("id", "like", "%{$this->id}%");
        }

        if ($this->alias !== null) {
            $query->where("alias", "like", "%{$this->alias}%");
        }

        if ($this->title !== null) {
            $query->where("title", "like", "%{$this->title}%");
        }
        
        return $query;
    }    
    
    /*
     * @return  array
     */
    public function getData()
    {
        return $this->resolveData(function($row) {
            return [
                'id' => $row->id,
                'alias' => $row->alias,
                'title' => $row->title,
            ];            
        });
    }
    

}