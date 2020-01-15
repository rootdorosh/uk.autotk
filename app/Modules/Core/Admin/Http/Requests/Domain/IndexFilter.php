<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Admin\Http\Requests\Domain;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseFilter;
use App\Modules\Core\Models\Domain;

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
        return $this->user()->hasPermission('core.domain.index');
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
                    'is_active',
                    'rank',
                    'title',
                    'lang',
                ]),
            ],
            'alias' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'nullable',
                'integer',
            ],
            'rank' => [
                'nullable',
                'integer',
            ],
            'title' => [
                'nullable',
                'string',
            ],
            'lang' => [
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
        $query = Domain::select([
            'core_domains.*',
            'core_domains_lang.title AS title',
        ])
        ->leftJoin('core_domains_lang', 'core_domains_lang.domain_id', 'core_domains.id')
        ->where('core_domains_lang.locale', app()->getLocale());

        if ($this->id !== null) {
            $query->where("id", "like", "%{$this->id}%");
        }

        if ($this->alias !== null) {
            $query->where("alias", "like", "%{$this->alias}%");
        }

        if ($this->is_active !== null) {
            $query->where("is_active", "like", "%{$this->is_active}%");
        }

        if ($this->rank !== null) {
            $query->where("rank", "like", "%{$this->rank}%");
        }

        if ($this->lang !== null) {
            $query->where("lang", $this->lang);
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
                'is_active' => $row->is_active,
                'rank' => $row->rank,
                'title' => $row->title,
                'lang' => $row->lang,
            ];            
        });
    }
    

}