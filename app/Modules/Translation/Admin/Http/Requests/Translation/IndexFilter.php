<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Admin\Http\Requests\Translation;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseFilter;
use App\Modules\Translation\Models\Translation;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Translation
 *
 */
class IndexFilter extends BaseFilter
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('translation.translation.index');
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
                    'slug',
                    'value',
                    'params',
                ]),
            ],
            'slug' => [
                'nullable',
                'string',
            ],
            'value' => [
                'nullable',
                'string',
            ],
            'params' => [
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
        $query = Translation::select([
            'translations.*',
            'translations_lang.value AS value',
        ])
        ->leftJoin('translations_lang', 'translations_lang.trans_id', 'translations.id')
        ->where('translations_lang.locale', app()->getLocale());

        if ($this->id !== null) {
            $query->where("id", "like", "%{$this->id}%");
        }

        if ($this->slug !== null) {
            $query->where("slug", "like", "%{$this->slug}%");
        }

        if ($this->params !== null) {
            $query->where("params", "like", "%{$this->params}%");
        }

        if ($this->value !== null) {
            $query->where("value", "like", "%{$this->value}%");
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
                'slug' => $row->slug,
                'value' => $row->value,
                'params' => $row->params,
            ];            
        });
    }
    

}