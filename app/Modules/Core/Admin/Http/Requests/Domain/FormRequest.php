<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Admin\Http\Requests\Domain;

use App\Base\Requests\BaseFormRequest;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Core
 *
 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->domain) ? 'store' : 'update';
        
        return $this->user()->hasPermission('core.domain.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'alias' => [
                'required',
                'string',
            ],
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'lang' => [
                'required',
                'string',
                'max:255',
            ],
            'code' => [
                'required',
                'string',
                'min:2,max:2',
            ],
            'rank' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.title'] = [
                'required',
                'string',
                'max:255',
            ];
        }
                
        return $rules;
    }
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Core', 'Domain');
    }
}